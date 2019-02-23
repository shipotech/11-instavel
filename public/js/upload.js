// Upload Images
    // Function that click the <input type='file'>
    function changeUpload() {
        $('#upload-image').click();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            // Verify is Image (gif, jpg, png)
            let file = input.files[0];
            let fileType = file["type"];
            let validImageTypes = ["image/jpeg", "image/jpg", "image/png"];

            $('#error').removeClass('show').addClass('d-none');

            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#error').removeClass('d-none').addClass('show');
            } else {
                reader.onload = function (e) {
                    $('.upload-preview').attr('src', e.target.result);
                    $('.alert').removeClass('show').addClass('d-none');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    $("#upload-image").change(function(){
        if ($(this).val() !== '') {
            readURL(this);
        }
    });
// Upload Images