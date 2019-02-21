(function(){
    $('.prevent-form-submit').on('submit', function () {
        $('.prevent-button-submit').attr('disabled', 'true');
        $('.fa-comment').css('display','none');
        $('.load').show('fast');
    })
})();