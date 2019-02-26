(function(){
    $('.likes').click(function (e) {
        e.preventDefault();

        let button = $(this).attr('id');
        $(this).attr('id', 'current');
        let image_id = $('#image_id', this).val();
        let mask_id = '.mask_'+image_id;
        let heart_id = '.heart_'+image_id;
        let amount_id = '#amount_'+image_id;
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        if (button === 'like') {
            $.ajax({
                url: '/dislike',
                type: 'POST',
                data: {message:image_id},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if (data.fail) {
                        console.log(data.likes);
                    } else {
                        $('#current > i').removeClass('fas').addClass('far').removeClass('like-color');
                        if (data.likes === 1) {
                            $(amount_id).text(data.likes + ' like');
                        } else if(data.likes === 0) {
                            $(amount_id).empty();
                        } else {
                            $(amount_id).text(data.likes+' likes');
                        }
                        $('#current').attr('id', 'dislike');
                    }
                }
            })
        }

        if (button === 'dislike') {
            $.ajax({
                url: '/like',
                type: 'POST',
                data: {message:image_id},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if (data.fail) {
                        console.log(data.likes);
                    } else {
                        $('#current > i').removeClass('far').addClass('fas').addClass('like-color');
                        if (data.likes === 1) {
                            $(amount_id).text(data.likes + ' like');
                        } else if(data.likes === 0) {
                            $(amount_id).empty();
                        } else {
                            $(amount_id).text(data.likes + ' likes');
                        }
                        $('#current').attr('id', 'like');
                        $(heart_id).removeClass('d-none');
                        $(mask_id).removeClass('no-opacity-like').addClass('opacity-like');
                        $(mask_id).delay(200);
                        $(heart_id).animate({fontSize: '9em'}, 200);
                        $(heart_id).animate({fontSize: '6.5em'}, 200);
                        $(heart_id).animate({fontSize: '8em'}, 300);
                        $(mask_id).delay(800);
                        $(mask_id).queue(function () {
                            $(mask_id).removeClass('opacity-like').addClass('no-opacity-like').dequeue();
                        });
                        $(heart_id).delay(200);
                        $(heart_id).animate({fontSize: '0'}, 400);
                        $(heart_id).queue(function () {
                            $(heart_id).addClass('d-none').dequeue();
                        });
                    }
                }
            })
        }
    });
})();