<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>

            <th class="text-center">Thông tin khách hàng</th>
            <th class="text-center">Thông tin Người nhận</th>
            <th class="text-center">Đơn hàng</th>
            <th class="text-center">Sản phẩm</th>
            <th class="text-center">Số lượng</th>
            <th class="text-center">Tổng tiền</th>
            <th class="text-center">Tình Trạng</th>
            <th class="text-center">Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        @php
        // dd($order_products);
        @endphp

        @if(isset($orders) && $orders->count())

        {{-- Lặp qua từng element trong bảng orders gán cho order --}}
        @foreach($orders as $order)
        {{-- @foreach($products as $product) --}}
        <tr>
            <td>
                <input type="checkbox" value="" class="input-checkbox checkBox-item">
            </td>
            {{-- Khách hàng : Lấy từ bảng users .--}}
            <td>
                <strong>Tên :</strong> {{ $order->user->name ?? 'N/A' }}<br>
                <strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}<br>
                <strong>SĐT:</strong> {{ $order->user->phone ?? 'N/A' }}<br>
                <strong>Địa chỉ:</strong> {{ $order->user->address ?? 'N/A' }}
            </td>
            {{-- Người nhận : Lấy từ bảng orders--}}
            <td>
                <strong>Tên :</strong> {{ $order->name ?? 'N/A' }}<br>
                <strong>Email :</strong> {{ $order->email ?? 'N/A' }}<br>
                <strong>SĐT :</strong> {{ $order->phone ?? 'N/A' }}<br>
                <strong>Địa chỉ :</strong> {{ $order->address ?? 'N/A' }}
            </td>


            <td class="text-center">
                {{ $order->order_number ?? 'N/A' }}
            </td>

            {{-- Tên sản phẩm --}}
            <td class="text-center">
                @if($order->products->count() > 0)
                @php $index = 1 ; @endphp
                @foreach($order->products as $product)
                <div class="p10">
                    <strong>{{ $index }} . {{ $product->pivot->product_name }}</strong><br>
                </div>
                @php $index++; @endphp {{-- Tăng biến đếm lên 1 sau mỗi lần lặp --}}

                @endforeach
                @else
                Không có sản phẩm
                @endif
            </td>

            {{-- Số lượng --}}
            <td class="text-center ">
                @if($order->products->count() > 0)
                @php $index = 1 ; @endphp
                @foreach($order->products as $product)
                <div class="p10">
                    <strong>{{ $index }} . {{ $product->pivot->quantity }}</strong><br>
                </div>
                @php $index++; @endphp
                @endforeach
                @endif
            </td>

            {{-- Tổng tiền--}}
            <td class="text-center fs-16-red">

                {{ ($order->total_amount) ?? 'N/A' }}
            </td>
            <td class="text-center fs-16-red">
                {{-- {{ $order->total_amount ?? 'N/A' }} --}}
            </td>
            <td class="text-center">
                <a href="{{ route('order.edit',$order->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="{{ route('order.delete',$order->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        {{-- @endforeach --}}
        @else
        <tr>
            <td colspan="7" class="text-center">Không có đơn hàng nào</td>
        </tr>
        @endif
    </tbody>
</table>