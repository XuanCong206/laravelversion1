$(document).ready(function () {
    var currentUrl = window.location.href;

    var isEditMode = currentUrl.includes("/edit"); // Kiểm tra nếu đang ở chế độ chỉnh sửa

    // Kiểm tra nếu URL chứa 'edit', hiển thị bảng sản phẩm
    if (isEditMode) {
        console.log("Chế độ edit: Hiển thị bảng sản phẩm");

        // Hiển thị form chỉnh sửa và bảng sản phẩm
        $("#user-form").show(); // Hiển thị form chỉnh sửa với dữ liệu từ order
        $("#product-table").show(); // Hiển thị bảng sản phẩm
        $(".setupSelect2").show(); // Ẩn dropdown tài khoản (nếu không cần dùng)

        // Disable dropdown tài khoản nếu cần
        $('select[name="user_id"]').prop("disabled", true);
    }

    // Lắng nghe sự kiện thay đổi của dropdown "user_id" và chỉ thực hiện khi có thay đổi
    $('select[name="user_id"]').on("change", function () {
        var selectedOption = $(this).find("option:selected");
        updateUserInfo(selectedOption);
    });

    // Lắng nghe sự kiện thay đổi của dropdown "product_id"
    $('select[name="product_id"]').on("change", function () {
        var selectedOption = $(this).find("option:selected");

        // Kiểm tra nếu đã chọn sản phẩm
        if (selectedOption.val()) {
            // Kiểm tra nếu sản phẩm đã được chọn trước đó
            if ($("#product-row-" + selectedOption.val()).length > 0) {
                alert(
                    "Sản phẩm này đã được chọn. Vui lòng chọn sản phẩm khác."
                );
                return; // Không thêm lại sản phẩm
            }
            // Hiển thị phần tiêu đề bảng nếu bảng đang bị ẩn
            if ($("#product-table").is(":hidden")) {
                $("#product-table").show(); // Hiển thị bảng
                $("#total-amount-container").show(); // Hiển thị tổng giá trị
            }

            // Tạo hàng sản phẩm mới trong bảng
            var productRow = createProductRow(selectedOption);

            // Thêm hàng sản phẩm vào bảng
            $("#selected-products").append(productRow);

            // Tính lại tổng giá trị đơn hàng
            calculateTotalAmount();
        }
    });

    // Xóa sản phẩm khỏi danh sách
    $(document).on("click", ".remove-product", function () {
        var productId = $(this).data("product-id");
        $("#product-row-" + productId).remove(); // Xóa hàng sản phẩm

        // Ẩn bảng nếu không còn sản phẩm nào
        if ($("#selected-products tr").length === 0) {
            $("#product-table").hide(); // Ẩn bảng
        }
        // Reset lại giá trị của select để có thể chọn lại
        $("#product-select").val("").trigger("change");

        // Tính lại tổng giá trị đơn hàng
        calculateTotalAmount();
    });

    // Lắng nghe sự kiện thay đổi số lượng
    $(document).on("change", ".quantity-input", function () {
        // Tính lại tổng giá trị đơn hàng mỗi khi số lượng thay đổi
        calculateTotalAmount();
    });

    // Hàm tính tổng giá trị đơn hàng
    function calculateTotalAmount() {
        var totalAmount = 0;

        // duyệt qua từng sản phẩm để tính tổng.
        $(".product-row").each(function () {
            var quantity = $(this).find(".quantity-input").val();
            var price = $(this).find(".quantity-input").data("price");
            var priceMotion = $(this)
                .find(".quantity-input")
                .data("price-motion");

            // Nếu có giá khuyến mãi và giá khuyến mãi nhỏ hơn giá gốc
            var finalPrice =
                priceMotion && priceMotion < price ? priceMotion : price;

            // Tính tổng giá trị cho sản phẩm này
            totalAmount += finalPrice * quantity;
        });
        // Cập nhật tổng giá trị đơn hàng
        $("#total-amount").text(totalAmount.toLocaleString());
        $('input[name="total_amount"]').val(totalAmount);
    }

    // Hàm cập nhật thông tin người dùng và điền vào form khi chọn từ dropdown
    function updateUserInfo(selectedOption) {
        var name = selectedOption.data("name");
        var email = selectedOption.data("email");
        var phone = selectedOption.data("phone");
        var address = selectedOption.data("address");

        // Kiểm tra nếu có thông tin người dùng được chọn
        if (name && phone && email && address) {
            $("#user-info").show(); // Hiển thị thông tin người dùng
            $("#user-email").text("Email: " + email);
            $("#user-name").text("Tên: " + name);
            $("#user-phone").text("Số điện thoại: " + phone);
            $("#user-address").text("Địa chỉ: " + address);

            // Điền thông tin vào form
            $('input[name="name"]').val(name);
            $('input[name="email"]').val(email);
            $('input[name="phone"]').val(phone);
            $('input[name="address"]').val(address);
        } else {
            $("#user-info").hide(); // Ẩn thông tin nếu không có dữ liệu
        }
    }

    // Hàm định dạng số
    function formatPrice(price) {
        // Thêm ba số 0
        price = price * 1000;
        // Định dạng số với dấu phẩy
        return price.toLocaleString("vi-VN");
    }

    // Hàm hiển thị html bảng sản phẩm cho chế độ chỉnh sửa (edit mode)
    // Hàm hiển thị html bảng sản phẩm cho chế độ chỉnh sửa (edit mode)
    function createProductRow(selectedOption, isEditMode = false) {
        var originalPrice = parseFloat(selectedOption.data("price"));
        var promotionPrice =
            parseFloat(selectedOption.data("price_motion")) || originalPrice;

        var formattedPrice = formatPrice(originalPrice);
        var formattedPromotionPrice = formatPrice(promotionPrice);

        var displayPrice =
            originalPrice < promotionPrice
                ? formattedPrice
                : formattedPromotionPrice;
        var priceLabel = originalPrice < promotionPrice ? "Giá" : "Giá";

        return `
        <tr class="product-row" id="product-row-${selectedOption.val()}">
            <td style="text-align: center;">
                <img class="product-feature_image" src="/storage/${selectedOption.data(
                    "feature_image"
                )}"
                    alt="Feature Image" style="max-width: 90%; height: 100px; object-fit:cover" />
            </td>
            <td style="text-align: center;">
                <p class="product-name-fix" style="font-weight: bold;"> ${selectedOption.data(
                    "name"
                )}</p>  
            </td>
            <td style="text-align: center;">
                <p class="product-price-fix" style="font-weight: bold;">${priceLabel}: ${displayPrice} VNĐ</p>
            </td>
            <td style="text-align: center;">
                <label for="quantity">Số lượng</label>
                <input type="number" name="products[${selectedOption.val()}][quantity]" class="quantity-input" 
                    min="1" value="${selectedOption.data(
                        "quantity"
                    )}" style="width: 50px;" 
                    data-price="${selectedOption.data("price")}" 
                    data-price-motion="${selectedOption.data(
                        "price_motion"
                    )}" ${isEditMode ? "readonly" : ""}>
                <input type="hidden" name="products[${selectedOption.val()}][id]" value="${selectedOption.val()}">
                <input type="hidden" name="products[${selectedOption.val()}][price_motion]" value="${selectedOption.data("price_motion")}">
            </td>
            <td style="text-align: center;">
                ${
                    isEditMode
                        ? ""
                        : `<button type="button" class="btn btn-danger remove-product" data-product-id="${selectedOption.val()}">Xóa</button>`
                }
            </td>
        </tr>`;
    }

    // Kiểm tra nếu có sản phẩm trong đơn hàng (dữ liệu từ PHP)
    if (productsInOrder.length > 0) {
        productsInOrder.forEach(function (product) {
            // Tạo đối tượng mô phỏng selectedOption dựa trên dữ liệu sản phẩm từ server
            var selectedOption = {
                val: function () {
                    return product.id;
                },
                data: function (key) {
                    switch (key) {
                        case "price":
                            return product.pivot.price_at_order_time; // Đảm bảo rằng bạn sử dụng đúng trường lưu giá
                        case "price_motion":
                            return product.pivot.price_motion || null; // Giá khuyến mãi nếu có
                        case "name":
                            return product.name;
                        case "feature_image":
                            return product.feature_image; // Hình ảnh sản phẩm
                        case "quantity":
                            return product.pivot.quantity; // Số lượng
                        default:
                            return null;
                    }
                },
            };

            // Gọi hàm createProductRow để thêm sản phẩm vào bảng
            var productRow = createProductRow(selectedOption, isEditMode);

            // Thêm sản phẩm vào bảng
            $("#selected-products").append(productRow);
        });

        // Hiển thị bảng sản phẩm
        $("#product-table").show();

        $("#total-amount-container").show(); // Hiển thị tổng giá trị

        // Tính tổng giá tiền của đơn hàng
        calculateTotalAmount();
    }
});
