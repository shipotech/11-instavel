(function(){
    $(document).on("click", ".image_edit", function(){
        // Preloader
        $("#show_edit").html("<div class=\"row w-100 justify-content-center m-0\">\n" +
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

        let image_id = $(this).attr('id').split('_')[1];
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            url: '/image/edit/'+image_id,
            type: 'GET',
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if (data.status === false) {
                    alert('There was a problem with your request, please refresh and try again in a few seconds');
                } else {
                    $('#show_edit').html(data.view);
                }
            }
        })
    });
})();