$('body').on('click', '.approve-order', function () {
    var id = $(this).attr('data-id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: 'Duyệt đơn hàng?',
        icon: 'warning',
        dangerMode: true,
        button: 'Duyệt!'
    })
        .then((result) => {
            if (result) {
                $.ajax({
                    type: "PUT",
                    url: 'orders/' + id,
                    data: {
                        'id': $(this).attr('data-id'),
                        'status': $(this).attr('data-status')
                    },
                    success: function (response) {
                        swal({
                            icon: 'success',
                            title: 'Duyệt thành công',
                            text: 'Bạn đã duyệt đơn hàng!',
                            button: false,
                            timer: 1500
                        });
                    }
                });
                $(this).attr("data-status", "0");
                $(this).find("i").removeClass('fa-check-circle').addClass('fa-times-circle');
                $(this).removeClass('btn-success approve').addClass('btn-default unapproved');
                $(this).attr("title", 'Hủy');
                $('.badge' + id).removeClass('badge-warning').addClass('badge-success');
                $('.badge' + id).text('Đã duyệt');
            }
        })
});

$('body').on('click', '.unapproved-order', function () {
    var id = $(this).attr('data-id');
    swal({
        title: 'Hủy xác nhận đơn hàng?',
        icon: 'warning',
        dangerMode: true,
        button: 'Xác nhận hủy!'
    })
        .then((result) => {
            if (result) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: 'orders/' + id,
                    data: {
                        'id': $(this).attr('data-id'),
                        'status': $(this).attr('data-status')
                    },
                    success: function (response) {
                        swal({
                            icon: 'success',
                            title: 'Hủy xác nhận thành công',
                            text: 'Bạn đã hủy duyệt đơn hàng!',
                            button: false,
                            timer: 1500
                        });
                    }
                });
                $(this).attr("data-status", "1");
                $(this).find("i").removeClass('fa-times-circle').addClass('fa-check-circle');
                $(this).removeClass('btn-default unapproved').addClass('btn-success approve');
                $(this).attr("title", 'Duyệt');
                $('.' + 'badge' + id).removeClass('badge-success').addClass('badge-warning');
                $('.' + 'badge' + id).text('Chờ xử lý');
            }
        })
});

$('body').on('click', '.cancel-order', function () {
    var id = $(this).attr('data-id');
    swal({
        title: 'Hủy đơn hàng?',
        icon: 'warning',
        dangerMode: true,
        button: 'Xác nhận hủy!'
    })
        .then((result) => {
            if (result) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: 'cancel-order/' + id,
                    data: {
                        'id': $(this).attr('data-id'),
                        'status': $(this).attr('data-status')
                    },
                    success: function () {
                        console.log(this.data.status);
                        swal({
                            icon: 'success',
                            title: 'Hủy đơn thành công',
                            text: 'Bạn đã hủy đơn hàng!',
                            button: false,
                            timer: 1500
                        });
                    }
                });
                $(this).attr("data-status", "3");
                $(this).find("i").removeClass('fa-times-circle');
                $(this).removeClass('btn-default cancel-order');
                $('.' + 'badge' + id).removeClass('badge-warning').addClass('badge-secondary');
                $('.' + 'badge' + id).text('Đã hủy');
            }
        })
});
