<div class="step-checkout" id="wrap-shipping">
    <div class="text-center">
        <h2>Địa chỉ giao hàng của quý khách</h2>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input name="shipping_name" placeholder="Họ Tên" class="form-control" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input name="shipping_address" placeholder="Địa chỉ. Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường'." class="form-control" type="text">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input name="email" placeholder="E-Mail" class="form-control" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <?php
                $cities = \App\Models\SysCity::query()->orderBy('id')->pluck('name', 'id')->prepend('Tỉnh/Thành phố', 0);
                ?>
                {!! Form::select('shipping_city_id', $cities, null, ['class' => 'form-control select-location select-city', 'data-child'=>'district']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                {!! Form::select('shipping_district_id', ['Quận/Huyện'], null, ['class' => 'form-control select-location select-district', 'data-child'=>'ward']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                {!! Form::select('shipping_ward_id', ['Phường/Xã'], null, ['class' => 'form-control select-ward']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <input name="shipping_phone" placeholder="Điện thoại" class="form-control" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="comment" placeholder="Lưu ý"></textarea>
            </div>
        </div>
    </div>
</div>

