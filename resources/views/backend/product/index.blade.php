{{-- Trang này sẽ hiển thị ra ngoài - nó sẽ đưa các phần được gọi ra ngoài á. --}}
@include(
'backend.dashboard.component.breadcrumb' ,
['title'=> $config['seo']['product']['title']]
)
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $config['seo']['product']['table']}} </h5>
                    @include('backend.product.component.toolbox')
                </div>
                <div class="ibox-content">

                    {{-- Thêm table --}}
                    @include('backend.product.component.table', ['tableTitle'=> $config['seo']['product']['table']])


                </div>
            </div>
        </div>
    </div>
</div>