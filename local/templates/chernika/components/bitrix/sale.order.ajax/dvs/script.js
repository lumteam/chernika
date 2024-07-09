'use strict';
$(function () {
    var $focusedElement,
        validateTimeout,
        requestTimeout,
        cartTimeout,
        validate,
        spinnerTimeout;

    var OrderComponent = function (options) {
        var defaults = {
            containerSelector: '#js-order-form-container',
            formId: '#js-order-form',
            globalPreloader: '#un-preloader'
        };
        if (typeof options !== 'object') {
            options = {};
        }
        this.opts = $.extend({}, defaults, options);

        this.$globalPreloader = $(this.opts.globalPreloader);
        this.$container = $(this.opts.containerSelector);
        this.$container.data('Component', this);

        this.step = 1;

        this.hideCaptcha();
        this.initPlugins();
        this.bindEvents();
        this.hideLoader();
        $(this.opts.formId).validate();
        // this.validate();
        // this.replaceOrderText();
    };

    OrderComponent.prototype.initPlugins = function () {
        var self = this;

        // if (typeof phoneFormat !== 'undefined') {
        //     self.$container.find('.js-phone-mask').inputmask(phoneFormat); // see footer
        // }
    };

    OrderComponent.prototype.bindEvents = function () {
        var self = this,
            hasErrorClass = false;

        // Авторизация
        self.$container.find('[data-order-auth]').on('click', function (e) {
            e.preventDefault();
            self.authorize();
        });

        // Валидация формы при изменении обязательных полей
        // self.$container.find('[required]')/*.on('focusin', function() {
        //     var $parentDiv = $(this).parents('.c-input-field');
        //     hasErrorClass = $parentDiv.hasClass('is-error');
        //     $parentDiv.removeClass('is-error');
        // })*/.on('keydown', function(event) {
        //     console.log(event.keyCode);
        //     hasErrorClass = self.validateVal(this);
        // })/*.on('change', function() {
        //     hasErrorClass = self.validateVal(this);
        // })*/.on('focusout', function() {
        //     if (hasErrorClass) {
        //         $(this).parents('.c-input-field').addClass('is-error');
        //     }
        // });

        // Запоминаем фокус на элементах для ajax обновления
        // self.$container.on('keydown click focus', function(e) {
        //     var $element = $(e.target);
        //     setTimeout(function() {
        //         $focusedElement = $element;
        //     }, 1);
        // });

        // Смена района доставки
        if (self.opts.locationInputName.length > 0) {
            self.$container.find('input[name="' + self.opts.locationInputName + '"]').on('change', function () {
                if (parseInt($(this).val()) > 0)
                    self.sendRequest();
            });
        }

        // Изменение способа оплаты
        self.$container.find('[data-order-payment]').on('change', function (e) {
            e.preventDefault();
            self.sendRequest();
        });

        // Изменение способа доставки
        self.$container.find('[data-order-delivery] :radio, [data-order-delivery] select').on('change', function (e) {
            e.preventDefault();
            self.sendRequest();
        });

        $.validator.setDefaults({
            submitHandler: function (form) {
                self.setConfirmed(true);
                self.sendRequest();
            }
        });

        // Финальная проверка и отправка заказа
        // self.$container.find('[data-order-submit]').on('click', function (e) {
        //     e.preventDefault();
        //
        //     alert(validate.valid());
        //
        //     // if (!$(this).prop('disabled') && self.validate(true)) {
        //     if (!$(this).prop('disabled') && validator.valid()) {
        //         self.clearErrors();
        //         self.setConfirmed(true);
        //         self.sendRequest();
        //     }
        // });

        // (document).on('submit', '#js-order-form', function (e) {
        //     e.preventDefault();
        //     $(this).removeData("validator").removeData("unobtrusiveValidation");//remove the form validation
        //     $.validator.unobtrusive.parse($(this));//add the form validation
        //
        //     if ($(this).valid()) {
        //         alert('valid');
        //     } else {
        //         alert('not valid');
        //     }
        // });
    };

    // OrderComponent.prototype.validateVal = function(input) {console.log('validateVal');
    //     var hasErrors = false,
    //         $t = $(input),
    //         $parentDiv = $t.parents('.c-input-field'),
    //         value = $t.val().trim(),
    //         pattern = $t.attr('pattern') || false;
    //
    //     $parentDiv.removeClass('is-error is-success');
    //
    //     if (typeof pattern === 'undefined' || pattern === false) {
    //         pattern = '\\S'; //not empty
    //     }
    //     if (value.search(pattern) == -1) {
    //         hasErrors = true;
    //         $parentDiv.addClass('is-error');
    //     } else {
    //         if (!$t.hasClass('bx-ui-sls-fake') && !$t.hasClass('dropdown-field')) {
    //             $parentDiv.addClass('is-success');
    //         }
    //     }
    //
    //     return hasErrors;
    // };

    // OrderComponent.prototype.validate = function (final, $parent) {
    //     var $container;
    //     if (typeof $parent !== 'undefined') {
    //         $container = $parent;
    //     } else {
    //         $container = this.$container;
    //     }
    //
    //     var hasErrors = false,
    //         firstErrorInput = false;
    //
    //     $container.find('[required]').each(function () {
    //         var $t = $(this),
    //             value = $t.val().trim(),
    //             pattern = $t.attr('pattern') || false;
    //
    //         if (typeof pattern === 'undefined' || pattern === false) {
    //             pattern = '\\S'; //not empty
    //         }
    //
    //         if (value.search(pattern) == -1) {
    //             hasErrors = true;
    //
    //             if (!firstErrorInput) {
    //                 firstErrorInput = $t;
    //             }
    //
    //             if (final) {
    //                 // $(this).block().toggleClass('-is-error', hasErrors);
    //                 $t.parents('.c-input-field').toggleClass('is-error', hasErrors);
    //             }
    //         }
    //     });
    //
    //     // $container.find('[data-order-submit]').prop('disabled', hasErrors);
    //     // $('#order-submit').prop('disabled', hasErrors);
    //
    //     if (firstErrorInput && final) {
    //         firstErrorInput.focus();
    //     }
    //
    //     return !hasErrors;
    // };

    OrderComponent.prototype.sendRequest = function (initial) {
        var self = this;

        clearTimeout(requestTimeout);
        requestTimeout = setTimeout(function () {
            $.ajax({
                url: window.location.href,
                type: 'post',
                data: 'ajax=1' + (!initial ? '&' + self.serializeForm() : ''),
                beforeSend: function () {
                    self.showLoader();
                },
                success: function (response) {
                    // console.log('sendRequest = ');console.log(response);
                    // console.log(typeof response.order.REDIRECT_URL);console.log(response.order.REDIRECT_URL.length);
                    // if (typeof response.order.REDIRECT_URL !== 'undefined' && response.order.REDIRECT_URL.length > 0) {
                    //     window.location.href = response.order.REDIRECT_URL;
                    // }
                    self.refresh(response);
                    self.hideLoader();
                }
            });
        }, 50);

        return false;
    };

    OrderComponent.prototype.refresh = function (response) {
        var $responseOrder = $('<div>').append($(response)).find(this.opts.containerSelector),
            orderData = $responseOrder.data();

        // console.log('orderData = ');
        // console.log(orderData);

        if (typeof orderData.orderId !== 'undefined' && parseInt(orderData.orderId) > 0) {
            window.location.href = '/personal/orders/detail/' + orderData.orderId + '/';
        } else if ($responseOrder.find('#redirect').length > 0) {
            window.location.href = $responseOrder.find('#redirect').html();
        } else {
            this.$container.html($responseOrder.html());
            // this.$container.initPlugins();
            this.initPlugins();
            this.bindEvents();
            // this.returnStep();
            this.revertFocus();
            // this.validate();
            $(this.opts.formId).validate();
            // this.replaceOrderText();
        }
    };

    // OrderComponent.prototype.replaceOrderText = function() {
    //     var $hiddenText = this.$container.find('[data-order-delivery] input:checked').closest('li').find('.delivery-text-hidden'),
    //         $orderText = $('.order-delivery-text');
    //
    //     if($hiddenText.length > 0) {
    //         $orderText.html($hiddenText.html());
    //     } else {
    //         $orderText.html('');
    //     }
    // };

    OrderComponent.prototype.authorize = function () {
        var self = this;

        var data = 'action=auth&' + $('[data-tabs-content="auth"] :input').serialize();

        $.ajax({
            url: '/ajax/auth.php',
            type: 'post',
            data: data,
            beforeSend: function () {
                self.showLoader();
                self.clearErrors();
            },
            success: function (response) {
                console.log('response = ');
                console.log(response);
                if (response.status) {
                    self.sendRequest(true);
                } else {
                    if (response.captcha) {
                        self.showCaptcha(response.captcha);
                    }
                    self.showError(response.error);
                    self.hideLoader();
                }
            }
        });
    };

    OrderComponent.prototype.setConfirmed = function (value) {
        this.$container.find('[name="confirmorder"]').val(value ? 'Y' : 'N');
    };

    OrderComponent.prototype.revertFocus = function () {
        if (typeof $focusedElement === 'object') {
            this.$container.find('input[name="' + $focusedElement.attr('name') + '"]').trigger('focus');
        }
    };

    OrderComponent.prototype.serializeForm = function () {
        return this.$container.find('[data-order-form]').serialize();
    };

    OrderComponent.prototype.showError = function (error) {
        this.$container.find('[data-order-errors]').addClass('-is-active').append(error);
    };

    OrderComponent.prototype.clearErrors = function () {
        this.$container.find('[data-order-errors]').removeClass('-is-active').empty();
    };

    OrderComponent.prototype.showLoader = function () {
        this.$globalPreloader.addClass('show');
    };

    OrderComponent.prototype.hideLoader = function () {
        this.$globalPreloader.removeClass('show');
    };

    OrderComponent.prototype.showCaptcha = function (sid) {
        var $captcha = this.$container.find('[data-order-captcha]');
        $captcha.find('img').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + sid);
        $captcha.find('input[name="captcha_sid"]').val(sid);
        $captcha.addClass('-is-visible');
    };

    OrderComponent.prototype.hideCaptcha = function () {
        var $captcha = this.$container.find('[data-order-captcha]');
        $captcha.removeClass('-is-visible');
        $captcha.find('img').attr('src', '');
        $captcha.find('input[name="captcha_sid"]').val('');
    };

    // OrderComponent.prototype.isMobile = function() {
    //     if (typeof window.matchMedia === 'function') {
    //         return window.matchMedia('(max-width: 710px)').matches;
    //     }
    //
    //     return false;
    // };

    $(function () {
        $.orderComponent = {
            init: function (options) {
                return new OrderComponent(options);
            }
        };

        $.orderComponent.init({
            containerSelector: '#js-order-form-container',
            locationInputName: locationInputName // see template
        });
    });

});