@if($config['method']== 'create')
@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['createOrder']['title']])


@endif

@if($config['method']=='edit')
@include('backend.dashboard.component.breadcrumb',
['title'=> $config['seo']['editOrder']['title']])

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

{{-- Vì tạo và sửa đơn hàng dùng chung 1 layout. --}}
@php
$url = ($config['method'] == 'create') ? route('order.store') : route('order.update', $order->id);
@endphp
@php
// dd($products);
@endphp

<div class="ibox-content">
    <form action="{{ $url }}" method="POST">
        @csrf
        {{-- Ô khách hàng --}}
        <div class="row mb10">
            <div class="col-lg-6">
                <div class="form-group setupSelect2">
                    <label for="user_id">Tài khoản</label>
                    <select id="user_id_edit" name="user_id" class="form-control">
                        <option value="">Danh sách khách hàng</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" data-email="{{ $user->email }}" data-name="{{ $user->name }}"
                            data-phone="{{ $user->phone }}" data-address="{{ $user->address }}" {{ isset($selectedUser)
                            && $selectedUser->id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} - {{ $user->phone }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Hiển thị người dùng khi select được chọn --}}
                <div id="user-info" class="ibox-content2" style="display: none;">
                    <h3 class="user-info-title">Thông tin người dùng:</h3>
                    <p id="user-email"></p>
                    <p id="user-name"></p>
                    <p id="user-phone"></p>
                    <p id="user-address"></p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="order_number">Order Number</label>
                    <input type="text" name="order_number" class="form-control" value="{{ $order->order_number ?? '' }}"
                        readonly>
                </div>
            </div>
        </div>



        {{-- Ô sản phẩm --}}
        <div class="row mb10 df-atc" id="product-container">
            <div class="col-lg-12">
                <div class="form-group setupSelect2">
                    <label for="product_id">Sản phẩm</label>
                    <select id="product-select" name="product_id" class="form-control">
                        <option value="">Danh sách sản phẩm</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                            data-desc="{{ $product->desc }}" data-short_desc="{{ $product->short_desc }}"
                            data-price="{{ $product->price }}" data-price_motion="{{ $product->price_motion }}"
                            data-feature_image="{{ $product->feature_image }}" {{ isset($selectedProduct) &&
                            $selectedProduct->id ==
                            $product->id
                            ? 'selected' : '' }}>
                            {{ $product->name }} - Giá: {{ $product->price }} - Giá Khuyến Mãi : {{
                            $product->price_motion }}
                        </option>

                        @endforeach
                    </select>
                </div>

                <!-- Bảng chứa sản phẩm được chọn -->
                <table id="product-table"
                    style="width: 100%; border-collapse: collapse; margin-top: 20px; display: none;"
                    class="table-bordered">
                    <thead>
                        <tr>
                            <th class="fs-16" style="width: 10%; text-align: center; ">Hình ảnh</th>
                            <th class="fs-16" style="width: 40%; text-align: center;">Tên sản phẩm và mô tả</th>
                            <th class="fs-16" style="width: 30%; text-align: center;">Giá</th>
                            <th class="fs-16" style="width: 10%; text-align: center;">SL</th>
                            <th class="fs-16" style="width: 10%; text-align: center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="selected-products">
                        <!-- Các hàng sản phẩm sẽ hiển thị ở đây -->
                    </tbody>
                </table>

                <!-- Hiển thị tổng giá trị đơn hàng -->
                <div id="total-amount-container" class="total-amount-container"
                    style="display: none; margin-top: 20px;">
                    <p class="heading-total-amount">Tổng giá trị đơn hàng: <span id="total-amount"
                            class="total-amount">0</span>,<span class="total-amount">000</span> VNĐ</p>
                </div>

            </div>

        </div>



        {{-- Phần thông tin khách nhận --}}
        {{-- Form thông tin người dùng (chỉ hiển thị khi tạo mới hoặc có tài khoản được chọn) --}}
        <div id="user-form">
            <div class="form-group">
                <div class="col-lg-6 p0 mb20">
                    <label for="email" class="control-label text-left">
                        Email <span class="text-danger">(*)</span>
                    </label>

                    <input type="text" name="email" class="form-control"
                        value="{{ isset($order) ? $order->email : '' }}" placeholder="" autocomplete="off">
                </div>
                <div class="col-lg-6 p0 mb20">
                    <label for="name" class="control-label text-left">
                        Họ Tên <span class="text-danger">(*)</span>
                    </label>
                    <input type="text" name="name" class="form-control" value="{{ isset($order) ? $order->name : '' }}"
                        placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="form-group mb20">
                <div class="col-lg-6 p0 mb20">
                    <label for="phone" class="control-label text-left">
                        Số điện thoại <span class="text-danger">(*)</span>
                    </label>
                    <input type="text" name="phone" class="form-control"
                        value="{{ isset($order) ? $order->phone : '' }}" placeholder="" autocomplete="off">
                </div>
                <div class="col-lg-6 p0 mb20">
                    <label for="address" class="control-label text-left">
                        Địa chỉ <span class="text-danger">(*)</span>
                    </label>
                    <input type="text" name="address" class="form-control"
                        value="{{ isset($order) ? $order->address : '' }}" placeholder="" autocomplete="off">
                    <input type="hidden" name="total_amount">
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


{{-- Lấy đơn hàng qua edit/ --}}
<script>
    @if(isset($order))
        // Dữ liệu sản phẩm trong đơn hàng khi đang chỉnh sửa
        var productsInOrder = @json($order->products);
    @else
        // Nếu không có đơn hàng (trường hợp tạo mới)
        var productsInOrder = [];
    @endif
</script>