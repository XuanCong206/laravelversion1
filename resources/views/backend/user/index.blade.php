{{-- --}}



@include('backend.dashboard.component.breadcrumb' , ['title'=> $config['seo']['index']['title']])
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $config['seo']['index']['table']}} </h5>
                    @include('backend.user.component.toolbox')
                </div>
                <div class="ibox-content">

                    {{-- Thêm filter --}}
                    @include('backend.user.component.filter')

                    {{-- Thêm table --}}
                    @include('backend.user.component.table', ['tableTitle'=> $config['seo']['index']['table']])
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
       }
</script>