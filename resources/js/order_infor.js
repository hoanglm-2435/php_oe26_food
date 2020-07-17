$(document).ready(function() {
    $('.order-infor').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'show-details/orders/' + id,
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var orderDetails = response.orderDetails;
                var i;
                for (i = 0; i < orderDetails.length; i++) {
                    $('#details-table').append(
                        `<tr class="text-center">
                            <td>${orderDetails[i]['productName']}</td>
                            <td>&#36;${orderDetails[i]['productPrice']}</td>
                            <td>${orderDetails[i]['productQuantity']}</td>
                            <td>&#36;${orderDetails[i]['totalPrice']}</td>
                        </tr>`
                    );
                }
                $('.grand-total').html(`&#36;` + response.grandTotal);
            }
        });
    });
});
