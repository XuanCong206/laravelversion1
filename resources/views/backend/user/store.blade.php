@if($config['method']== 'create')
@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['createProduct']['title']])
@endif

@if($config['method']== 'edit')
@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['editUser']['title']])
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@php
$url = ($config['method']== 'create') ? route('user.store')
: route('user.update',$user->id);
@endphp

<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeinRight">
        <div class="row">
            {{-- Nhập thông tin người dùng mới --}}
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Email
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="email" value="{{ old('email', ($user->email) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Họ Tên
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', ($user->name) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>


                        </div>

                        {{-- @if($config['method'] == 'create') --}}
                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Mật khẩu
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="password" name="password" value="" class="form-control" placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Nhập lại mật khẩu <span
                                            class="text-danger">(*)</span></label>
                                    <input type="password" name="re_password" value="" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>


                        </div>
                        {{-- @endif --}}

                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Số điện thoại

                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone', ($user->phone) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>

                            @php

                            @endphp

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Ngày sinh

                                    </label>
                                    <input type="date" name="birthday"
                                        value="{{ old('birthday', (isset($user->birthday)) ? date('Y-m-d', strtotime($user->birthday)) : '') }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>


                        </div>

                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Giới tính
                                    </label>
                                    <select name="user_gender" class="form-control">
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                        <option value="2">Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Địa chỉ </label>
                                    <input type="text" name="address"
                                        value="{{ old('addresss', ($user->address) ?? '') }}" class="form-control"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="row mb10">
                            <div class="col-lg-12">
                                <div class="form-row py4">
                                    <label for="" class="control-label text-left">
                                        Ảnh đại diện
                                    </label>
                                    <input type="text" name="img" value="{{ old('img', ($user->ing) ?? '' ) }}"
                                        class="form-control upload-image" placeholder="" autocomplete="off"
                                        data-upload="Images">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Hành động</h3>
                        <hr>
                        <div class="row ml0">
                            <button type="submit" name="send" value="" class="btn btn-primary bg-primary">Lưu</button>
                            <button type="submit" name="send" value="" class="btn btn-secondary">Lưu Thoát</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Phần phường xã --}}
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Thành Phố</label>
                                    <select name="province_id" class="form-control setupSelect2 province location"
                                        data-target="districts">
                                        <option value="0">[Chọn Thành Phố]</option>
                                        @if(isset($provinces))
                                        @foreach($provinces as $province)
                                        <option @if(old('province_id')==$province->code) selected
                                            @endif value="{{$province->code }}">{{ $province->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Quận/Huyện </label>
                                    <select name="district_id" class="form-control districts setupSelect2 location"
                                        data-target="wards">
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Phường/Xã </label>
                                    <select name="ward_id" class="form-control setupSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row mb10">

                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Ghi chú</label>
                                    <input type="text" name="description"
                                        value="{{ old('description', ($user->description) ?? '') }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-3">
                <div class="panel-head ibox-content">
                    <div class="panel-title">Thông tin liên hệ</div>
                    <div class="panel-description">Nhập thông tin liên hệ của người sử dụng</div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>


<script>
    var province_id = '{{ old('province_id') }}';,
    var district_id = '{{ old('district_id') }}';,
    var ward_id = '{{ old('ward_id') }}';,
</script>