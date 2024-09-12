{{-- Trang này sẽ hiển thị ra ngoài - nó sẽ đưa các phần được gọi ra ngoài á. --}}
@include('backend.dashboard.component.breadcrumb' , ['title'=> $config['seo']['order']['title']])
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $config['seo']['order']['table']}} </h5>
                    @include('backend.order.component.toolbox')
                </div>
                <div class="ibox-content">

                    {{-- Thêm filter --}}
                    {{-- @include('backend.user.component.filter') --}}

                    {{-- Thêm table --}}
                    @include('backend.order.component.table', ['tableTitle'=> $config['seo']['order']['table']])
                    {{-- Nhận được orders từ $orders = Order::all();
                    Lúc này trong talbe mới sử dụng được.
                    --}}

                </div>
            </div>
        </div>
    </div>
</div>