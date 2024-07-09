var SITE_TEMPLATE_PATH = '/local/templates/chernika/';

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

// function getAllFavorites() {
//     $.post( SITE_TEMPLATE_PATH + 'ajax.php', {action:'getFavAll'}, function( result ){
//         if ( !result.error ) {
//             $('body').find('.js-favorite').removeClass('active');
//             $('body').find('.js-favorite .tile').text('Добавить в избранное');
//
//             for (var prop in result.data.ids) {
//                 $('.js-favorite[data-id="' + result.data.ids[prop] + '"]').addClass('active');
//                 $('.js-favorite[data-id="' + result.data.ids[prop] + '"] .tile').text('Удалить из избранного');
//             }
//             // result.data.ids.forEach(function (value) {
//             //     $('body').find('.js-favorite[data-id="' + value + '"]').addClass('active');
//             //     $('body').find('.js-favorite[data-id="' + value + '"] .tile').text('Удалить из избранного');
//             // });
//             $('.js-favorites_count').text( result.data.favoriteCount );
//         }
//     }, 'json');
// }

function afterChangeBasket( data ) {
    $('.js-basket_count').text( data.COUNT );
    if ( data.basket.length > 0 )
        $('.js-cart_wrapper .cart-wrapper').html( $(data.basket).find(' .cart-wrapper').html() );
}

function maskInput() {
    $('#ORDER_PROP_3').mask("+7(999) 999 99-99",{placeholder:"_"});
    $('.phonemask').mask("+7(999) 999 99-99",{placeholder:"_"});
    $('.js-phone-mask').mask("+7(999) 999 99-99",{placeholder:"_"});
}
maskInput();

function changeOfferParams( offerParams, elem ){
    offerParams = offerParams.replace(/'/g, "\"");
    offerParams = offerParams.replace(/amp;/g, "");
    var offerParamsJson = JSON.parse(offerParams);

    var code = elem.data('code');

    if ( offerParamsJson[ code ] ) {
        var blockItem = elem.parent(),
            blockProd = blockItem.closest('.js-prod_card'),
            prodPicture = '',
            prodPrice = '',
            prodSize = '',
            buyBtn = '';

        if ( !blockProd.find('.js-prod_buy_wrap').hasClass('orderprice') ) {
            if ( parseInt(offerParamsJson[ code ]['OLD_PRICE']) > 0 )
                prodPrice += '<div class="price"><p><span class="price-title">Цена в салоне:</span><span class="price-before">' + offerParamsJson[ code ]['OLD_PRICE'] + ' <span>₽</span></span></p></div><div class="price"><p><span class="price-title">Цена со скидкой:</span><span class="price-after  js-prod_price_value">' + offerParamsJson[ code ]['PRICE'] + ' <span>₽</span></span></p></div>';
            else
                prodPrice += '<div class="price"><p>Цена:<span class="price-current js-prod_price_value">' + offerParamsJson[ code ]['PRICE'] + ' <span>₽</span></span></p></div>';

            blockProd.find('.js-prod_price').html( prodPrice );

            blockProd.find('.js-prod_nalichie').removeClass('nalichie_no');

            if ( offerParamsJson[ code ]['QUANTITY'] > 0 ) {
                if ( blockProd.find('.js-prod_buy_wrap').hasClass('order') )
                    buyBtn = '<div class="buy-btn js-prod_order" data-id="' + offerParamsJson[ code ]['ID'] + '"><a href="#">Купить со скидкой</a></div>';
                else
                    buyBtn = '<div class="buy-btn buy-btn_short js-buy" data-id="' + offerParamsJson[ code ]['ID'] + '"><a href="#">Купить</a></div>';

                blockProd.find('.js-prod_nalichie').html('Есть в наличии');

                blockProd.find('.js-count_wrap').attr('data-count', offerParamsJson[ code ]['QUANTITY']);
                blockProd.find('.js-count_wrap').show();
            }
            else {
                buyBtn = '<div class="buy-btn js-prod_preorder" data-id="' + offerParamsJson[ code ]['ID'] + '"><a href="#">Оформить предзаказ</a></div>';

                blockProd.find('.js-prod_nalichie').addClass('nalichie_no');
                blockProd.find('.js-prod_nalichie').html('Нет в наличии');

                blockProd.find('.js-count_wrap').attr('data-count', 0);
                blockProd.find('.js-count_wrap').hide();
            }

            blockProd.find('.js-prod_buy_wrap').html( buyBtn );
        }

        blockProd.find('.js-prod_order').attr('data-id', offerParamsJson[ code ]['ID'] );
        blockProd.find('.js-prod_order_spb').attr('data-id', offerParamsJson[ code ]['ID'] );

        if ( offerParamsJson[ code ]['PICTURE'] ) {
            prodPicture = '<div class="product-page-slider product-page-slider_initialized">';
            for ( p in offerParamsJson[ code ]['PICTURE'] ) {
                prodPicture += '<div class="product-page-slider-item"><img src="' + offerParamsJson[ code ]['PICTURE'][p] + '" alt="" class="img-responsive js-prod_img"></div>';
            }
            prodPicture += '</div>';

            if ( offerParamsJson[ code ]['PICTURE'].length > 1 ) {
                prodPicture += '<div class="product-page-slider-thumbs">';
                for ( p in offerParamsJson[ code ]['PICTURE'] ) {
                    prodPicture += '<div class="product-page-slider-thumbs-item slick-initialized"><img src="' + offerParamsJson[ code ]['PICTURE'][p] + '" alt="" class="js-prod_img_thumb"></div>';
                }
                prodPicture += '</div>';
            }

            $(".product-page-slider").slick("destroy");
            $(".product-page-slider-thumbs").slick("destroy");
            $(".product-page-slider-item").trigger("destroy");

            blockProd.find('.js-product_page_slider').html( prodPicture );

            $(".product-page-slider").slick({arrows:!1,dots:!0,mobileFirst:!0,asNavFor:".product-page-slider-thumbs",responsive:[{breakpoint:1023,settings:{dots:!1}}]});
            $(".product-page-slider-thumbs").slick({arrows:!1,dots:!1,mobileFirst:!0,slidesToShow:9,slidesToScroll:1,focusOnSelect:!0,asNavFor:".product-page-slider"});
            //$(".product-page-slider-item").zoom();
        }

        if ( !$.isEmptyObject(offerParamsJson[ code ]['SIZES']) ) {
            prodSize = '<div class="table">\n' +
                '<div class="table-row table-header">\n' +
                '    <div class="table-cell"></div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>Длина дужки</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>Ширина моста</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>Ширина линзы</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>Высота</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell"></div>\n' +
                '</div>';

            var firstCheck = false;
            for ( p in offerParamsJson[ code ]['SIZES'] ) {
                var disabled = ' disabled',
                    checked = '';

                if ( offerParamsJson[ code ]['SIZES'][p]['UF_AVAIL'] == 1 )
                    disabled = '';

                if ( !firstCheck && offerParamsJson[ code ]['SIZES'][p]['UF_AVAIL'] == 1  ) {
                    checked = ' checked';
                    firstCheck = true;
                }

                prodSize += '<div class="table-row' + disabled + '">\n' +
                '    <div class="table-cell">\n' +
                '        <label class="checkbox">\n' +
                '            <input type="checkbox" name="type" value="' + p + '"' + checked +'>\n' +
                '            <div class="control__indicator"></div>\n' +
                '        </label>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>' +  offerParamsJson[ code ]['SIZES'][p]['UF_DUZHKA'] + '</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>'  +  offerParamsJson[ code ]['SIZES'][p]['UF_MOST'] + '</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>' +  offerParamsJson[ code ]['SIZES'][p]['UF_LINZA'] + '</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">\n' +
                '        <p>' +  offerParamsJson[ code ]['SIZES'][p]['UF_HEIGHT'] + '</p>\n' +
                '    </div>\n' +
                '    <div class="table-cell">' +
                '        <p>' +  offerParamsJson[ code ]['SIZES'][p]['UF_TOTAL'] + '</p>\n' +
                '   </div>\n' +
                '</div>';
            }

            prodSize += '</div>';
        }

        blockProd.find('.js-sizes_table').html( prodSize );
    }
}

function isPiter() {
    return window.location.host.indexOf('spb') != -1;
}

$(document).ready(function() {
    var body = $('body'),
        myMap;

    body.on('keyup', '[type="email"],[name="email"]', function(){
        var email = $(this).val();
        if ( email.length > 0 )
        {
            if ( isValidEmailAddress(email) )
                $(this).removeClass('error');
            else
                $(this).addClass('error');
        }
        else
            $(this).removeClass('error');
    });
    body.on('change', '[type="email"],[name="email"]', function(){
        var email = $(this).val();
        if ( email.length > 0 )
        {
            if ( isValidEmailAddress(email) )
                $(this).removeClass('error');
            else
                $(this).addClass('error');
        }
        else
            $(this).removeClass('error');
    });

    var cityList = $('.js_citylist');
    $('.js-searchcity').keyup(function(){
        var val = $(this).val();
        if ( val.length > 2 ) {
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', {text:$(this).val(), action:'searchcity'}, function( result ){
                cityList.find('.custom').remove();
                if ( result.data.citylist.length > 0 ) {
                    cityList.find('.default').hide();
                    cityList.append( result.data.citylist );
                }
                else
                    cityList.find('.default').show();
            }, 'json');
        }
        else {
            cityList.find('.custom').remove();
            cityList.find('.default').show();
        }
    });

    // body.on('click', '.js_citylist-item', function(){
    //     cityList.find('.custom').remove();
    //     cityList.find('.default').show();
    //
    //     var id = $(this).data('id');
    //     $('.js-selcity').text( $(this).text() );
    //     $.post(SITE_TEMPLATE_PATH + 'ajax.php', {id:id, text: $(this).text(), action:'setcity'}, function () {
    //         /*if ( id == 85 ) {
    //             if ( isPiter() ) {
    //                 if ( window.location.pathname == '/personal/order/make/' ) {
    //                     $('#ORDER_PROP_4').val(id);
    //                     submitForm();
    //                 }
    //                 else
    //                     window.location.reload();
    //             }
    //             else
    //                 window.location.href = 'https://spb.' + window.location.host + window.location.pathname;
    //         }
    //         else {
    //             if ( !isPiter() ) {
    //                 if ( window.location.pathname == '/personal/order/make/' ) {
    //                     $('#ORDER_PROP_4').val(id);
    //                     submitForm();
    //                 }
    //                 else
    //                     window.location.reload();
    //             }
    //             else
    //                 window.location.href = 'https://' + window.location.host.replace('spb.','') + window.location.pathname;
    //         }*/
    //         if ( window.location.pathname == '/personal/order/make/' ) {
    //             $('#ORDER_PROP_4').val(id);
    //             submitForm();
    //         }
    //         else {
    //             window.location.reload();
    //         }
    //     });
    //     k50Tracker.change();
    // });

    var subsForm = $('#form-subscribe');
    subsForm.find('[name="agree"]').change(function(){
        var agree = subsForm.find('[name="agree"]').is(':checked');
        if ( agree )
            subsForm.find('[type="submit"]').prop('disabled', false);
        else
            subsForm.find('[type="submit"]').prop('disabled', true);
    });
    subsForm.submit(function () {
        var emailInput = subsForm.find('[name="email"]'),
            agree = subsForm.find('[name="agree"]').is(':checked');

        if ( emailInput.val().length == 0 )
            emailInput.addClass('error');

        if ( !emailInput.hasClass('error') && agree ) {
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', subsForm.serialize(), function(){
                subsForm.find('.js-body').html('<p class="tac">Вы успешно подписались на рассылку о новых тематических статьях, обзорах, новинках ассортимента и уникальных акциях нашего интернет-магазина.</p>');
            });
        }

        return false;
    });

    var reviewForm = $('#form-review');
    reviewForm.find('.star').click(function () {
        var block = $(this).parent(),
            index = $(this).index();
        block.find('.star').removeClass('active');
        for ( var i=0; i<=index; i++ ) {
            block.find('.star').eq(i).addClass('active');
        }
        block.parent().find('input').val( index + 1 );
        return false;
    });
    reviewForm.find('[name="agree"]').change(function(){
        var agree = reviewForm.find('[name="agree"]').is(':checked');
        if ( agree )
            reviewForm.find('[type="submit"]').prop('disabled', false);
        else
            reviewForm.find('[type="submit"]').prop('disabled', true);
    });
    reviewForm.submit(function () {
        var emailInput = reviewForm.find('[name="email"]'),
            textInput = reviewForm.find('[name="text"]'),
            agree = reviewForm.find('[name="agree"]').is(':checked'),
            error = false;

        reviewForm.find('input,select,textarea').removeClass('error');
        if ( emailInput.val().length == 0 ) {
            emailInput.addClass('error');
            error = true;
        }
        if ( textInput.val().length == 0 ) {
            textInput.addClass('error');
            error = true;
        }

        if ( !error && agree ) {
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', reviewForm.serialize(), function(){
                reviewForm.html('<p class="tac">Ваш отзыв отправлен, после модерации он появится на сайте.</p>');
            });
        }

        return false;
    });

    $('#form-profile').submit(function () {
        var form = $(this);
        form.find('[type="submit"]').prop('disabled', true);
        form.find('.text-success').remove();
        $.post(SITE_TEMPLATE_PATH + 'ajax.php', $(this).serialize(), function( result ){
            $('#form-profile').prepend( '<div class="form-item text-success">' + result.data.text + '</div>' );
            form.find('[type="submit"]').prop('disabled', false);
        }, 'json');

        return false;
    });

    $('#UF_RECIPE').change(function(){
        var fd = new FormData();
        fd.append('file', $('#UF_RECIPE')[0].files[0]);
        fd.append('action', 'recipe_file');
        $.ajax({
            url: SITE_TEMPLATE_PATH + 'ajax.php',
            type: 'POST',
            data: fd,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            success: function( result ){
                $('.js-recipe_file').remove();
                $('.recipe').after( result.data.text );
            }
        });
    });
    $(document).on('click', '.js-recipe_file', function() {
        $.post(SITE_TEMPLATE_PATH + 'ajax.php', {action:'recipe_file'}, function(){
            $('.js-recipe_file').remove();
        }, 'json');
    });
    $('.js-recipe_text_show').click(function() {
        $('.js-recipe_text').show();
    });
    $('.js-recipe_text textarea').keyup(function(){
        $.post(SITE_TEMPLATE_PATH + 'ajax.php', {text:$(this).val(), action:'recipe_text'});
    });
    $('.js-recipe_text textarea').change(function(){
        $.post(SITE_TEMPLATE_PATH + 'ajax.php', {text:$(this).val(), action:'recipe_text'});
    });

    // getAllFavorites();

    // body.on('click', '.js-favorite', function(){
    //     var link = $(this),
    //         block = link.closest('.col-6');
    //     $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:link.data('id'), action:'fav'}, function( result ){
    //         if ( !result.error ) {
    //             if ( window.location.pathname == '/favorite/' )
    //                 block.remove();
    //             getAllFavorites();
    //         }
    //     }, 'json');
    //
    //     return false;
    // });

    body.on('click', '.js-quick_see', function(e) {
        e.preventDefault();
        $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:$(this).data('id'), action:'quick'}, function( result ) {
            if ( !result.error ) {
                $('#fast-view-modal .fast-view').html( result.data.text );
                $.magnificPopup.open({
                    items: {
                        src: '#fast-view-modal',
                        type: "inline",
                        removalDelay: 300
                    },
                    mainClass: "mfp-fade_dark",
                    callbacks: {
                        open: function () {
                            $(".product-page-slider-fast").slick({arrows:!1,dots:!0,mobileFirst:!0,asNavFor:".product-page-slider-thumbs-fast",responsive:[{breakpoint:1023,settings:{dots:!1}}]});
                            $(".product-page-slider-thumbs-fast").slick({arrows:!1,dots:!1,mobileFirst:!0,slidesToShow:9,slidesToScroll:1,focusOnSelect:!0,asNavFor:".product-page-slider-fast"});
                            /*if ( $('#fast-view-modal .product-page-slider-item').length )
                                $('#fast-view-modal .product-page-slider-item').zoom();*/
                            // getAllFavorites();
                        },
                        close: function(){
                            $(".product-page-slider-fast").slick("destroy");
                            $(".product-page-slider-thumbs-fast").slick("destroy");
                        }
                    }
                });
            }
        }, 'json');

        return false;
    });

    body.on('click', '.js-buy', function(){
        var blockProd = $(this).closest('.js-prod_card'),
            type = parseInt(blockProd.find('[name="type"]:checked').val()),
            count = parseInt(blockProd.find('[name="count"]').val()),
            id = $(this).data('id');

        $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:id, type:type, count:count, action:'prod_add'}, function( result ){
            if ( !result.error ) {
                $('#to-cart-modal .js-img').attr('src', blockProd.find('.js-prod_img').first().attr('src') );
                $('#to-cart-modal .js-name').html( blockProd.find('.js-name').html() );
                $('#to-cart-modal .js-price').html( blockProd.find('.js-prod_price_value').html() );

                if ( blockProd.find('.js-view-colors .active').length ) {
                    $('#to-cart-modal .js-color').html( blockProd.find('.js-view-colors:visible').find('.active').attr('title') );
                    $('#to-cart-modal .js-color').parent().show();
                }
                else
                    $('#to-cart-modal .js-color').parent().hide();

                if ( type > 0 ) {
                    var size = '',
                        sizeRow = blockProd.find('.js-sizes_table input:checked').closest('.table-row').find('p');
                    sizeRow.each(function( index, value ){
                        if ( index < 4 )
                            size += $(this).text() + '-';
                    });

                    $('#to-cart-modal .js-size').html( size.substr(0, size.length-1) );
                    $('#to-cart-modal .js-size').parent().show();
                }
                else
                    $('#to-cart-modal .js-size').parent().hide();


                if ( blockProd.find('.js-article') ) {
                    $('#to-cart-modal .js-article').html( blockProd.find('.js-article').html() );
                    $('#to-cart-modal .js-article').parent().show();
                }
                else
                    $('#to-cart-modal .js-article').parent().hide();

                $('#to-cart-modal .js-podbor').attr('href', '/podbor/?id=' + id);

                $.magnificPopup.open({
                    items: {
                        src: '#to-cart-modal',
                        type: "inline",
                        removalDelay: 300
                    },
                    mainClass: "mfp-fade_dark"
                });

                afterChangeBasket( result.data.basketData );
            }
        }, 'json');

        return false;
    });

    body.on('click', '.js-basket_remove', function() {
        $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:$(this).data('id'), action:'prod_remove'}, function( result ){
            if ( !result.error )
                afterChangeBasket( result.data.basketData );
        }, 'json');

        return false;
    });

    body.on('click', '.js-basket_plus', function() {
        var countWrap = $(this).closest('.cart-item-price-qty');
        $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:countWrap.data('id'), count: parseInt(countWrap.find('input').val()) + 1, action:'prod_change'}, function( result ){
            if ( !result.error )
                afterChangeBasket( result.data.basketData );
        }, 'json');
    });

    body.on('change', '.js-basket_count', function() {
        var countWrap = $(this).closest('.cart-item-price-qty');
        $(this).val( parseInt($(this).val()) );

        $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:countWrap.data('id'), count: parseInt(countWrap.find('input').val()), action:'prod_change'}, function( result ){
            if ( !result.error )
                afterChangeBasket( result.data.basketData );
        }, 'json');
    });

    body.on('click', '.js-basket_minus', function() {
        var countWrap = $(this).closest('.cart-item-price-qty');
        if ( parseInt(countWrap.find('input').val()) > 1 ) {
            $.post( SITE_TEMPLATE_PATH + 'ajax.php', {id:countWrap.data('id'), count: parseInt(countWrap.find('input').val()) - 1, action:'prod_change'}, function( result ){
                if ( !result.error ) {
                    afterChangeBasket( result.data.basketData );
                }
            }, 'json');
        }
    });

    body.on('click', '.js-city', function() {
        $.magnificPopup.open({
            items: {
                src: '#city-modal',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    body.on('click', '.js-prod_order', function() {
        $('#prod-order [name="id"]').val( $(this).data('id') );
        $('#prod-order [name="type"]').val( $(this).closest('.js-prod_card').find('[name="type"]:checked').val() );
        $.magnificPopup.open({
            items: {
                src: '#prod-order',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    body.on('click', '.js-prod_order_spb', function() {
        $('#prod-order_spb [name="id"]').val( $(this).data('id') );
        $('#prod-order_spb [name="type"]').val( $(this).closest('.js-prod_card').find('[name="type"]:checked').val() );
        $.magnificPopup.open({
            items: {
                src: '#prod-order_spb',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    body.on('click', '.js-prod_preorder', function() {
        $('#prod-preorder [name="id"]').val( $(this).data('id') );
        $('#prod-preorder [name="type"]').val( $(this).closest('.js-prod_card').find('[name="type"]:checked').val() );
        $.magnificPopup.open({
            items: {
                src: '#prod-preorder',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    var proporderForm = $('#form-prod-order');
    proporderForm.find('[name="agree"]').change(function(){
        var agree = proporderForm.find('[name="agree"]').is(':checked');
        if ( agree )
            proporderForm.find('[type="submit"]').prop('disabled', false);
        else
            proporderForm.find('[type="submit"]').prop('disabled', true);
    });
    proporderForm.submit(function () {
        var error = false,
            phoneInput = proporderForm.find('[name="phone"]'),
            agree = proporderForm.find('[name="agree"]').is(':checked');

        proporderForm.find('input').removeClass('error');
        if ( phoneInput.val().length == 0 ) {
            phoneInput.addClass('error');
            error = true;
        }

        if ( !error && agree ) {
            proporderForm.find('[type="submit"]').prop('disabled', true);
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', proporderForm.serialize(), function(){
                /*proporderForm.find('.form-items').html('<p class="tac">Заявка успешно отправлена</p>');*/
                window.location.href = "/spasibo";
            });
        }

        return false;
    });

    var proporderspbForm = $('#form-prod-order_spb');
    proporderspbForm.find('[name="agree"]').change(function(){
        var agree = proporderspbForm.find('[name="agree"]').is(':checked');
        if ( agree )
            proporderspbForm.find('[type="submit"]').prop('disabled', false);
        else
            proporderspbForm.find('[type="submit"]').prop('disabled', true);
    });
    proporderspbForm.submit(function () {
        var error = false,
            phoneInput = proporderspbForm.find('[name="phone"]'),
            agree = proporderspbForm.find('[name="agree"]').is(':checked');

        proporderspbForm.find('input').removeClass('error');
        if ( phoneInput.val().length == 0 ) {
            phoneInput.addClass('error');
            error = true;
        }

        if ( !error && agree ) {
            proporderspbForm.find('[type="submit"]').prop('disabled', true);
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', proporderspbForm.serialize(), function(){
                /*proporderForm.find('.form-items').html('<p class="tac">Заявка успешно отправлена</p>');*/
                window.location.href = "/spasibo";
            });
        }

        return false;
    });


    var proppreorderForm = $('#form-prod-preorder');
    proppreorderForm.find('[name="agree"]').change(function(){
        var agree = proppreorderForm.find('[name="agree"]').is(':checked');
        if ( agree )
            proppreorderForm.find('[type="submit"]').prop('disabled', false);
        else
            proppreorderForm.find('[type="submit"]').prop('disabled', true);
    });
    proppreorderForm.submit(function () {
        var error = false,
            phoneInput = proppreorderForm.find('[name="phone"]'),
            agree = proppreorderForm.find('[name="agree"]').is(':checked');

        proppreorderForm.find('input').removeClass('error');
        if ( phoneInput.val().length == 0 ) {
            phoneInput.addClass('error');
            error = true;
        }

        if ( !error && agree ) {
            proppreorderForm.find('[type="submit"]').prop('disabled', true);
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', proppreorderForm.serialize(), function(){
                /*proppreorderForm.find('.form-items').html('<p class="tac">Заявка успешно отправлена</p>');*/
                window.location.href = "/spasibo";
            });
        }

        return false;
    });

    body.on('click', '.js-prod_orderprice', function() {
        $('#prod-orderprice [name="id"]').val( $(this).data('id') );
        $('#prod-orderprice [name="type"]').val( $(this).closest('.js-prod_card').find('[name="type"]:checked').val() );
        $.magnificPopup.open({
            items: {
                src: '#prod-orderprice',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    var orderpriceForm = $('#form-prod-orderprice');
    orderpriceForm.find('[name="agree"]').change(function(){
        var agree = orderpriceForm.find('[name="agree"]').is(':checked');
        if ( agree )
            orderpriceForm.find('[type="submit"]').prop('disabled', false);
        else
            orderpriceForm.find('[type="submit"]').prop('disabled', true);
    });
    orderpriceForm.submit(function () {
        var error = false,
            phoneInput = orderpriceForm.find('[name="phone"]'),
            agree = orderpriceForm.find('[name="agree"]').is(':checked');

        orderpriceForm.find('input').removeClass('error');
        if ( phoneInput.val().length == 0 ) {
            phoneInput.addClass('error');
            error = true;
        }

        if ( !error && agree ) {
            orderpriceForm.find('[type="submit"]').prop('disabled', true);
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', orderpriceForm.serialize(), function(){
                /*proporderForm.find('.form-items').html('<p class="tac">Заявка успешно отправлена</p>');*/
                window.location.href = "/spasibo";
            });
        }

        return false;
    });

    body.on('change', '.js-price_range', function(){
        var filterBlock = $(this).closest('.js-prop_wrap');
        filterBlock.find('.js-price_range').not( $(this) ).prop('checked', false);
        if ( $(this).is(':checked') ) {
            filterBlock.find('.min-price').val( $(this).data('from') );
            filterBlock.find('.max-price').val( $(this).data('to') );
        }
        else {
            filterBlock.find('.min-price').val('');
            filterBlock.find('.max-price').val('');
        }
        filterBlock.find('.min-price').trigger('keyup');
        filterBlock.find('.min-price').trigger('change');
    });

    body.on('click', 'a.js-filter', function(){
        var url = $(this).attr('href');
        $.get(url, function(data){
            $('.js-catalog_sort').html( $(data).find('.js-catalog_sort').html() );
            $('.js-catalog_wrap').html( $(data).find('.js-catalog_wrap').html() );
            $('.js-catalog_pagination').html( $(data).find('.js-catalog_pagination').html() );
            $('.js-filter_reset').attr('href', $('#filter-side').data('reset-href'));
			
				$('.linkReplace').each(function() { 
					var linkHref = $(this).data('href'); 
					var linkClass = $(this).attr('class'); 
					var linkExternal = $(this).data('ext'); 
					var linkText = $(this).html(); 
					var linkBlank = ''; 
					if(linkExternal == "Y") linkBlank = 'target="_blank"'; 
				
					$(this).after('<a href="'+linkHref+'" '+linkBlank+' class="'+linkClass+'">'+linkText+'</a>').remove(); 
				}); 
            history.pushState(null, null, url);
        });

        return false;
    });

    body.on('change', 'input.js-filter', function(){
        $('#' + $(this).data('filter')).trigger('click');
        return false;
    });

    body.on('click', '.js-openmap', function(){
        $.magnificPopup.close();

        var coord = $(this).data('coord').split(','),
            name = $(this).data('name');

        setTimeout(function() {
            $.magnificPopup.open({
                items: {
                    src: '#map_city',
                    type: "inline",
                    removalDelay: 300
                },
                mainClass: "mfp-fade_dark",
                callbacks: {
                    open: function () {
                        myMap = new ymaps.Map("popup_salon_map", {
                            center: coord,
                            zoom: 10,
                            controls: ['zoomControl']
                        });
                        var myPlacemark = new ymaps.Placemark(coord, {
                            balloonContent: name
                        });
                        myMap.geoObjects.add(myPlacemark);
                    },
                    close: function () {
                        myMap.destroy();
                    }
                }
            });
        }, 300);

        return false;
    });

    body.on('click', '.js-view-colors li', function() {
        var blockItem = $(this),
            block = blockItem.closest('.js-view-colors'),
            blockProd = blockItem.closest('.js-prod_card'),
            prodPicture = blockItem.data('pic'),
            prodPrice = '';

        block.find('li').removeClass('active');
        blockItem.addClass('active');

        if ( blockProd.hasClass('product-page') || blockProd.hasClass('fast-view') ) {
            changeOfferParams( offerParams, blockItem );
        }
        else {
            if ( prodPicture.length == 0 )
                prodPicture = SITE_TEMPLATE_PATH + '/img/no_photo.png';
            blockProd.find('.js-prod_img').attr('src', prodPicture);

            if ( parseInt(blockItem.data('oldprice')) > 0 )
                prodPrice += '<span class="product-price_old">' + blockItem.data('oldprice') + ' ₽</span><span class="product-price_current">' + blockItem.data('price') + ' ₽</span>';
            else
                prodPrice += '<span><b>' + blockItem.data('price') + ' ₽</b></span>';

            blockProd.find('.js-prod_price').html( prodPrice );
        }

        return false;
    });

    $('.js-link_register_popup').click(function(){
        $.magnificPopup.open({
            items: {
                src: '#register-modal',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    $('.js-link_auth_popup').click(function(){
        $.magnificPopup.open({
            items: {
                src: '#login-modal',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });

        return false;
    });

    var registerForm = $('#form-register');
    registerForm.submit(function () {
        var error = false,
            nameInput = registerForm.find('[name="name"]'),
            emailInput = registerForm.find('[name="email"]'),
            password = registerForm.find('[name="password"]'),
            repassword = registerForm.find('[name="repassword"]');

        registerForm.find('input').removeClass('error');
        registerForm.find('.form-item-error').hide();
        if ( nameInput.val().length == 0 ) {
            nameInput.addClass('error');
            error = true;
        }
        if ( emailInput.val().length == 0 ) {
            emailInput.addClass('error');
            error = true;
        }
        if ( password.val().length == 0 ) {
            password.addClass('error');
            error = true;
        }
        if ( repassword.val().length == 0 ) {
            repassword.addClass('error');
            error = true;
        }

        if ( !error ) {
            registerForm.find('[type="submit"]').prop('disabled', true);
            $.post(SITE_TEMPLATE_PATH + 'ajax.php', registerForm.serialize(), function( result ){
                if ( result.error ) {
                    registerForm.find('.form-item-error').html( result.error_text );
                    registerForm.find('.form-item-error').show();
                    registerForm.find('[type="submit"]').prop('disabled', false);
                }
                else
                    window.location.reload();
            }, 'json');
        }

        return false;
    });

    body.on('click', '.qty-minus', function(){
        var priceQty = $(this).closest('.cart-item-price-qty'),
            priceQtyInput = priceQty.find('input'),
            count = parseInt(priceQtyInput.val());
        if ( count > 1 )
            priceQtyInput.val(count - 1);
        return false;
    });
    body.on('click', '.qty-plus', function(){
        var priceQty = $(this).closest('.cart-item-price-qty'),
            priceQtyInput = priceQty.find('input'),
            count = parseInt(priceQtyInput.val());

        if ( count < parseInt(priceQty.attr('data-count')) )
            priceQtyInput.val(count + 1);
        return false;
    });

    body.on('click', '.js-load_more', function(){
        var href = $(this).attr('href');
        $.get(href, function(data){
            $('.js-catalog_sort').html( $(data).find('.js-catalog_sort').html() );
            $('.js-catalog_wrap .row:first-child').append( $(data).find('.js-catalog_wrap .row:first-child').html() );
            $('.js-catalog_pagination').html( $(data).find('.js-catalog_pagination').html() );
            history.pushState(null, null, href);
        });

        return false;
    });

    body.on("click", ".popup-link", function () {
        $.magnificPopup.open({
            items: {
                src: $(this).attr('href'),
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });
    });

    // body.on("click", ".js-show_brands", function () {
    //     $(this).closest('.brands').find('.brands-hidden').css('display', 'flex');
    //     $(this).hide();
    //     return false;
    // });

    $('.js-filter_reset').attr('href', $('#filter-side').data('reset-href'));

    $('.popup__image__show').on('click', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        var _this = $(this);
        setTimeout(function () {
            $.magnificPopup.open({
                items: {
                    src: _this.attr('href'),
                    type: 'image'
                },
                closeOnContentClick: true,
                image: {
                    verticalFit: true,
                    titleSrc: function(item) {
                        return '<h4 style="color:#fff">' + _this.attr('title') + '</h4>';
                    }
                }
            })
        }, 500)
    });
});
