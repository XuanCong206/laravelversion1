@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['deleteOrder']['title']])


<form action="{{ route('order.destroy', $order->id) }}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeinRight">

        <div class="row">
            <div class="col-lg-3">
                <div class="panel-head">
                    <div class="panel-title" style="font-size:16px ; font-weight:bold">Thông tin chung</div>
                    <div class="panel-description">
                        <p>- Bạn đang muốn xóa Đơn hàng có Thông tin khách hàng và Sản phẩm là : <strong
                                style="color:red">{{
                                $order->name}}</strong>
                        </p>
                        <p>- Lưu ý : Không thể khôi phục đơn hàng sau khí xóa.</p>
                    </div>
                </div>
            </div>
            {{-- Nhập thông tin người dùng mới --}}
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Tên đơn hàng
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', ($order->name) ?? '' ) }}"
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