@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['delete']['title']])


<form action="{{ route('user.destroy', $user->id) }}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeinRight">

        <div class="row">
            <div class="col-lg-3">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Bạn đang muốn xóa thành viên có email là : {{ $user->email}}</p>
                        <p>Lưu ý : Không thể khôi phục thành viên sau khí xóa.</p>
                    </div>
                </div>
            </div>
            {{-- Nhập thông tin người dùng mới --}}
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Email
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="email" value="{{ old('email', ($user->email) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Họ Tên
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', ($user->name) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="send" value="" class="btn btn-primary bg-danger">Xóa dữ liệu</button>


            </div>

        </div>


    </div>
</form>