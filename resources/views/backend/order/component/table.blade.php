<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>

            <th class="text-center">Thông tin khách hàng</th>
            <th class="text-center">Thông tin Người nhận</th>

            <th class="text-center">Đơn hàng</th>
            <th class="text-center">Tổng tiền</th>
            <th class="text-center">Tình Trạng</th>
            <th class="text-center">Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($orders) && $orders->count())

        {{-- Lặp qua từng element trong bảng orders gán cho order --}}
        @foreach($orders as $order)
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

            <td class="text-center">
                {{ $order->formatted_total_amount ?? 'N/A' }}
            </td>
            <td class="text-center">
                {{ $order->status ?? 'N/A' }}
            </td>
            <td class="text-center">
                <a href="" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i
                        class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7" class="text-center">Không có đơn hàng nào</td>
        </tr>
        @endif
    </tbody>
</table>