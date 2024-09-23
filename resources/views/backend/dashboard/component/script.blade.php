<!-- Mainly scripts -->

<script src="backend/js/bootstrap.min.js"></script>
<script src="backend/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="backend/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="backend/library/library.js"></script>

<script src="backend/library/library.js"></script>
<script src="backend/library/order.js"></script>


<!-- jQuery UI -->
<script src="backend/js/plugins/jquery-ui/jquery-ui.min.js"></script>

{{-- Sau khi compact từ Controller để sử dụng.
Đây là 1 mảng -> có thể loop mảng để lấy ra từng phần tử trong mảng
--}}


@if(isset($config['js']) && is_array($config['js']))
@foreach ($config['js'] as $key => $value)
{!! '<script src="' .$value.  '"></script>' !!}
@endforeach
@endif