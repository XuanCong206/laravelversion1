@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['deleteProduct']['title']])


<form action="{{ route('product.destroy', $product->id) }}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeinRight">

        <div class="row">
            <div class="col-lg-3">
                <div class="panel-head">
                    <div class="panel-title" style="font-size:16px ; font-weight:bold">Thông tin chung</div>
                    <div class="panel-description">
                        <p>- Bạn đang muốn xóa Sản phẩm có Tên là : <strong style="color:red">{{
                                $product->name}}</strong>
                        </p>
                        <p>- Lưu ý : Không thể khôi phục sản phẩm sau khí xóa.</p>
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
                                        Tên sản phẩm
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', ($product->name) ?? '' ) }}"
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