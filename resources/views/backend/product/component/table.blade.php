<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>

            <th class="text-center">Ảnh</th>
            <th class="text-center">Tên sản phẩm</th>
            <th class="text-center">Đường dẫn </th>
            <th class="text-center">Mô tả chi tiết</th>
            <th class="text-center">Mô tả ngắn</th>
            <th class="text-center">Giá</th>
            <th class="text-center">Giá khuyến mại</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-center">Thư viện ảnh</th>
            <th class="text-center">Thao Tác</th>

        </tr>
    </thead>
    <tbody>

        @if(isset($products) && is_object($products))
        {{-- Lặp qua từng element trong bảng product gán cho product --}}
        @foreach($products as $product)
        <tr>
            <td>
                <input type="checkbox" value="" class="input-checkbox checkBox-item">
            </td>
            <td class="text-center">
                <img src="{{ asset('storage/' . $product->feature_image) }}" alt="Ảnh đại diện"
                    style="max-width: 100px; max-height: 100px;" />
            </td>
            <td class="text-center">
                {{ $product->name}}
            </td>
            <td class="text-center">
                <a href="{{ route('product.show', ['slug' => $product->slug]) }}">
                    {{ $product->slug }}
                </a>
            </td>
            <td class="text-center">
                {{ $product->desc}}
            </td>
            <td class="text-center">
                {{ $product->short_desc}}
            </td>
            <td class="text-center">
                {{ $product->price}}
            </td>
            <td style="color:red" class="text-center">
                {{ $product->price_motion}}
            </td>

            <td class="text-center">
                {{ $product->status}}
            </td>
            <td style="display:flex;" class="text-center">
                @if($product->galery)
                @php
                $images = json_decode($product->galery);
                $maxImages = 2;
                $displayedImages = array_slice($images, 0, $maxImages);
                @endphp

                @foreach($displayedImages as $image)
                <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image"
                    style="max-width: 50%; max-height: 100px; margin: 2px;" />
                @endforeach

                @if(count($images) > $maxImages)
                <span>...</span>
                @endif
                @else
                <p>Không có ảnh</p>
                @endif
            </td>
            <td class="text-center">
                <a href="{{ route('product.edit', $product->id)}}" class="btn btn-success"><i
                        class="fa fa-edit"></i></a>
                <a href="{{ route('product.delete', $product->id)}}" class="btn btn-danger"><i
                        class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7" class="text-center">Không có sản phẩm nào</td>
        </tr>
        @endif
    </tbody>
</table>