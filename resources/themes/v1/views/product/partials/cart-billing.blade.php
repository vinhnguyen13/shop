<div class="step-checkout hide" id="wrap-billing">
    <div class="text-center">
        <h2>Thông tin thanh toán của quý khách</h2>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input name="billing_name" placeholder="Họ Tên" class="form-control" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input name="billing_address" placeholder="Địa chỉ. Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường'." class="form-control" type="text">
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
                {!! Form::select('billing_city_id', $cities, null, ['class' => 'form-control select-location select-city', 'data-child'=>'district']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                {!! Form::select('billing_district_id', ['Quận/Huyện'], null, ['class' => 'form-control select-location select-district', 'data-child'=>'ward']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                {!! Form::select('billing_ward_id', ['Phường/Xã'], null, ['class' => 'form-control select-ward']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <input name="billing_phone" placeholder="Điện thoại" class="form-control" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <input name="billing_tax_code" placeholder="Mã số thuế" class="form-control" type="text">
            </div>
        </div>
    </div>
</div>

