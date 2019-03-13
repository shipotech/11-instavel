(function(){
    $(document).on("submit", ".prevent-form-submit", function(){
        $('.prevent-button-submit').attr('disabled', 'true');
        $('.load').removeClass('d-none');
    });

    $(document).on("submit", ".prevent-form-submit2", function(){
        $('.prevent-button-submit2').attr('disabled', 'true');
        $('.fa-comment').addClass('d-none');
        $('.load2').removeClass('d-none');
        $('.change_upload').removeClass('change_upload');
        $('.mask').css('display', 'none');
    });
})();