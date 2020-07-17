$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    $('.quantity').blur(function() {
        var id = $(this).data('id');
        var quantity = $(this).val();
        var price = $('#price-' + id).data('value');
        var totalPrice = quantity*price;
        $.ajax({
            url: 'cart/' + id,
            type: 'put',
            dataType: 'json',
            data: {
                id: id,
                quantity: $(this).val(),
                price: price
            },
            success: function (data) {
                if (data.error) {
                    toastr.error(data.error, 'Notification', {timeOut: 5000});
                } else {
                    $('#total-price-item-' + id).html('&#36;' + totalPrice);
                    $('#grand-total').html('&#36;' + data.grandTotal);
                    $('.total-price').html('&#36;' + data.grandTotal);
                    toastr.success(data.result, 'Notification', {timeOut: 5000});
                }
            }
        });
    });

    $('.add-to-cart').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'add-cart/' + id,
            type: 'post',
            dataType: 'json',
            data: {
                product_id: id,
            },
            success: function (data) {
                if (data.error) {
                    toastr.error(data.error, 'Notification', {timeOut: 5000});
                } else {
                    $('#count-cart').html(data.countCart);
                    $('.total-price').html('&#36;' + data.totalPrice);
                    toastr.success(data.result, 'Notification', {timeOut: 5000});
                }
            }
        });
    });

    $('.add-to-favourites').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'add-to-favourites/' + id,
            type: 'post',
            dataType: 'json',
            data: {
                product_id: id,
            },
            success: function (data) {
                if (data.error) {
                    toastr.error(data.error, 'Notification', {timeOut: 5000});
                } else {
                    $('#count-favourites').html(data.countFavourites);
                    toastr.success(data.result, 'Notification', {timeOut: 5000});
                }
            }
        });
    });
});

$('.payment').on('click', function() {
    var note =  $('.note').val();
    var totalPrice = $('.grand-total').text();
    totalPrice = totalPrice.replace('$', '');
    var paymentType = $('input[name=payment_type]:checked').val();
    $.ajax({
        url : 'checkout',
        data : {
            note : note,
            total_price : totalPrice,
            payment_type : paymentType,
        },
        dataType : 'json',
        type : 'post',
        success : function(data) {
            if (data.error) {
                toastr.error(data.error, 'Notification', {timeOut: 5000});
            } else {
                swal({
                    icon: 'success',
                    title: 'Thanh toán thành công',
                    text: 'Bạn đã yêu cầu thanh toán đơn hàng!',
                    button: false,
                    timer: 3000
                });
                setTimeout(function(){
                    window.location.href = '/homepage';
                }, 2000);
            }
        }
    });
});

$('.send-suggest').on('click', function() {
    var suggest = $('.suggest').val();
    $.ajax({
        url: 'suggests',
        data: {
            suggest: suggest,
        },
        dataType: 'json',
        type: 'post',
        success: function (data) {
            if (data.error) {
                toastr.error(data.error, 'Notification', {timeOut: 5000});
            } else {
                swal({
                    icon: 'success',
                    title: 'Đề xuất thành công',
                    text: 'Bạn đã gửi đê xuất!',
                    button: false,
                    timer: 3000
                });
                $('.suggest').val('');
            }
        }
    });
});
