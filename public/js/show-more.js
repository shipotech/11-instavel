let morePosts;
let scroll = null; //Prevent scroll event fired multiple times

//function to call in scroll event
function loadMore()
{
    let id = $(".lastId").attr("id");
    let getLastId;
    let token = $('meta[name="csrf-token"]').attr('content');
    let url = $(".layout_name").attr("id");
    if (url === 'home') {
        url = '/scroll';
    } else if (url === 'profile') {
        url = '/scroll/profile';
    } else if (url === 'people') {
        url = '/scroll/people';
    }

    if (id && id > 0) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax(
            {
                url: url,
                type: "POST",
                data: {message:id},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $(".before").html("");
                    if (data.status === false) {
                        getLastId = 0;
                        morePosts = false;
                        $("#no-more").append("<div class=\"alert alert-primary text-center\" role=\"alert\"><i class=\"fas fa-search-minus\"></i> No more records found.</div>");
                    } else {
                        $("#show-more").append(data.view);
                        getLastId = data.last;
                        morePosts = true;
                    }
                    $(".lastId").attr("id", getLastId);
                }
            })
    }
}
    $(window).on('scroll',function()
    {
        // If have more post
        if(morePosts !== false)
        {
            // Preloader
            $(".before").html("<div class=\"row w-100 justify-content-center m-0\">\n" +
                "                    <div class=\"col-12 mb-5\">\n" +
                "                        <div class=\"d-flex justify-content-center\">\n" +
                "                            <div class=\"preloader-wrapper big active\">\n" +
                "                                <div class=\"spinner-layer spinner-blue\">\n" +
                "                                    <div class=\"circle-clipper left\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"gap-patch\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"circle-clipper right\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                                <div class=\"spinner-layer spinner-red\">\n" +
                "                                    <div class=\"circle-clipper left\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"gap-patch\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"circle-clipper right\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                                <div class=\"spinner-layer spinner-yellow\">\n" +
                "                                    <div class=\"circle-clipper left\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"gap-patch\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"circle-clipper right\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                                <div class=\"spinner-layer spinner-green\">\n" +
                "                                    <div class=\"circle-clipper left\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"gap-patch\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"circle-clipper right\">\n" +
                "                                        <div class=\"circle\"></div>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                </div>");

            if (scroll)
            {
                clearTimeout(scroll); //cleaned the scroll request
            }

            // if the scroll goes to bottom we fired loadMore()
            if ($(window).scrollTop() + $(window).height() + 500 >= $(document).height())
            {
                scroll = setTimeout(function()
                {
                    scroll = null;
                    loadMore();
                }, 1000);
            }
        }
    });