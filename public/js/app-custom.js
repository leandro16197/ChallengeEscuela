window.appCustom = {
    smallBox: function(type, message, unused, timeout) {
        const isError = type === 'nok';
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: timeout === 'NO_TIME_OUT' ? null : (timeout || 3000),
            timerProgressBar: true
        });

        Toast.fire({
            icon: isError ? 'error' : 'success',
            title: message
        });
    }
};