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
                            $('.peoplee').removeClass('d-none');
                            $('#search-button').html('').html('<i class="fas fa-search" aria-hidden="true"></i>');
                            if (data.view) {
                                $('#show-people').html(data.view);
                            } else {
                                $('#show-people').html('<div class="card-body">\n' +
                                    '    <div class="content d-flex">\n' +
                                    '        <div class="row w-100 m-0 p-0">\n' +
                                    '            <div class="col p-0">\n' +
                                    '                <div class="d-flex align-items-center justify-content-center text-center">\n' +
                                    '                    <p class="font-weight-bold text-muted m-0 p-0">No people were found <i class="far fa-frown"></i></p>\n' +
                                    '                </div>\n' +
                                    '            </div>\n' +
                                    '        </div>\n' +
                                    '    </div>\n' +
                                    '</div>');
                            }
                        } else {
                            alert('There was a problem with your request, please refresh and try again in a few seconds');
                        }
                    }
                });
            } else {
                $('.peoplee').addClass('d-none');
            }
            clearInterval(interval);
        }, 200);
    }, false);
    });
})();