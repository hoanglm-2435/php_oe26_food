$(document).ready(function () {
    Pusher.logToConsole = true;
    var pusher = new Pusher('09863ffc18f773e8c993', {
        cluster: 'ap1',
        forceTLS: true,
        encrypted: true
    });
    var user_id = $('#notify-message').data('user');
    var channel = pusher.subscribe('notify-for-admin' + user_id);
    channel.bind('order-notify', function (data) {
        $('#notify').prepend(`
            <div class="dropdown-divider"></div>
            <a href="#" class="show-order dropdown-item bg-light"
                data-toggle="modal" data-target="#notiModal"
                data-id="${data.notify_id}" data-order="${data.order_id}">
                <i class="fas fa-envelope text-danger mr-2"></i> ${data.user}
            </a>
        `);
        let message = $('#notify-message').data('message');
        toastr.success(message, 'Notification', {timeOut: 5000});
        let count = parseInt($('.count-notify').text());
        if (isNaN(count)) {
            count = 0;
        }
        $('.count-notify').text(count + 1);
        $('.empty-notify').hide();
    });

    $('body').on('click', '.show-order', function () {
        let id = $(this).data("id");
        let order_id = $(this).data("order");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'put',
            url: 'show-notification',
            dataType: 'json',
            data: {
                'id': id,
                'order_id': order_id,
            },
            success: function (response) {
                var orderDetails = response.order_details;
                var i;
                var data = '';
                for (i = 0; i < orderDetails.length; i++) {
                    data += `<tr class="text-center">
                            <td>${orderDetails[i]['productName']}</td>
                            <td>&#36;${orderDetails[i]['productPrice']}</td>
                            <td>${orderDetails[i]['productQuantity']}</td>
                            <td>&#36;${orderDetails[i]['totalPrice']}</td>
                        </tr>`;
                }
                $('#details-table').html(data);
                $('.grand-total').html(`&#36;` + response.grand_total);
                $('.count-notify').text(response.notify_count);
            }
        });
        $(this).removeClass('bg-light');
        $(this).children().removeClass('fa-envelope text-danger').addClass('fa-envelope-open');
    });
})
