$('.delete').on('click', function(e){
    e.preventDefault();
    return swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this item!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal('Poof! Your item file has been deleted!', {
                    icon: 'success',
                });
                $(this).submit();
            } else {
                swal('Your item file is safe!');
            }
        });
});

