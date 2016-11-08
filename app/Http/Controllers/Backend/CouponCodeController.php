<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Grid;
use App\Models\CpHistory;
use App\Models\Backend\Coupon;
use App\Models\Backend\CpCode;
use App\Models\Backend\CpEvent;
use App\Models\Backend\EcTransactionHistory;
use App\Models\Backend\User;
use DB;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Validator;

class CouponCodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = DB::table('cp_code AS a')
            ->join('cp_event AS b', function($join){
                $join->on('a.cp_event_id', '=', 'b.id');
            })->orderBy('a.created_at', 'desc');

        $grid = new Grid( $query,
            [
                'id',
                'code' => [
                    'filter' => 'like',
                ],
                'b.name as Event' => [
                    'filter' => 'like',
                ],
                'created_at' => [
                    'filter' => false,
                    'format' => function($item){
                        return date('d M Y', $item->created_at);
                    }
                ],
            ]);
        if ($request->ajax()) {
            return $grid->table();
        }
        return view('coupon-code.index', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cpcode = new CpCode();
        $events = array_pluck(DB::table('cp_event')->where('status', 1)->get(['id','name']), 'name', 'id');
        $isNewRecord = true;
        return view('coupon-code.form', compact('cpcode', 'events', 'isNewRecord')); // folder_name.blade_name
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createRandom()
    {
        $cpcode = new CpCode();
        $events = array_pluck(DB::table('cp_event')->where('status', 1)->get(['id','name']), 'name', 'id');
        return view('coupon-code.random-form', compact('cpcode', 'events')); // folder_name.blade_name
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        if(count($input) > 0) {
            $validation = Validator::make($input, CpCode::$rules);
            if ($validation->passes()) {
                $user = \Auth::user();
                $time = time();
                $input['created_at'] = $time;
                $input['updated_at'] = $time;
                $cpcode = CpCode::create($input);
                return Redirect::route('cpcode.show', ['id' => $cpcode->id]);
            }

            if ($validation->fails()) {
                return Redirect::route('cpcode.create')
                    ->withErrors($validation)
                    ->withInput();
            }
        } else
            return abort('404', 'Input Not Found');

        return Redirect::route('cpcode.index');
    }

    public function storeRandom()
    {
        $post = Input::get();
        $result = CpCode::saveRandomCode($post);
        if($result)
            return Redirect::route('cpcode.index');

        return Redirect::route('cpcode.create-random');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $cpcode = DB::table('cp_code')->join('cp_event', 'cp_code.cp_event_id', '=', 'cp_event.id')
            ->where('cp_code.id', $id)->get(['cp_code.id', 'code', 'cp_code.status', 'amount', 'amount_type', 'name as event'])->first();

        if(count($cpcode) > 0)
            return view('coupon-code.view', compact('cpcode'));
        else
            return abort('404', 'Coupon Event Not Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $isNewRecord = false;
        $cpcode = CpCode::find($id);
        if(count($cpcode) > 0) {
            $events = array_pluck(DB::table('cp_event')->where('status', 1)->get(['id','name']), 'name', 'id');
            return view('coupon-code.form', compact('cpcode', 'events', 'isNewRecord'));
        } else {
            return abort('404', 'Coupon Event Not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $cpcode = CpCode::find($id);
        if(count($cpcode) > 0) {
            $input = Input::all();
            if(count($input) > 0) {
                $user = \Auth::user();
                $validator = Validator::make($input, ['end_date' => 'required|after:start_date']);
                if ($validator->passes()) {
                    $time = time();
                    if (empty($input['start_date']))
                        $input['start_date'] = $time;
                    else
                        $input['start_date'] = strtotime($input['start_date']);

                    if (empty($input['end_date']))
                        $input['end_date'] = $time;
                    else
                        $input['end_date'] = strtotime($input['end_date']. " 23:59");

                    $input['created_at'] = $time;
                    $input['created_by'] = $user->id;
                    if ($cpcode->update($input)) {
                        return Redirect::route('cpcode.show', ['id' => $cpcode->id]);
                    }
                } else {
                    return Redirect::route('cpcode.edit', ['id' => $cpcode->id])
                        ->withErrors($validator)
                        ->withInput();
                }

            } else
                return abort('404', 'Input Not Found');

        } else {
            return abort('404', 'Coupon Event Not Found');
        }
        return Redirect::route('cpcode.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
//        $cpcode = CpCode::find($id);
//        if($cpcode) {
//            $cpcode->delete();
//        }

        return Redirect::route('cpcode.index')->with(['message' => 'Cannot delete']);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function donate(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $users = $request->input('users');
            $code_id = $request->input('code_id');
            if(!empty($users) && !empty($code_id)){
                $users = explode(PHP_EOL, $users);
                if(!empty($users) && is_array($users)){
                    $cpCode = CpCode::find($code_id);
                    if(empty($cpCode)) {
                        return ['error_code'=>2, 'error_message'=>'Not found !'];
                    }
                    foreach($users as $username){
                        $user = User::where(['username'=>trim($username)])->first();
                        if(!empty($user->id)){
                            $res = CpHistory::checkCoupon($user->id, $cpCode->code);
                            if (!empty($res['error_code'] == 0) && !empty($res['result']->code()->first()->amount)) {
                                $return[$username] = trans('Thank you for using coupon');
                            }elseif($res['error_message']){
                                $return[$username] = $res['error_message'];
                            }
                        }
                    }
                    if(!empty($return)){
                        return $return;
                    }
                }
            }
        } else {
            $query = CpCode::from('cp_code as a');
            $query->select(['a.id', 'a.code']);
            $query->join('cp_event AS b', function ($join) {
                $join->on('a.cp_event_id', '=', 'b.id');
            })->where('b.end_date', '>', time())/*->where(['b.type'=>CpEvent::TYPE_PUBLIC])*/;
            $codes = $query->pluck('code', 'id');
            return view('coupon-code.donate', compact('codes'));
        }

    }
}
