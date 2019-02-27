(function(){
    let page = 1;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });
    function loadMoreData(page){
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax(
            {
                url: '?page=' + page,
                type: "get",
                beforeSend: function()
                {
                    $('#no-more').hide();
                    $('#loader').show();
                }
            })

            .done(function(data)
            {
                if(data === " "){
                    $('#loader').hide();
                    $('#no-more').removeClass('d-none').addClass('d-flex');
                } else {
                    $('#loader').hide();
                    $("#show-more").append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('server not responding...');
            });
    }
})();