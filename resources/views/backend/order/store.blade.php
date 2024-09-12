@include('backend.dashboard.component.breadcrumb', ['title'=> $config['seo']['order']['title']])

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        @endforeach
    </ul>
</div>
@endif

<div class="ibox-content">
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="row mb10">
            <div class="col-lg-6">
                <div class="form-group setupSelect2">
                    <label for="user_id">Tài khoản</label>
                    <select name="user_id" class="form-control">
                        <option value="">Danh sách khách hàng</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" data-email="{{ $user->email }}" data-name="{{ $user->name }}"
                            data-phone="{{ $user->phone }}" data-address="{{ $user->address }}">{{ $user->name }} - {{
                            $user->phone }}</option>
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
                    <input type="text" name="order_number" class="form-control" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="text" name="total_amount" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <d iv id="user-form" style="display: none;">
            <div class="form-group">
                <div class="col-lg-6 p0 mb20">
                    <label for="email" class="control-label text-left">
                        Email
                        <span class="text-danger">(*)</span>
                    </label>
                    <input type="text" name="email" class="form-control" placeholder="" autocomplete="off">
                </div>
                <div class="col-lg-6 p0 mb20">
                    <label for="name" class="control-label text-left">
                        Họ Tên
                        <span class="text-danger">(*)</span>
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="form-group mb20">
                <div class="col-lg-6 p0 mb20">
                    <div class="form-row">
                        <label for="phone" class="control-label text-left">
                            Số điện thoại
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="text" name="phone" class="form-control" placeholder="" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-6 p0">
                    <div class="form-row mb20">
                        <label for="address" class="control-label text-left">
                            Địa chỉ
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="text" name="address" class="form-control" placeholder="" autocomplete="off">
                    </div>
                </div>
            </div>
        </d>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('select[name="user_id"]').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var name = selectedOption.data('name');
            var phone = selectedOption.data('phone');
            var email = selectedOption.data('email');
            var address = selectedOption.data('address');

            // Hiển thị thông tin người dùng
            if (name && phone) {
                $('#user-info').show();
                $('#user-email').text('Email: ' + email);
                $('#user-name').text('Tên: ' + name);
                $('#user-phone').text('Số điện thoại: ' + phone);
                $('#user-address').text('Địa chỉ: ' + address);
            }
            
            // Hiển thị form và điền thông tin
            if (name && phone && email && address) {
                $('#user-form').show();
                $('input[name="name"]').val(name);
                $('input[name="phone"]').val(phone);
                $('input[name="email"]').val(email);
                $('input[name="address"]').val(address);
            } else {
                $('#user-form').hide();
            }
        });
    });
</script>