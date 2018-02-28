'use strict';

var toUser = 0;

function close_modal() {
    $("#title_message_to_send").val("");
    $("#message_to_send").val("");
    $("#modal_send_messge").css('pointer-events', 'none');
    $("#modal_send_messge").fadeTo("slow", 0, function () {
        // Animation complete.
    });
    toUser = 0;
}

function show_modal() {
    $("#title_message_to_send").val("");
    $("#message_to_send").val("");

    $("#modal_send_messge").css('pointer-events', 'auto');
    $("#modal_send_messge").fadeTo("slow", 1, function () {
        // Animation complete.
    });
}


function validation_form_message() {
    var result = true;
    $("#title_message_to_send").removeClass("error");
    if ($.trim($("#title_message_to_send").val()) == "") {
        $("#title_message_to_send").addClass("error");
        result = false;
        $('html, body').animate({scrollTop: $("#title_message_to_send").offset().top}, 800);
    } else {
        if ($.trim($("#message_to_send").val()) == "") {
            $("#message_to_send").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#message_to_send").offset().top}, 800);
        }
    }

    return result;
}

function send_message() {
    if (validation_form_message() && toUser != 0) {
        var form_data = new FormData();

        form_data.append('token', $("#token_user").val());
        form_data.append('FromUser', $("#user_id").val());
        form_data.append('message', $("#message_to_send").val());
        form_data.append('id_parent_message', 0);
        form_data.append('to', toUser);
        //form_data.append('title', '');

        $.ajax({
            type: "POST",
            url: '/send-message',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        Notification.showSuccess("Сообщение было отправлено");
                        close_modal()
                    } else {

                        if ( data.data != undefined && data.data != "") {
                            Notification.showWarning(data.data);
                        } else {
                            Notification.showWarning("Возникли проблемы, обратитесь к администратору сайта");
                        }
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Notification.showError(thrownError, "Ошибка");
            }
        });
    }


}

function event_button() {

    $(".btn-favourite").on("click",function (e) {
        e.preventDefault();
        if ($(this).attr("disable") != undefined && $(this).attr("disable") == "disable") {
            return false;
        } else {
            var advertId = $(this).data("id");
            if (advertId != undefined) {
                var form_data = new FormData();

                form_data.append('token', $("#token_user").val());
                form_data.append('advertId', advertId);

                $.ajax({
                    type: "POST",
                    url: '/add-advert-favorite',
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (data, textStatus) {
                        if (data != undefined && data.result != undefined) {
                            if (data.result == true) {
                                Notification.showSuccess("Выбранное объявление было добавлено в избранные");
                                close_modal()
                            } else {
                                Notification.showWarning("Данное объявление уже находиться в избранном");
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Notification.showError(thrownError, "Ошибка");
                    }
                });
            } else {
                Notification.showError("Ошибка конфигурации. У данного объявления нет ID.", "Ошибка");
            }
        }
    });

    $(".btn-message").on("click",function () {
        toUser = $(this).attr("id_user");
        if (toUser == undefined || toUser == "") {
            Notification.showError("Ошибка конфигурации. Данное объявление не пренадлежит не одному пользователя.", "Ошибка");
        } else {
            show_modal();
        }
    });

    $(".btn-not-favourite").on("click",function () {
        var advertId = $(this).data("id");

        var form_data = new FormData();

        form_data.append('token', $("#token_user").val());
        form_data.append('advertId', advertId);

        $.ajax({
            type: "POST",
            url: '/remove-advert-favorite',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        Notification.showSuccess("Выбранное объявление было удаленно из избранных");
                        location.reload();
                        close_modal()
                    } else {
                        Notification.showWarning("Возникли проблемы, обратитесь к администратору сайта");
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Notification.showError(thrownError, "Ошибка");
            }
        });
    });
}

$(document).ready(function () {
    Plugins.start();
    Core.init();

    event_button();

    setImmediate(function () {
        window.config = $('body').getConfig();
    });
});

function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";

    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}


var isEmpty = function (obj) {
    return !(Object(obj).keys > 0);
}

var Core = function () {

    var initSelect = function () {
        if ($('.select')[0]) {
            $('.select').select2({
                minimumResultsForSearch: Infinity
                /*width:'100%'*/
            });
            $('.select100').select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
        }
    }
    var initProductTab = function () {
        if ($('#productTab')[0]) {
            $('#productTab').easyResponsiveTabs();
        }
    }
    var initSliders = function () {
        $('.main-slider').slick({
            autoplay: true,
            autoplaySpeed: 4000,
            arrows: true,
            dots: true
        });
        $('.bannBox').slick({
            autoplay: true,
            autoplaySpeed: 4000,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 1,
                }
            }]
        });
        $('.vip-box').slick({
            autoplay: false,
            autoplaySpeed: 5000,
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                    },
                }


            ]
        });
        $('.recomended-product-box').slick({
            autoplay: false,
            autoplaySpeed: 5000,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                    },
                }


            ]
        });
        $('.brand-box').slick({
            autoplay: false,
            autoplaySpeed: 4000,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                }
            ]
        });
    }

    var initProductGalery = function () {
        $('.sliderGalleryThumb-big').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            infinite: false,
            asNavFor: '.sliderGalleryThumb-thumbs'
        });
        $('.sliderGalleryThumb-thumbs').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.sliderGalleryThumb-big',
            dots: false,
            centerMode: false,

            arrows: false,
            /*    infinite: true,
                 centerMode: true,*/
            focusOnSelect: true,
            infinite: false,

        });
    }

    var scrollToHref = function () {
        $(".scrollToHref").on("click", function (event) {
            event.preventDefault();
            var id = $(this).attr('href'),
                top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 1000);
        });
    }

    var initPreloader = function () {
        $('.preloader load').fadeOut('slow');
        $('.preloader').delay(350).fadeOut('slow')
    }

    var slideToggleFilter = function () {
        $('.shop-categories .title-category').on("click", function (e) {
            e.preventDefault();
            $(this).next().slideToggle();
            if ($(this).next().hasClass('active')) {
                $(this).find('.fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
                $(this).next().removeClass('active');


            }
            else {
                $(this).find('.fa-angle-down').addClass('fa-angle-up').removeClass('fa-angle-down');
                $(this).next().addClass('active');

            }
        });
    }

    var initFormAuthReg = function () {
        var $formAuthReg = $('.form-auth-reg');
        $formAuthReg.find('input, textarea').on('keyup blur focus', function (e) {
            var $this = $(this),

                label = $this.prev('label');

            if ($this.val() === '') {
                label.removeClass('active highlight');
            }
            else {
                label.addClass('active highlight');
            }

        });

        $formAuthReg.find('input, textarea').focus();

        $formAuthReg.on('click', '.tab a', function (e) {
            e.preventDefault();
            $(this).parent().addClass('active');
            $(this).parent().siblings().removeClass('active');
            var target = $(this).attr('href');
            $('.form-auth-reg .tab-content > div').not(target).hide();
            $(target).fadeIn(600);
        });
    }

    var rangeSlider = function () {
        if ($.ui) {
            var $sliderRange = $('.slider-range-price');
            var minPrice = parseInt($sliderRange.data('min'));
            var maxPrice = parseInt($sliderRange.data('max'));
            if ($sliderRange.length) {
                $sliderRange.slider({
                    range: true,
                    min: (isNaN(minPrice)) ? 10 : minPrice,
                    max: (isNaN(maxPrice)) ? 10000 : maxPrice,
                    values: [75, 300],
                    slide: function (event, ui) {
                        $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                    }
                });
                $("#amount").val(
                    "$" + $("#slider-range").slider("values", 0) +
                    " - $" + $("#slider-range").slider("values", 1)
                );
            }
            $sliderRange = $('#slider-range-addMoney');
            minPrice = parseInt($sliderRange.data('min'));
            maxPrice = parseInt($sliderRange.data('max'));
            if ($sliderRange.length) {
                $sliderRange.slider({
                    range: "min",
                    value: 200,
                    min: (isNaN(minPrice)) ? 10 : minPrice,
                    max: (isNaN(maxPrice)) ? 10000 : maxPrice,
                    step: 2,
                    slide: function (e, ui) {
                        $("#slider-range-addMoney-val").val(ui.value);
                    }
                });
                $("#slider-range-addMoney-val").val($sliderRange.slider("value"));


            }
        }
    }

    var toTop = function () {

        $("#back-top").hide();
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }
            });
            $('#back-top a').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });

    };
    var limitFormArea = function () {
        /*limit count*/
        var init = function ($this) {

            var $limitCounter = $this.closest('.form-group').find('.counter');
            var $limitCounterVal = parseInt($limitCounter.text());
            var $limitAreaAttrMax = parseInt($this.attr('maxlength'));
            var $limitAreaLength = parseInt($this.val().length);

            var $newCount = $limitAreaAttrMax - $limitAreaLength;
            $limitCounter.text($newCount);

            if ($newCount <= 10) {
                $limitCounter.addClass('isRed');
            }
            else {
                $limitCounter.removeClass('isRed');
            }

        };

        $('.limit-area').each(function(){
            var $this = $(this);
            init($this);
        });

        $("body").on('keyup keypress keydown', '.limit-area', function () {
            init($(this));
        });

    };

    var events = function () {
        /* message*/
        $('.star').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('star-checked');
        });

        $('.my-message-container label').on('click', function () {
            $(this).parents('.table-row').toggleClass('selected');
        });

        $('.btn-filter').on('click', function () {
            var $target = $(this).data('target');
            if ($target != 'all') {
                $('.table-row').css('display', 'none');
                $('.table-row[data-status="' + $target + '"]').fadeIn('slow');
                $('.btn-filter').removeClass('active');
                $(this).addClass('active');
            } else {
                $('.table-row').css('display', 'none').fadeIn('slow');
                $('.btn-filter').removeClass('active');
                $(this).addClass('active');
            }
        });

        /* message*/


    }


    var selectCategory = function($selectCategory){

        var $selectCategoryInput = $('.select-category-input');
        var $selectCategoryInputId = $('.select-category-input-id');

        $selectCategoryInput.on('click', function (e) {
            $(this).next().slideToggle();
        })

        $('.tab a[data-id]').on('click', function (e) {

            e.preventDefault();
            $selectCategoryInput.val($(this).attr('data-value'));
            $selectCategoryInputId.val($(this).attr('data-id'));

            $(this).parents().find('a').removeClass('active');
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $(this).siblings().addClass('siblings');

            if (!$(this).parent().children('.siblings').hasClass('siblings')) {
                $(this).closest('.select-category').find('a').removeClass('valid-category');
                $(this).addClass('valid-category');
                $selectCategoryInput.next().slideUp();
            }
            else{
                $(this).closest('.select-category').find('a').removeClass('valid-category');
            }

        });

        $selectCategory.on('click','.has-sub', function (e) {
            e.preventDefault();
            $(this).next().slideToggle();
        });

    }


    var initFormEvents = function(){

        $('body').on('click', '.select-category__li > a', function(e){
            if($(this).attr('href') == '#'){
                e.preventDefault();
            }
            var $this = $(this).parent();
            $this.siblings().removeClass('isActive');
            if($this.hasClass('isActive')){
                $this.removeClass('isActive');
            }else{
                $this.addClass('isActive');
            }
        });

        var valueCity = "";
        var isPending = false;

        var switchFinder = function($item, type){
            if(type){
                $item.addClass('isOpen');
            }else{
                $item.removeClass('isOpen');
            }
        };

        $('body').on('keyup', '.js-cities-control', function() {
            var $this = $(this);
            var val = $this.val();
            var $parent = $this.closest('.form-cities');
            var $dropdown = $parent.find('.js-city-container');
            var $items = $dropdown.find('.form-cities__item');
            if (val.length < 3) {
                $items.remove();
                return $parent.addClass('isNotFound');
            }
            $parent.addClass('isOpen');
            if(isPending){
                return null;
            }else{
                isPending = true;
            }
            $.ajax({
                url: '/get-city',
                type: "POST",
                data: {
                    query: val
                },
                complete: function(){
                    isPending = false;
                },
                success: function (response) {
                    try {
                        if (response.result) {
                            $dropdown.find('.form-cities__item').remove();
                            var data = response.data;
                            for (var key in data) {
                                var val = data[key];
                                if (!_.isEmpty(val) && typeof val === "object") {
                                    var name = val.value + (("affiliation" in val) ? " (" + val.affiliation + ")" : "")
                                    $dropdown.append($('<li class="form-cities__item"><a class="js-select-city form-cities__link" href="#" data-id="' + val.id_city + '">' + name + '</li>'));
                                }
                            }
                            return $parent.removeClass('isNotFound');
                        }
                    } catch (e) {
                        console.error(e);
                    }
                    $dropdown.find('.form-cities__item').remove();
                    $parent.addClass('isNotFound');
                }
            });
        });

        $('body').on('blur', '.js-cities-control', function(){
            var $this = $(this);
            var val = $.trim($this.val());
            if(val.length < 3){
                $this.siblings().val('0');
            }
        });
        var $formCities = $('.form-cities');
        var $selectCategory = $('.select-category');
        $(window).on("click.Bst", function(event){
            if (
                $formCities.has(event.target).length == 0 //checks if descendants of $box was clicked
                &&
                !$formCities.is(event.target) //checks if the $box itself was clicked
            ){
                $formCities.removeClass('isOpen');
            }
            if (
                $selectCategory.has(event.target).length == 0 //checks if descendants of $box was clicked
                &&
                !$selectCategory.is(event.target) //checks if the $box itself was clicked
            ){
                $selectCategory.find('.isActive').removeClass('isActive');
            }
        });


        $('body').on('click touch tap', '.js-select-city', function(){
            var $this = $(this);
            var $mainParent = $this.closest('.form-cities');
            var $items = $this.find('.form-cities__item');
            var id = $this.data('id');
            var name = $this.text();
            $('.js-cities-control').val(name).removeClass('isNotValid');
            $('.js-city-id').val(id);
            $mainParent.removeClass('isOpen');
            $items.remove();
            return false;
        });

        var $selectCategory = $('.select-category');
        if($selectCategory[0]) {
            selectCategory($selectCategory);
        }
        if(true) {
            uploadImgPost();
            var $formPostAdsBox = $('.post-new-ad');
            $('#FormPostNewItem').on('submit', function (e) {
                e.preventDefault();
                var $this = $(this);

                var $title = $formPostAdsBox.find('.js-vn[data-type=title]');
                // var $category = $formPostAdsBox.find('.js-vn[data-type=category]');
                // var $categoryValid = $formPostAdsBox.find('.js-vn[data-type=category-valid]');
                var $price = $formPostAdsBox.find('.js-vn[data-type=price]');
                var $description = $formPostAdsBox.find('.js-vn[data-type=description]');
                var error = {};

                var errorTitle = validation.title($title.val());
                if (errorTitle) {
                    error.title = errorTitle;
                }

                // var errorCategory = validation.categoryProduct($category.val());
                // if (errorCategory) {
                //     error.category = errorCategory;
                // }

                if (isNaN(parseInt($price.val()))) {
                    error.price = "invalid_price";
                }

                // var errorDescription = validation.descProduct($description.val());
                // if (errorDescription) {
                //     error.description = errorDescription;
                // }

                if (!_.isEmpty(error)) {
                    return ViewMessageFromData($this, {error: error});
                }

                if($this.hasClass('isNew')) {
                    var validCategory = $('.select-category').find('a').is(".valid-category");
                    if (validCategory == false) {
                        return ViewMessageFromData($this, {error: 'Выберите подкатегорию'});
                    }
                }
                try{
                    if(myDropzone){
                        if(myDropzone.files.length > 0){
                            var files = myDropzone.files;
                            $this.find('.js-inc-img').remove();
                            for(var key in files){
                                var val = files[key];
                                $this.append('<input class="js-inc-img" type="hidden" name="images[]" value="' + val.name + '">');
                            }
                        }
                    }
                }catch(e){}

                var action = $this.attr("action");
                $.ajax({
                    url: action,
                    data: $this.serialize(),
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        return ViewMessageFromData($this, data);
                    }
                });
                return false;
            });
        }

        $('body').on('submit', '#FormMessageToSeller', function(e){

            e.preventDefault();
            var $this = $(this);

            var $message = $this.find('.js-vn[data-type=message]');

            var error = { };

            var errorMessage = validation.message($message.val());
            if (errorMessage) {
                error.message = errorMessage;
            }

            if(!_.isEmpty(error)){
                return ViewMessageFromData($this, {error: error});
            }

            var action = $this.attr("action");

            $.ajax({
                url: action,
                data: $this.serialize(),
                dataType: "json",
                type: "POST",
                success: function(data){
                    $this.trigger('reset');
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });
    }

    return {
        init: function () {
            initSelect();
            initSliders();
            initProductGalery();
            initProductTab();
            scrollToHref();
            initPreloader();
            toTop();
            slideToggleFilter();
            initFormAuthReg();
            rangeSlider();
            limitFormArea();
            initFormEvents();
            uploadImgPost();
            events();


        }
    }
}()


var ViewMessage = function (msg, type, delay) {
    var $hdMsg = $('.hdMsg');
    if (!delay) delay = 3500;
    // $hdMsg.headerMessage({
    //     text: config.getMsg(msg),
    //     type: type,
    //     timeDelay: delay,
    //     formMsg: true
    // }).viewMessage();
    if(type == "success") {
        Notification.showSuccess(config.getMsg(msg));
    }else{
        Notification.showWarning(config.getMsg(msg));
    }
};
var ViewMessageFromData = function ($this, data) {
    var $hdMsg = $('.hdMsg');
    if (typeof data === "object") {
        if("result" in data){
            if(!data.result && ("data" in data)){
                data.error = data.data;
            }
        }
        if ("error" in data) {
            if (typeof data.error === "object") {
                var key, val, $el;
                for (key in data.error) {
                    val = data.error[key];
                    break;
                }
                if (typeof $this === "object") {
                    $el = $this.find('.js-validation[data-type="' + key + '"], .js-vn[data-type="' + key + '"]');
                    $el.addClass('js-error');
                }
                Notification.showWarning(config.getMsg(val));
                // $hdMsg.headerMessage({
                //     text: config.getMsg(val),
                //     type: "error",
                //     formMsg: true
                // }).viewMessage();
            }
            else {
                // $hdMsg.headerMessage({
                //     text: config.getMsg(data.error),
                //     type: "error",
                //     formMsg: true
                // }).viewMessage();
                Notification.showWarning(config.getMsg(data.error));
            }
        }
        if ("reload" in data) {
            setImmediate(function () {
                location.reload();
            });
            return;
        }
        else if ("redirect" in data) {
            location.replace(data.redirect);
            return;
        }
        else if ("hash" in data) {
            var Hash = location.hash;
            if (data.hash === "") {
                location.hash = "";
            } else {
                location.hash = data.hash;
            }
        }
        if ("msg" in data) {
            var msg = data.msg;

            if (typeof msg === "object") {
                msg = msg.success;
                if ("img" in data.msg) {
                    if ($($this.data('imgsef'))[0])
                        $($this.data('imgsef')).attr('src', data.msg.img);
                    else location.reload();
                }
            }
            // $hdMsg.headerMessage({
            //     text: config.getMsg(msg),
            //     type: "success",
            //     formMsg: true
            // }).viewMessage();
            Notification.showSuccess(config.getMsg(msg));
        } else {
            return data;
        }
    }
    return;
};

var myDropzone,
    prSendAdvert = false;

function uploadImgPost() {
    if ($('.dropzone')[0]) {
        $(function () {
            Dropzone.options.aDropImg = {
                uploadMultiple: true,
                maxFilesize: 5,
                maxFiles: 9,
                addRemoveLinks: true,
                dictResponseError: 'Server not Configured',
                acceptedFiles: ".png,.jpg,.jpeg",
                url: "/upload-image",
                init: function () {
                    myDropzone = this;
                    var self = this;
                    // config
                    self.options.addRemoveLinks = true;
                    self.options.dictRemoveFile = "Удалить";
                    // Send file starts
                    self.on("sending", function (file) {
                        $('.meter').show();
                    });

                    // File upload Progress
                    self.on("totaluploadprogress", function (progress) {
                        $('.roller').width(progress + '%');
                    });

                    self.on("queuecomplete", function (progress) {
                        $('.meter').delay(999).slideUp(999);
                    });

                    //New file added
                    self.on("success", function (file, data) {
                        if(!data.result){
                            this.removeFile(file);
                            Notification.showError( "Произошла ошибка при загрузке файла." );
                        }
                    });

                    // On removing file
                    self.on("removedfile", function (file) {
                        if (file != undefined && (file.upload != undefined && file.upload.filename != undefined) || (file.name != undefined)) {
                            var fileName = '';
                            if (file.name != undefined) {
                                fileName = file.name;
                            } else {
                                if (file.upload.filename != undefined) {
                                    fileName = file.upload.filename;
                                }
                            }

                            var form_data = new FormData();
                            form_data.append('file', fileName);
                            $.ajax({
                                type: "POST",
                                url: '/delete-image',
                                dataType: "json",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: form_data,
                                success: function (data, textStatus) {
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    Notification.showError(thrownError, "Ошибка");
                                }
                            });
                        }
                    });


                    self.on("maxfilesexceeded", function (file) {
                        this.removeFile(file);
                        Notification.showError( "Слишком много файлов в загрузке." );
                    });

                    self.on("error", function (file) {
                        this.removeFile(file);
                        Notification.showError( "Произошла ошибка при загрузке файла." );
                    });
                }
            };
        })
    }
};

