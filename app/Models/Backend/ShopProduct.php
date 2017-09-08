<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopProduct as Model;
use App\Models\ShopProductCategory;
use App\Models\ShopProductDiscount;
use App\Models\ShopProductImage;
use App\Models\Backend\ShopProductDetail;
use App\Models\ShopProductSpecial;
use App\Services\UploadMedia;
use Storage;
use DB;
use Carbon\Carbon;

class ShopProduct extends Model
{
    private $errors = [];

    public function gridIndex(){
        $query = DB::table('shop_product AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
                'format' => function($item){
                    $product = self::find($item->id);
                    $html = $item->name;
                    return $html;
                }
            ],
            'image' => [
                'custom' => true,
                'label' => 'Image',
                'format' => function($item){
                    $product = self::find($item->id);
                    $html = '<img width="100" src="'.$product->thumb('thumb').'">';
                    return $html;
                }
            ],
            'custom_column' => [
                'custom' => true,
                'label' => 'Product Detail',
                'format' => function($item){
                    $count = ShopProductDetail::query()->where(['product_id'=>$item->id, 'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK])->count();
                    $html = \Html::link(route('admin.product-detail.index', ['product_id'=>$item->id]), 'Total: '.$count, ['target'=>'_blank']);
                    $html .= '<a href="'.route('admin.product.import', ['product_id'=>$item->id]).'" class="btn btn-xs btn-success">Import</a>';
                    return $html;
                },
            ],
            'sku_producer',
            'stock_in',
            'stock_out',
            'created_at',
        ]);
        return $grid;
    }

    public function getImages(){
        $images = ShopProductImage::query()->where(['product_id'=>$this->id])->orderBy('order', 'asc')->get();
        $imageList = [];
        $imageService = $this->getImageService();
        if(!empty($images)){
            foreach($images as $image){
                $name = $image->image;
                $folder = $image->folder;
                $imageList[] = app(UploadMedia::class)->loadImages(
                    $name,
                    Storage::url($folder .DS. $name),
                    route('admin.deleteFile', ['_token' => csrf_token(), 'name' => $name, 'type' => UploadMedia::UPLOAD_PRODUCT, 'delete'=>UploadMedia::DELETE_REAL]),
                    'DELETE',
                    $image->id,
                    Storage::url($folder .DS. $imageService->folder('thumb') . DS . $name),
                    ['name'=>'imagesReal['.$image->id.'][]', 'value'=>$folder .DS. $name],
                    ['name'=>'orderImage['.$image->id.'][]', 'value'=>$image->order]
                );
            }
        }
        return $imageList;
    }

    public function getDiscount(){
        $discounts = ShopProductDiscount::query()->where(['product_id'=>$this->id])->orderBy('date_end', 'desc')->get();
        return $discounts;
    }

    public function getSpecial(){
        $specials = ShopProductSpecial::query()->where(['product_id'=>$this->id])->orderBy('date_end', 'desc')->get();
        return $specials;
    }

    public function getDetails(){
        $details = $this->getDetailsAvailable();
        return $details;
    }

    public function getCategories(){
        $categories = ShopProductCategory::query()->where(['product_id'=>$this->id])->get();
        if(!empty($categories)){
            $return = [];
            foreach ($categories as $category)
            {
                $return[] = $category->category_id;
            }
            return $return;
        }
    }

    public function getSizes($categoriesSelected = null){
        $categories = $categoriesSelected;
        if($categoriesSelected==null){
            $categories = $this->getCategories();
        }
        if(!empty($categories)){
            $sizes = ShopSize::query()->whereIn('category_id', $categories)->orderBy('id')->pluck('value', 'id')->prepend('- Please Select -', 0);
            return $sizes;
        }
    }

    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $instance = $this->firstOrNew($attributes);
        $instance->fill($values);
        $validate = $instance->validate($instance->attributes);
        $instance->processingSave($values);
        if ($validate->passes()) {
            DB::beginTransaction();
            try {
                $instance->save();
                $instance->processingImages($values);
                $instance->processingDiscount($values);
                $instance->processingSpecial($values);
                $instance->processingDetail($values);
                $instance->processingCategory($values);
                $instance->updateStock();
                if(empty($instance->errors)) {
                    DB::commit();
                    return $instance;
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            return $validate->getMessageBag();
        }
        if(!empty($instance->errors)){
//                $messageBag = new \Illuminate\Support\MessageBag();
            $messageBag = $validate->getMessageBag();
            foreach($instance->errors as $error){
                $messageBag->merge($error->getMessages());
            }
            return $validate->getMessageBag();
        }

    }

    /**
     * @param $values
     */
    public function processingSave($values)
    {
        if (!empty($values['date_available'])) {
            $this->attributes['date_available'] = Carbon::createFromFormat('d/m/Y', $values['date_available'])->format('Y-m-d');
        }
        $this->attributes['stock_in'] = 0;
    }
    /**
     * @param $images
     */
    public function processingImages($values)
    {
        if (!empty($values['images'])) {
            $imageService = $this->getImageService();
            foreach ($values['images'] as $key => $image) {
                $image = $image[0];
                if ($imageService->exists($image)) {
                    $newPath = app(UploadMedia::class)->getPathDay(self::uploadFolder . DS);
                    $path = pathinfo($image);
                    $imageService->moveWithSize($path['dirname'], $newPath, $path['basename']);
                    $folders = explode(DS, $path['dirname']);
                    $imageService->deleteDirectory(self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folders[2]);
                    $productImage = new ShopProductImage();
                    $productImage->fill([
                        'product_id' => $this->id,
                        'image' => $path['basename'],
                        'folder' => str_replace(DS . UploadMedia::TEMP_FOLDER . DS . $folders[2], '', $path['dirname']),
                        'order' => !empty($values['orderImage'][$key][0]) ? $values['orderImage'][$key][0] : 0,
                        'uploaded_at' => Carbon::now(),
                    ])->save();
                }
            }
        }
        if (!empty($values['orderImage'])) {
            foreach ($values['orderImage'] as $key => $value) {
                $productImage = ShopProductImage::query()->where(['id' => $key])->first();
                if(!empty($productImage)){
                    $productImage->attributes['order'] = $value[0];
                    $productImage->save();
                }
            }
        }
        $imageDefault = ShopProductImage::query()->where(['product_id' => $this->id])->orderBy('order', 'asc')->first();
        if (!empty($imageDefault)) {
            $this->attributes['image'] = $imageDefault->image;
            $this->attributes['folder'] = $imageDefault->folder;
        } else {
            $this->attributes['image'] = null;
            $this->attributes['folder'] = null;
        }
        $this->update();
        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    public function processingDiscount($values)
    {
        if (!empty($values['product_discount'])) {
            foreach ($values['product_discount'] as $key => $value) {
                $date_start = !empty($value['date_start']) ? $value['date_start'] : date('d/m/Y');
                $date_end = !empty($value['date_end']) ? $value['date_end'] : date('d/m/Y');
                if(!empty($value['id'])) {
                    $productDiscount = ShopProductDiscount::query()->where(['id' => $value['id']])->first();
                }else{
                    $productDiscount = new ShopProductDiscount();
                }
                $productDiscount->fill([
                    'product_id'=>$this->id,
                    'customer_group_id'=>$value['customer_group_id'],
                    'quantity'=>$value['quantity'],
                    'priority'=>$value['priority'],
                    'price'=>$value['price'],
                    'date_start'=>Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d'),
                    'date_end'=>Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d'),
                ]);
                $validate = $productDiscount->validate($productDiscount->attributes);
                if ($validate->passes()) {
                    $productDiscount->save();
                } else {
                    $this->errors[] = $validate->getMessageBag();
                }

            }
        }
        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    public function processingSpecial($values)
    {
        if (!empty($values['product_special'])) {
            foreach ($values['product_special'] as $key => $value) {
                $date_start = !empty($value['date_start']) ? $value['date_start'] : date('d/m/Y');
                $date_end = !empty($value['date_end']) ? $value['date_end'] : date('d/m/Y');
                if(!empty($value['id'])){
                    $productSpecial = ShopProductSpecial::query()->where(['id'=>$value['id']])->first();
                }else{
                    $productSpecial = new ShopProductSpecial();
                }
                $productSpecial->fill([
                    'product_id'=>$this->id,
                    'customer_group_id'=>$value['customer_group_id'],
                    'priority'=>$value['priority'],
                    'price'=>$value['price'],
                    'date_start'=>Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d'),
                    'date_end'=>Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d'),
                ]);
                $validate = $productSpecial->validate($productSpecial->attributes);
                if ($validate->passes()) {
                    $productSpecial->save();
                } else {
                    $this->errors[] = $validate->getMessageBag();
                }
            }
        }
        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    public function processingDetail($values)
    {
        if (!empty($values['product_detail'])) {
            foreach ($values['product_detail'] as $key => $value) {
                $productDetailID = !empty($value['id']) ? $value['id'] : null;
                $this->saveProductDetail($productDetailID, $value);
            }
        }
        return true;
    }

    /**
     * @param $values
     */
    public function processingCategory($values){
        if (!empty($values['category'])) {
            ShopProductCategory::query()->where(['product_id' => $this->id])->delete();
            foreach ($values['category'] as $catid) {
                $productCategory = new ShopProductCategory();
                $productCategory->fill([
                    'product_id' => $this->id,
                    'category_id' => $catid
                ])->save();
            }
        }
    }


    /**
     * @param $type
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteReference($type, $id)
    {
        if(!empty($type)){
            switch($type){
                case self::TYPE_DISCOUNT:
                    $model = ShopProductDiscount::query()->where(['id'=>$id]);
                    break;
                case self::TYPE_SPECIAL:
                    $model = ShopProductSpecial::query()->where(['id'=>$id]);
                    break;
                case self::TYPE_IMAGE:
                    $model = ShopProductImage::query()->where(['id'=>$id]);
                    break;
                case self::TYPE_DETAIL:
                    $productDetail = ShopProductDetail::query()->where(['id'=>$id])->first();
                    if(!empty($productDetail->attributes)){
                        $model = ShopProductDetail::query()->where(['product_id'=>$productDetail->product_id, 'supplier_id'=>$productDetail->supplier_id, 'size'=>$productDetail->size, 'new_status'=>$productDetail->new_status]);
                    }
                    break;
            }
            if(!empty($model)){
                return $model->delete();
            }
        }
        return false;
    }

    /**
     * @param $data
     */
    public function saveProductDetail($productDetailID, $data){
        if(!empty($data['price']) && !empty($data['price_in'])){
            if($data['price'] < $data['price_in']) {
                $messageBag = new \Illuminate\Support\MessageBag();
                $messageBag->add('price', 'The Price In must be less than the selling Price');
                $this->errors[] = $messageBag;
                return false;
            }
        }
        if(!empty($productDetailID)){
            $productDetail = ShopProductDetail::query()->where(['id'=>$productDetailID])->first();
            if(!empty($productDetail->attributes)) {
                $productDetail->update($data);
            }
        }else{
            if(!empty($data['total'])){
                $consignment_fee = $data['consignment_fee'];
                $consignment_fee_type = 1;
                if(empty(intval($data['consignment_fee']))){
                    $supplier = ShopSupplier::query()->where(['id'=>$data['supplier_id']])->first();
                    if($supplier){
                        $consignment_fee = $supplier->consignment_fee;
                        $consignment_fee_type = $supplier->consignment_fee_type;
                    }
                }
                $attributes = [
                    'product_id'=>$this->id,
                    'supplier_id'=>$data['supplier_id'],
                    'size'=>trim($data['size']),
                    'price_in'=>(!empty($data['price_in']) ? $data['price_in'] : 0),
                    'price'=>$data['price'],
                    'new_status'=>$data['new_status'],
                    'condition'=>$data['condition'],
                    'consignment_fee_type'=>$consignment_fee_type,
                    'consignment_fee'=>$consignment_fee,
                ];
                for($i=1;$i<=$data['total'];$i++){
                    $productDetail = new ShopProductDetail();
                    $productDetail->fill($attributes);
                    $productDetail->generateSKU();
                    $productDetail->updateStockIn();
                    $validate = $productDetail->validate($productDetail->attributes);
                    if ($validate->passes()) {
                        $productDetail->save();
                    } else {
                        $this->errors[] = $validate->getMessageBag();
//                    $this->errors[] = $validate->messages()->toArray();
                    }
                }
            }
        }
    }

    /**
     * @param $data
     */
    public function addMoreProductDetailWithSupplier($productDetailID){
        if(!empty($productDetailID)) {
            $productDetail = ShopProductDetail::query()->where(['id' => $productDetailID])->first();
            if(!empty($productDetail->id)) {
                $attributes = [
                    'product_id'=>$productDetail->product_id,
                    'supplier_id'=>$productDetail->supplier_id,
                    'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK,
                    'size'=>$productDetail->size,
                    'price_in'=>$productDetail->price_in,
                    'price'=>$productDetail->price,
                    'new_status'=>$productDetail->new_status,
                    'stock_in_date'=>Carbon::now(),
                ];
                $productDetailNew = new ShopProductDetail();
                $productDetailNew->fill($attributes);
                $productDetailNew->generateSKU();
                $validate = $productDetailNew->validate($productDetailNew->attributes);
                if ($validate->passes()) {
                    $productDetailNew->save();
                }
            }
        }
    }

    public function processingDelete(){
        $this->update(['status'=>self::STATUS_DELETE]);
    }
}
