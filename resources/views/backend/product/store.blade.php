@if($config['method']== 'create')
@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['createProduct']['title']])
@endif

@if($config['method']== 'edit')
@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['editProduct']['title']])
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
// Vì tạo mới sản phẩm và update sản phẩm cùng là 1 layout.
$url = ($config['method']== 'create') ? route('product.store')
: route('product.update',$product->id);
@endphp

<form action="{{ $url }}" method="POST" class="box" enctype="multipart/form-data">
    @csrf
    <div class="wrapper wrapper-content animated fadeinRight">
        <div class="row">

            {{-- Nhập thông tin sản phẩm mới --}}
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Tên sản phẩm
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', ($product->name) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Đường dẫn
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" id="productSlug" name="slug"
                                        value="{{ old('slug', ($product->slug) ?? '' ) }}" class="form-control"
                                        placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Giá
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="price" value="{{ old('price', ($product->price) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Giá khuyến mãi <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="price_motion"
                                        value="{{ old('price_motion', ($product->price_motion) ?? '' ) }}"
                                        class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>


                        </div>
                        {{-- @endif --}}

                        <div class="row mb10">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Mô tả ngắn
                                    </label>
                                    <textarea id="short_desc" name="short_desc"
                                        class="form-control">{{ old('short_desc', ($product->short_desc) ?? '' ) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb10">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Mô tả Chi Tiết
                                    </label>
                                    <textarea id="desc" name="desc" class="form-control" placeholder=""
                                        rows="4">{{ old('desc', ($product->desc) ?? '' ) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb10">
                            <div class="col-lg-6">
                                <div class="form-row py4">
                                    <label for="image" class="control-label text-left">
                                        Ảnh đại diện
                                    </label>

                                    {{-- Hiển thị ảnh hiện tại nếu có (khi sửa sản phẩm) --}}
                                    @if($config['method'] === 'edit' && $product->feature_image)
                                    <img id="preview-feature-image"
                                        src="{{ asset('storage/' . $product->feature_image) }}" alt="Ảnh đại diện"
                                        style="max-width: 100px; max-height: 100px;">
                                    @else
                                    {{-- Hiển thị khung ảnh trống nếu là tạo sản phẩm mới --}}
                                    <img id="preview-feature-image" src="https://via.placeholder.com/100"
                                        alt="Ảnh đại diện" style="max-width: 100px; max-height: 100px;">
                                    @endif

                                    {{-- Input để chọn ảnh --}}
                                    <input type="file" id="image" name="image" accept="image/*"
                                        onchange="previewImage(event)">
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-row py4">
                                    <label for="images" class="control-label text-left">
                                        Thư viện ảnh
                                    </label>
                                    {{-- Hiển thị ảnh hiện tại nếu có (khi sửa sản phẩm) --}}
                                    @if($config['method'] == 'edit' && $product->galery)
                                    <div id="gallery-preview">
                                        @foreach(json_decode($product->galery) as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image"
                                            style="max-width: 100px; max-height: 100px; margin: 2px;">
                                        @endforeach
                                    </div>

                                    @else
                                    <div id="gallery-preview">
                                        <!-- Sẽ hiển thị các ảnh mới được chọn ở đây -->
                                    </div>
                                    @endif


                                    <input type="file" id="images" name="images[]" accept="image/*" multiple
                                        onchange="previewGallery(event)">
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <div class=" col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Hành động</h3>
                        <hr>
                        <div class="row ml0">
                            <button type="submit" name="send" value="" class="btn btn-primary bg-primary">Lưu</button>
                            <button type="submit" name="send" value="" class="btn btn-secondary">Lưu
                                Thoát</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    </div>
</form>


<script>
    // Hàm JavaScript để xem trước ảnh ngay khi người dùng chọn file
    function previewImage(event) {
        var output = document.getElementById('preview-feature-image');
        output.src = URL.createObjectURL(event.target.files[0]); // Thay đổi src của ảnh xem trước
        output.onload = function() {
            URL.revokeObjectURL(output.src); // Giải phóng bộ nhớ sau khi ảnh được tải xong
        }
    }

    // Hàm JavaScript để xem trước thư viện ảnh khi người dùng chọn file
    function previewGallery(event) {
        var galleryPreview = document.getElementById('gallery-preview');
        galleryPreview.innerHTML = ""; // Xóa tất cả các ảnh hiện tại trong preview

        // Duyệt qua tất cả các file ảnh được chọn
        for (var i = 0; i < event.target.files.length; i++) {
            var imgElement = document.createElement("img");
            imgElement.src = URL.createObjectURL(event.target.files[i]); // Tạo URL tạm thời để hiển thị ảnh
            imgElement.style.maxWidth = "100px";
            imgElement.style.maxHeight = "100px";
            imgElement.style.margin = "2px";
            galleryPreview.appendChild(imgElement); // Thêm ảnh vào div preview
        }
    }


    // Khởi tạo CKEditor cho các trường mô tả
    CKEDITOR.replace('short_desc');
    CKEDITOR.replace('desc');

 
  




</script>