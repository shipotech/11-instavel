<!-- Profile Picture -->
// Function that click the <input type='file'>
function changeProfile() {
    $('#file').click();
}

// Funtion that capture the value of the chosen photo
$('#file').change(function () {
    if ($(this).val() !== '') {
        upload(this);
    }
});

// Function for upload the new photo Async
function upload(img) {
    let form_data = new FormData();

    // Verify is Image (gif, jpg, png)
    let upload = img.files[0];
    let fileType = upload["type"];
    let validImageTypes = ["image/jpeg", "image/png"];

    // Hide error container
    $('#error').removeClass('show').addClass('d-none');

    // Verify is the fileType not is in array
    if ($.inArray(fileType, validImageTypes) < 0) {
        $('.error').text('The file must be an image (jpg, png)');
        $('#error').removeClass('d-none').addClass('show');
    } else if(upload.size > 900000 || upload.fileSize > 900000) {
        $('.error').text('Allowed file size exceeded. (Max. 900 KB)');
        $('#error').removeClass('d-none').addClass('show');
    } else {
        form_data.append('file', img.files[0]);

        // Store the current profile photo
        if(typeof currentPhoto1 === 'undefined') {
            var currentPhoto1 = $('.pp_f').attr('src');
            var currentPhoto2 = $('.pp_f2').attr('src');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '/update/photo',
            data: form_data,
            contentType: false,
            processData: false,
            beforeSend: function()
            {
                // Show the loader animation and hide the blue mask
                $('#loading').css('display', 'block');
                $('.mask').css('display', 'none');
                $('#profile').attr('href', '#!');
            }
        })
            .done(function (data) {
                if (data.fail) {
                    $('.error').text(data.errors['file']);
                    $('#error').removeClass('d-none').addClass('show');
                    $('.preview_image').attr('src', currentPhoto1);
                    $('.preview_image2').attr('src', currentPhoto2);
                } else {
                    $('#file_name').val(data.drive_id1);
                    $('.preview_image').attr('src', data.drive_id1);
                    $('.preview_image2').attr('src', data.drive_id2);
                    currentPhoto1 = data.drive_id1;
                    currentPhoto2 = data.drive_id2;
                }
                $('#loading').css('display', 'none');
                $('.mask').css('display', 'flex');
                $('#profile').attr('href', 'javascript:changeProfile()');
            })
            .fail(function () {
                $('.preview_image').attr('src', currentPhoto1);
                $('.preview_image2').attr('src', currentPhoto2);
                $('#loading').css('display', 'none');
                $('.error').text('The file must be an image (jpg, png)');
                $('#error').removeClass('d-none').addClass('show');
                $('.mask').css('display', 'flex');
                $('#profile').attr('href', 'javascript:changeProfile()');
            })
    }
}
<!-- Profile Picture -->