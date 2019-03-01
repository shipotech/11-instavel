(function(){
    $(document).on("click", ".show_likes", function(e){

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
                    if (data === " ") {
                        alert('hi');
                    } else {
                        $('#show_likes').html(data);
                        console.log(data);
                    }
                }
            })
    });
})();