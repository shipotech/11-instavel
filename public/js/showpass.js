(function(){
    $('#showpass').click(function () {
        let current = $('#showpass').attr('class').split(' ')[3];

        if (current === 'fa-eye') {
            $('#password').attr('type', 'text');
            $('#showpass').addClass('fa-eye-slash').removeClass('fa-eye');
        }

        if (current === 'fa-eye-slash') {
            $('#password').attr('type', 'password');
            $('#showpass').addClass('fa-eye').removeClass('fa-eye-slash');
        }
    });
})();