$(document).ready(function() {
    $('.rating-product').on('click', function (e) {
        var star = $('#rating-star').rateit('value');
        var productID = $('#rating-star').data('id');
        var comment = $('.comment').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '/rating',
            data: {
                'product_id': productID,
                'rating': star,
                'comment': comment,
            },
            success: function () {
                swal({
                    icon: 'success',
                    title: 'Đánh giá thành công',
                    text: 'Bạn đã đánh giá sản phẩm này!',
                    button: false,
                    timer: 1500
                });
                $('.ratting-form-wrapper').remove();
                $('#rating-star').rateit('readonly', true);
            }
        });
    });
});
