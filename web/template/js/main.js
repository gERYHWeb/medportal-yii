
'use strict';

$(document).ready(function(){
    Plugins.start();
    Core.init();
    setImmediate(function(){
        window.config = $('body').getConfig();
    });
});

var $body= $('body');
var $sliderRangeAddMoney = $('#slider-range-addMoney');
var $sliderRangeAddMoneyMinPrice = parseInt($sliderRangeAddMoney.data('min'));
var $sliderRangeAddMoneyMaxPrice = parseInt($sliderRangeAddMoney.data('max'));
var $sliderRangeAddMoneyVal = $('#slider-range-addMoney-val');
var $sliderRangePrice = $('#slider-range-price');


var $filterAdsSearchTop =  $('.a-header #form-search');
var $filterAdsSearchLeft = $('#shop-categories');

var $loginForm = $('#login-form');
var $signupForm = $('#signup-form');

var $formPostAds = $('#post-new-ad');
var $formPostAdsBox = $('#post-new-ad').closest('.section-post-new-ad');

var $formMessageSeller = $('#message_send_seller');

var $formRestorePass = $('#form-restore-pass');

var $formUserInfo = $('#formUserInfo');

var $formChangePass = $('#form-change-password');

var $formFeedback = $('#form-feedback');



var isEmpty = function(obj){return !(Object(obj).keys > 0); }

var Core = function() {

    var initSelect = function(){
        if ($('.select')[0]) {
            $('.select').select2({
              /*width:'100%'*/
            });
            $('.select100').select2({
              width:'100%'
            });
            $('.selectResolve').select2({
              width: 'resolve' 
            });
            $('.selectNoSearch').select2({
               minimumResultsForSearch: -1
            });

        }
    }
    var initProductTab = function(){
        if ($('#productTab')[0]) {
            $('#productTab').easyResponsiveTabs();
        }
    }
    var initSliders = function(){
        $('.main-slider').slick({
            autoplay: true,
            autoplaySpeed: 6000,
            arrows:true,
            dots: true
        });
        $('.bannBox').slick({
            autoplay: true,
            autoplaySpeed: 4000,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows:false,
            dots:true,
            responsive:[{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 1,
                }
            }]
        });
        $('.vip-box').slick({
            autoplay: false,
            autoplaySpeed: 5000,
            slidesToShow:6,
            slidesToScroll: 1,
            arrows:true,
            dots:false,
             responsive:[
             {
                breakpoint: 1201,
                    settings: {
                        slidesToShow: 4,
                    },
                },
            {                    
                breakpoint: 993,
                    settings: {
                        slidesToShow: 3,
                    },
                },
            {
                breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                    },
                },
            {
                breakpoint: 501,
                    settings: {
                        slidesToShow: 1,
                    },
                }
                
                
            ]
        });
        $('.recomended-product-box').slick({
            autoplay: false,
            autoplaySpeed: 5000,
            slidesToShow:4,
            slidesToScroll: 1,
            arrows:true,
            dots:false,
             responsive:[
             {
                breakpoint: 1201,
                    settings: {
                        slidesToShow: 3,
                    },
                },
            {                    
                breakpoint: 993,
                    settings: {
                        slidesToShow: 3,
                    },
                },
            {
                breakpoint: 769,
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
            slidesToShow:4,
            slidesToScroll: 1,
            arrows:true,
            dots:false,
            responsive:[{
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
            },
            {
                breakpoint: 440,
                settings: {
                    slidesToShow: 1,
                  }
            },
            ]
        });
    }

    var initProductGalery = function(){
        $('.sliderGalleryThumb-big').slick({
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false,
              fade: true,
               infinite: false,
              asNavFor: '.sliderGalleryThumb-thumbs'
        });
        $('.sliderGalleryThumb-thumbs').slick({
          slidesToShow: 4,
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

    var scrollToHref = function(){
        $(".scrollToHref").on("click", function (event) {
            event.preventDefault();
            var id  = $(this).attr('href'),
                top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 1000);
        });
    }
   
    var initPreloader = function(){
        $('.preloader load').fadeOut('slow'); 
        $('.preloader').delay(350).fadeOut('slow')
    }

    var slideToggleFilter = function(){
         $('.shop-categories .title-category').on("click", function (e){
            e.preventDefault();
            $(this).next().slideToggle();                
            if ($(this).next().hasClass('active')) {
                $(this).find('.fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
                $(this).next().removeClass('active');
                
            
            }
            else{
                 $(this).find('.fa-angle-down').addClass('fa-angle-up').removeClass('fa-angle-down');
                 $(this).next().addClass('active');
                
            }
        });
    }

    var initFormAuthReg = function(){
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

        $formAuthReg.on('click','.tab a', function (e) {
          e.preventDefault();
          $(this).parent().addClass('active');
          $(this).parent().siblings().removeClass('active');
          var target = $(this).attr('href');
          $('.form-auth-reg .tab-content > div').not(target).hide();
          $(target).fadeIn(600);
        });
    }

   

   

    var toTop = function(){
        
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
    
    }
    var limitFormArea = function(){
        /*limit count*/
        $("body").on('keyup keypress keydown', '.limit-area', function(){

            var $limitCounter =  $(this).closest('.form-group').find('.counter');
            var $limitCounterVal = parseInt($limitCounter.text());
            var $limitAreaAttrMax = parseInt($(this).attr('maxlength')); 
            var $limitAreaLength = parseInt($(this).val().length);
             
            var $newCount = $limitAreaAttrMax -  $limitAreaLength;
            $limitCounter.text($newCount);

            if ($newCount<=10) {
                $limitCounter.addClass('isRed');
            }
            else{
                $limitCounter.removeClass('isRed');
            }
        }) 
    }

    var iploadImgPost = function(){
        if ($('.dropzone')[0]) {
            $(function (){
              Dropzone.options.aDropImg = {
                maxFilesize: 5,
                maxFiles: 8,
                addRemoveLinks: true,
                dictResponseError: 'Server not Configured',
                acceptedFiles: ".png,.jpg,.jpeg",
                url: "file-upload.php",
                init:function(){
                  var self = this;
                  // config
                  self.options.addRemoveLinks = true;
                  self.options.dictRemoveFile = "Удалить";
                  //New file added
                  self.on("addedfile", function (file) {
                    console.log('new file added ', file);
                  });
                  // Send file starts
                  self.on("sending", function (file) {
                    console.log('upload started', file);
                    $('.meter').show();
                  });
                  
                  // File upload Progress
                  self.on("totaluploadprogress", function (progress) {
                    console.log("progress ", progress);
                    $('.roller').width(progress + '%');
                  });

                  self.on("queuecomplete", function (progress) {
                    $('.meter').delay(999).slideUp(999);
                  });
                  
                  // On removing file
                  self.on("removedfile", function (file) {
                    console.log(file);
                  });
                
                 // 
                  self.on("maxfilesexceeded", function (file) {
                     this.removeFile(file);

                  });
                }
              };
            })
            $('.add-file-mess').on('click',function(e){
                e.preventDefault();
                $(this).next().fadeToggle();

            })
        }
    }


    var selectCategory = function(){

        var $selectCategory = $('.select-category');
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


    var rangeSlider = function(){
        if ($.ui) {
            if ($('.slider-range-price').length) {
                $('.slider-range-price').slider({
                    range: true,
                    min: 0,
                    max: 500,
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
            if ($sliderRangeAddMoney.length) {
                
                $sliderRangeAddMoney.slider({
                    range: "min",
                    value: 20000,
                    min: $sliderRangeAddMoneyMinPrice,
                    max: $sliderRangeAddMoneyMaxPrice,
                    step: 10,
                    slide: function(e, ui) {
                      $sliderRangeAddMoneyVal.val(ui.value);
                    }
                });
                $sliderRangeAddMoneyVal.val($sliderRangeAddMoney.slider("value"));

            }
        }
    }
    var ajaxForm = function() {


    
        $('#form-add-money').on('submit',function(e){
            e.preventDefault();
            var $this = $(this);

            var $number = $this.find('.js-vn[data-type=number]');
            var error = { };

            if(!_.isEmpty(error)){
                return ViewMessageFromData($this, {error: error});
            }

            var errorNumber = $number.val();
            if (errorNumber < $sliderRangeAddMoneyMinPrice || errorNumber > $sliderRangeAddMoneyMaxPrice) {
                return ViewMessageFromData($this, {error: 'Введите сумму от ' + $sliderRangeAddMoneyMinPrice + ' до ' + $sliderRangeAddMoneyMaxPrice});
            }

            var action = $this.attr("action");

            $.ajax({
                url: action,
                data: $this.serialize(),
                dataType: "json",
                type: "POST",
                success: function(data){
                    return ViewMessageFromData($this, data);

                }
            });
            return false;
        })
    


        $filterAdsSearchTop.on('submit',function(e){
            e.preventDefault();
            var $this = $(this);

            var error = { };
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
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        })

        $filterAdsSearchLeft.on('submit',function(e){
            e.preventDefault();
            var $this = $(this);

            var error = { };
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
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        })

        $loginForm.on('submit', function(e){
            e.preventDefault();
            var $this = $(this);

            var $email = $this.find('.js-vn[data-type=email]');
            var $password = $this.find('.js-vn[data-type=password]');
            var error = { };

            

            var errorEmail = validation.email($email.val());
            if (errorEmail) {
                error.email = errorEmail;
            }

            var errorPass = validation.password($password.val());
            if (errorPass) {
                error.password = errorPass;
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
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });

        $formFeedback.on('submit', function(e){
            e.preventDefault();
            var $this = $(this);

            var $name = $this.find('.js-vn[data-type=name]');
            var $email = $this.find('.js-vn[data-type=email]');
            var $message = $this.find('.js-vn[data-type=message]');
            var error = { };

            

            var errorName = validation.name($name.val());
            if (errorName) {
                error.name = errorName;
            }

            var errorEmail = validation.email($email.val());
            if (errorEmail) {
                error.email = errorEmail;
            }

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
                    var inst = $.remodal.lookup[$('[data-remodal-id=modal-feedback]').data('remodal')];
                    console.log(inst);
                    inst.close();
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });

        $signupForm.on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            
            var $email = $this.find('.js-vn[data-type=email]');
            var $password = $this.find('.js-vn[data-type=password]');
            var $passwordConfirm = $this.find('.js-vn[data-type=confirm]');
            var error = { };

            

            var errorEmail = validation.email($email.val());
            if (errorEmail) {
                error.email = errorEmail;
            }

            var errorPassword = validation.password($password.val());
            if (errorPassword) {
                error.password = errorPassword;
            }

            var errorConfirmPassword = validation.confirmPassword($password.val(), $passwordConfirm.val());
            if(errorConfirmPassword){
                error.confirm = errorConfirmPassword;
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
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });

         $formPostAds.on('submit', function(e){

            e.preventDefault();
            var $this = $(this);

            var $title = $formPostAdsBox.find('.js-vn[data-type=title]');
            var $category = $formPostAdsBox.find('.js-vn[data-type=category]');
            var $categoryValid = $formPostAdsBox.find('.js-vn[data-type=category-valid]');
            var $price = $formPostAdsBox.find('.js-vn[data-type=price]');
            var $description = $formPostAdsBox.find('.js-vn[data-type=description]');
            var error = { };

            

            var errorTitle = validation.titleProduct($title.val());
            if (errorTitle) {
                error.title = errorTitle;
            }
            
            var errorCategory = validation.categoryProduct($category.val());
            if (errorCategory ) {
                error.category = errorCategory ;
            }

            var errorPrice = validation.price($price.val());
            if (errorPrice ) {
                error.price = errorPrice;
            }

            var errorDescription = validation.descProduct($description.val());
            if (errorDescription ) {
                error.description = errorDescription;
            }

            


            if(!_.isEmpty(error)){
                return ViewMessageFromData($this, {error: error});
            }

            var validCategory = $('.select-category').find('a').is(".valid-category");
            if (validCategory == false) {
                return ViewMessageFromData($this, {error: 'Выберите подкатегорию '});
            }
            

            var action = $this.attr("action");
            $.ajax({
                url: action,
                data: $this.serialize(),
                dataType: "json",
                type: "POST",
                success: function(data){
                    $formPostAdsBox.find('.js-vn').val();
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });

        $formMessageSeller.on('submit', function(e){

            e.preventDefault();
            var $this = $(this);

            var $name = $this.find('.js-vn[data-type=name]');
            var $email = $this.find('.js-vn[data-type=email]');
            var $message = $this.find('.js-vn[data-type=message]');

            var error = { };

            var errorName = validation.name($name.val());
            if (errorName) {
                error.name = errorName;
            }
            
            var errorEmail = validation.email($email.val());
            if (errorEmail) {
                error.email = errorEmail ;
            }

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

        $formRestorePass.on('submit', function(e){

            e.preventDefault();
            var $this = $(this);

            var $email = $this.find('.js-vn[data-type=email]');

            var error = { };

            var errorEmail = validation.email($email.val());
            if (errorEmail) {
                error.email = errorEmail ;
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
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });

        $formUserInfo.on('submit', function(e){

            e.preventDefault();
            var $this = $(this);

            var $name = $this.find('.js-vn[data-type=name]');
            var $email = $this.find('.js-vn[data-type=email]');
            var $phone = $this.find('.js-vn[data-type=phone]');

            var error = { };

            var errorName = validation.name($name.val());
            if (errorName) {
                error.name = errorName;
            }
            
            var errorEmail = validation.email($email.val());
            if (errorEmail) {
                error.email = errorEmail ;
            }

            var errorPhone = validation.phone($phone.val());
            if (errorPhone) {
                error.phone = errorPhone ;
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
                    return ViewMessageFromData($this, data);
                }
            });
            return false;
        });

        $formChangePass.on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            
  
            var $passwordOld = $this.find('.js-vn[data-type=passwordOld]');
            var $passwordNew = $this.find('.js-vn[data-type=passwordNew]');
            var $passwordConfirm = $this.find('.js-vn[data-type=confirm]');
            
            var error = { };

            

            var errorPasswordOld = validation.password($passwordOld.val());
            if (errorPasswordOld) {
                error.password = errorPasswordOld;
            }

            var errorPasswordNew = validation.newPassword($passwordOld.val(), $passwordNew.val());
            if (errorPasswordNew) {
                error.passwordNew = errorPasswordNew;
            }

            var errorConfirmPassword = validation.confirmPassword($passwordNew.val(), $passwordConfirm.val());
            if(errorConfirmPassword){
                error.confirm = errorConfirmPassword;
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

    var phoneMask = function(){
        if ($(".phone-mask")[0]) {
            jQuery(function($){
               $(".phone-mask").mask("+7 (999) 999-99-99");
            });
        }
    }




     var events = function(){
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
        /* change-pass-toggle*/
        $('.form-change-pass .title').on('click', function (e) {
            e.preventDefault();
            $(this).next().slideToggle();
        });
        /* change-pass-toggle*/

        $('a.to-id[href^="#"]').on('click', function(e) {
            e.preventDefault();

            var target = this.hash;
            var $target = $(target);

            $('html, body').animate({
              'scrollTop': $target.offset().top
            }, 700,function() {
              window.location.hash = target;
            });
          });
        

     }

    return {
        init: function(){
            initSelect(); 
            initSliders();
            initProductGalery();
            initProductTab();
            scrollToHref();
            initPreloader();
            toTop();
            slideToggleFilter ();
            initFormAuthReg();
            rangeSlider();
            limitFormArea();
            iploadImgPost();
            selectCategory();
            phoneMask();
            ajaxForm()
            events();

            
        }
    }
}()


var ViewMessage = function(msg, type, delay){
    var $hdMsg = $('.hdMsg');
    if(!delay) delay = 3500;
    $hdMsg.headerMessage({
        text: config.getMsg(msg),
        type: type,
        timeDelay: delay,
        formMsg: true
    }).viewMessage();
};
var ViewMessageFromData = function($this, data){
    var $hdMsg = $('.hdMsg');
    if(typeof data === "object") {
        if ("error" in data) {
            if(typeof data.error === "object") {
                var key, val, $el;
                for(key in data.error){
                    val = data.error[key];
                    break;
                }
                if(typeof $this === "object"){
                    $el = $this.find('.js-validation[data-type="' + key + '"], .js-vn[data-type="' + key + '"]');
                    $el.addClass('js-error');
                }
                $hdMsg.headerMessage({
                    text: config.getMsg(val),
                    type: "error",
                    formMsg: true
                }).viewMessage();
            }
            else{
                $hdMsg.headerMessage({
                    text: config.getMsg(data.error),
                    type: "error",
                    formMsg: true
                }).viewMessage();
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
            if(data.hash === ""){
                location.hash = "";
            }else{
                location.hash = data.hash;
            }
        }
        if ("msg" in data) {
            var msg = data.msg;

            if(typeof msg === "object"){
                msg = msg.success;
                if("img" in data.msg){
                    if($($this.data('imgsef'))[0])
                        $($this.data('imgsef')).attr('src', data.msg.img);
                    else location.reload();
                }
            }
            $hdMsg.headerMessage({
                text: config.getMsg(msg),
                type: "success",
                formMsg: true
            }).viewMessage();
        }else{
            return data;
        }
    }
    return;
};



