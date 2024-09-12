<title>Trang chi tiết sản phẩm</title>
@include('backend.dashboard.component.head')


<!-- Lightbox CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<!-- Custom CSS -->
<style>
    .thumbnail-container {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow-x: auto;
        /* Thêm thanh cuộn ngang nếu có nhiều hình ảnh */
        max-width: 100%;
        /* Đảm bảo container không bị thu hẹp */
        padding: 10px;
        border: 2px solid red;
        /* Kiểm tra xem có phải khung container gây ra vấn đề */
    }

    .thumbnail-container img {
        width: 100px;
        /* Đặt kích thước cố định cho thumbnails */
        height: 100px;
        object-fit: cover;
        /* Đảm bảo hình ảnh được cắt để vừa với kích thước */
        margin-right: 10px;
    }

    .carousel-inner {
        max-height: 300px;
        /* Điều chỉnh chiều cao nếu cần */
        overflow-y: auto;
        /* Cho phép cuộn theo chiều dọc */
    }

    img {
        max-width: 100%;
        /* Đảm bảo ảnh không bị tràn ra ngoài */
        height: auto;
    }
</style>

<!-- Sản phẩm -->
<div class="container mt-5">
    <div class="row">
        <!-- Product Image and Thumbnails -->
        <div class="col-md-6">
            <a href="{{ asset('storage/' . $product->feature_image) }}" data-lightbox="product-gallery"
                data-title="Hình sản phẩm chính">
                <img id="mainImage" src="{{ asset('storage/' . $product->feature_image) }}"
                    class="img-fluid img-responsive" alt="Hình ảnh sản phẩm chính">
            </a>
            <!-- Thumbnails -->
            @if($product->galery)
            @php
            // Giải mã chuỗi JSON thành mảng hình ảnh
            $images = json_decode($product->galery);
            @endphp

            <!-- Carousel để điều hướng qua lại các hình thu nhỏ -->
            <div id="thumbnailCarousel" class="carousel slide mt-2" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($images as $key => $image)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            <a href="{{ asset('storage/' . $image) }}" data-lightbox="product-gallery"
                                data-title="Thumbnail {{ $key + 1 }}">
                                <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                    alt="Thumbnail {{ $key + 1 }}"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Nút điều hướng trước và sau -->

            </div>
            @endif

        </div>

        <!-- Product Details -->

        <div class="col-md-6 ">

            <h1 class="product-title text-capitalize fw-bold mt-0">{{ $product->name}}</h1>
            <div class="mt-1">
                <a href="">HOME</a>
                <span> > </span>
                <a href="">Tất cả sản phẩm</a>
            </div>
            <div class="product-rating mt-2">
                <span>⭐⭐⭐⭐⭐ </span>
            </div>
            <h4 class="mt-2 "> <span class="fw-bold">Giá</span> : {{ $product->price}} VNĐ</h4>
            <h4 class="mt-2 fw-bold"> Khuyến mãi :
                <span style="color:red">{{ $product->price_motion}}</span> VNĐ
            </h4>

            <h4 class="product-description mt-2 ">
                <span class="fw-bold">Mô tả chi tiết</span> : {{ $product->desc}}</p>
            </h4>
            <h4 class="product-short-description mt-2">
                <span class="fw-bold"> Mô tả ngắn</span> : {{ $product->short_desc}}</p>
            </h4>


            <!-- Purchase Options -->
            <div class=" product-options mt-3">
                <h4 class="product-short-description mt-2">Purchase Options</h4>
                <div class="form-check border-1 mt-2 ">
                    <input class="form-check-input" type="radio" name="purchase" id="one-time" checked>
                    <label class="form-check-label" for="one-time">
                        One-time purchase
                    </label>
                </div>
                <div class="form-check border-1 mt-2">
                    <input class="form-check-input" type="radio" name="purchase" id="auto-replenish">
                    <label class="form-check-label" for="auto-replenish">
                        Auto replenish and save 10%
                    </label>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <div class="product-options  mt-3">
                <a href="/" class="btn btn-primary btn-lg buy-button">ADD TO BAG {{$product->price_motion}} VNĐ</a>
                <a href="#" class="btn btn-secondary btn-lg ms-2">Buy with ShopPay</a>

            </div>

            {{-- Choose --}}
            <h6 class="mt-3">Choose 2 free sample saches at checkout</h6>
            <h6 class="mt-3">Free shipping & returns on every order</h6>
        </div>
    </div>
</div>
<!-- Kết thuc Sản phẩm -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>