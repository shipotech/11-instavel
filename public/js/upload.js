// Upload Images
    // Function that click the <input type='file'>
(function(){
    $(document).on("click", ".change_upload", function(){
        var id = $(this).attr('id').split('_')[1];
        $('#upload-image'+id).click();

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            // Verify is Image (jpg, png)
            let file = input.files[0];
            let fileType = file["type"];
            let validImageTypes = ["image/jpeg", "image/jpg", "image/png"];

            $('#error'+id).removeClass('show').addClass('d-none');
            $('#error-file-size').removeClass('show').addClass('d-none');

            if ($.inArray(fileType, validImageTypes) < 0) {
                // Validate FileType
                $('#error'+id).removeClass('d-none').addClass('show');
            } else if(file.size > 900000 || file.fileSize > 900000) {
                // Validate FileSize
                $('#error-file-size').removeClass('d-none').addClass('show');
            } else {
                // Uploading preview
                reader.onload = function (e) {
                    $('.upload-preview'+id).removeClass('lazyloaded')
                        .removeClass('lazyload')
                        .attr('src', e.target.result)
                        .removeAttr('srcset')
                        .removeAttr('data-src')
                        .removeAttr('data-srcset');
                    $('#error'+id).removeClass('show').addClass('d-none');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    }

        $("#upload-image"+id).change(function(){
            if ($(this).val() !== '') {
                readURL(this, id);
            }
        });
    });
})();
// Upload Images