(function () {
    var input = document.getElementById('search-people');
    var interval;

    $(document).on('keyup', '#search-people', function () {

    input.addEventListener("keyup", function () {
        clearInterval(interval);
        interval = setInterval(function () {
            if ($.trim($('#search-people').val()) !== '' && $("#search-people").val().length > 0) {
                let nick = $('#search-people').val();
                let token = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                $.ajax({
                    url: '/search',
                    type: 'POST',
                    data: {message: nick},
                    beforeSend: function () {
                        // Show the loader animation
                        $('.fa-search').addClass('d-none');
                        $('#search-button').html('').html('<i class="fas fa-spinner fa-pulse"></i>');
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if (data.status) {
                            $('.div-people').removeClass('d-none');
                            $('#show-people').html(data.view);
                            $('#search-button').html('').html('<i class="fas fa-search" aria-hidden="true"></i>');
                        } else {
                            alert('There was a problem with your request, please refresh and try again in a few seconds');
                        }
                    }
                });
            } else {
                $('.div-people').addClass('d-none');
            }
            clearInterval(interval);
        }, 200);
    }, false);
    });
})();