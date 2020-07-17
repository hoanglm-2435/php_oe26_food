$('body').on('click', '.approve-suggest', function () {
    var id = $(this).attr('data-id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: 'Duyệt đề xuất?',
        icon: 'warning',
        dangerMode: true,
        button: 'Duyệt!'
    })
        .then((result) => {
            if (result) {
                $.ajax({
                    type: "PUT",
                    url: 'suggests/' + id,
                    data: {
                        'id': $(this).attr('data-id'),
                        'status': $(this).attr('data-status')
                    },
                    success: function (response) {
                        swal({
                            icon: 'success',
                            title: 'Duyệt thành công',
                            text: 'Bạn đã duyệt đề xuất này!',
                            button: false,
                            timer: 1500
                        });
                    }
                });
                $(this).attr("data-status", "0");
                $(this).find("i").removeClass('fa-check-circle').addClass('fa-times-circle');
                $(this).removeClass('btn-success approve-suggest').addClass('btn-default cancel-suggest');
                $(this).attr("title", 'Hủy');
                $('.badge' + id).removeClass('badge-warning').addClass('badge-success');
                $('.badge' + id).text('Đã duyệt');
            }
        })
});

$('body').on('click', '.cancel-suggest', function () {
    var id = $(this).attr('data-id');
    console.log(id);
    swal({
        title: 'Từ chối đề xuất?',
        icon: 'warning',
        dangerMode: true,
        button: 'Từ chối!'
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
                    url: 'suggests/' + id,
                    data: {
                        'id': $(this).attr('data-id'),
                        'status': $(this).attr('data-status')
                    },
                    success: function (response) {
                        console.log(response);
                        swal({
                            icon: 'success',
                            title: 'Từ chối đề xuất thành công',
                            text: 'Bạn đã từ chối đề xuất này!',
                            button: false,
                            timer: 1500
                        });
                    }
                });
                $(this).attr("data-status", "1");
                $(this).find("i").removeClass('fa-times-circle').addClass('fa-check-circle');
                $(this).removeClass('btn-default cancel-suggest').addClass('btn-success approve-suggest');
                $(this).attr("title", 'Duyệt');
                $('.' + 'badge' + id).removeClass('badge-primary').addClass('badge-warning');
                $('.' + 'badge' + id).text('Chờ xử lý');
            }
        })
});
