(function(){
    $(document).on("submit", ".prevent-form-submit", function(){
        $('.prevent-button-submit').attr('disabled', 'true');
        $('.load').removeClass('d-none');
    });

    $(document).on("submit", ".prevent-form-submit2", function(){
        $('.prevent-button-submit2').attr('disabled', 'true');
        $('.load2').removeClass('d-none');
    });
})();