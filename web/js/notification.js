var Notification = function () {
    return {
        init: function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "progressBar": true,
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        },
        showSuccess: function (message, title, flag, value) {
            this.init();
            if (title == undefined) {
                title = '';
            }
            if (flag != undefined) {
                if (flag == "notclose") {
                    toastr.options.timeOut = 3000000;
                } else {
                    if (flag == "timeout") {
                        if (value != undefined) {
                            toastr.options.timeOut = value;
                        }
                    }
                }
            }
            toastr.success(message, title);
        },
        showError: function (message, title, flag, value) {
            this.init();
            if (title == undefined) {
                title = '';
            }
            if (flag != undefined) {
                if (flag == "notclose") {
                    toastr.options.timeOut = 3000000;
                } else {
                    if (flag == "timeout") {
                        if (value != undefined) {
                            toastr.options.timeOut = value;
                        }
                    }
                }
            }
            toastr.error(message, title);
        },
        showWarning: function (message, title, flag, value) {
            this.init();
            if (title == undefined) {
                title = '';
            }
            if (flag != undefined) {
                if (flag == "notclose") {
                    toastr.options.timeOut = 3000000;
                } else {
                    if (flag == "timeout") {
                        if (value != undefined) {
                            toastr.options.timeOut = value;
                        }
                    }
                }
            }
            toastr.warning(message, title);
        }
    }
}();