(function(){
    $('.show_likes').click(function () {

        let image_id = $(this).attr('id').split('_')[1];
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
            $.ajax({
                url: '/show-likes',
                type: 'POST',
                data: {message:image_id},
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if (data.fail) {
                        console.log(data);
                    } else {
                        $('#show_likes').html(data);
                    }
                }
            })
    });
})();