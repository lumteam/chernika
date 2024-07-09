        <?if ( !$isAjax ):?>
                <?if ( !$isHomePage && !$isCatalog && !$is404 ) {?></div><? } ?>
            </div>
            <footer class="footer">
                <div class="container">
                    <div class="footer-top">
                        <div class="footer-menu d-none d-xl-block">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                array(
                                    "AREA_FILE_SHOW" => "sect",
                                    "AREA_FILE_SUFFIX" => "footer_inc",
                                    "EDIT_TEMPLATE" => "",
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "AREA_FILE_RECURSIVE" => "Y"
                                ),
                                false
                            );?>
                            <?=\PDV\Tools::getAddressFooter($CITY_NAME)?>
                            <?=\PDV\Tools::getPhoneFooter($CITY_NAME)?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                array(
                                    "AREA_FILE_SHOW" => "sect",
                                    "AREA_FILE_SUFFIX" => "footer_pay_inc",
                                    "EDIT_TEMPLATE" => "",
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "AREA_FILE_RECURSIVE" => "Y"
                                ),
                                false
                            );?>
                        </div>
                        <div class="footer-menu d-none d-md-block">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "bottom",
                                Array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(""),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "Y",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "bottom",
                                    "USE_EXT" => "N"
                                )
                            );?>
                        </div>
                        <div class="footer-menu">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "bottom",
                                Array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(""),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "Y",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "bottom2",
                                    "USE_EXT" => "N"
                                )
                            );?>
                        </div>
                        <div class="footer-menu">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "bottom",
                                Array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(""),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "Y",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "bottom3",
                                    "USE_EXT" => "N"
                                )
                            );?>
                        </div>
                    </div>
                    <div class="footer-middle d-xl-none">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "fotter2_inc",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "AREA_FILE_RECURSIVE" => "Y"
                            ),
                            false
                        );?>
                    </div>
                    <div class="footer-bottom"><a href="/data-processing/">Обработка данных</a><a href="/privacy-policy/">Политика конфиденциальности</a>
                        <div class="footer-middle-socials">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                array(
                                    "AREA_FILE_SHOW" => "sect",
                                    "AREA_FILE_SUFFIX" => "footer_social_inc",
                                    "EDIT_TEMPLATE" => "",
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "AREA_FILE_RECURSIVE" => "Y"
                                ),
                                false
                            );?>
                        </div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "footer_create_inc",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "AREA_FILE_RECURSIVE" => "Y"
                            ),
                            false
                        );?>
                    </div>
                </div>
            </footer>
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "top-menu-mobile",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "top",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "Y",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "top-menu-mobile",
                    "USE_EXT" => "N",
                    "CITY_NAME" => $CITY_NAME
                )
            );?>
        </div>

        <div id="map_city" class="mfp-hide city-container map-container">
            <button class="mfp-close">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                    <defs>
                        <path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                    </defs>
                    <g>
                        <g transform="translate(-343 -19)">
                            <use fill="#202020" xlink:href="#acpka"></use>
                        </g>
                    </g>
                </svg>
            </button>
            <div id="popup_salon_map" class="map_city"></div>
        </div>

        <div id="prod-order" class="mfp-hide city-container">
            <div class="modal-header">
                <h4>Отправить заявку</h4>
                <button class="mfp-close">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                        <defs>
                            <path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                        </defs>
                        <g>
                            <g transform="translate(-343 -19)">
                                <use fill="#202020" xlink:href="#acpka"></use>
                            </g>
                        </g>
                    </svg>
                </button>
            </div>
            <form class="feedbacks-modal-body" id="form-prod-order">
                <div class="form-items">
                    <div class="form-item text-center">
                        Заполните форму для получения скидки или запишитесь к нам по телефону 8 (800) 302-32-89
                    </div>
                    <div class="form-item">
                        <input type="text" placeholder="Введите имя: (Не обязательно)" class="input" name="name">
                    </div>
                    <div class="form-item">
                        <input type="text" placeholder="Введите номер телефона:" class="input phonemask" name="phone" required>
                    </div>
                    <div class="form-item">
                        <input type="email" placeholder="Введите ваш e-mail: (Не обязательно)" class="input" name="email">
                    </div>
                    <div class="form-item">
                        <textarea name="text" cols="20" rows="10" placeholder="Комментарий: (Не обязательно)" class="textarea"></textarea>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="submit-btn">Отправить</button>
                    </div>
                    <div class="form-item">
                        <label class="checkbox">Согласен на обработку <a href="#">персональных данных</a>, а также с условиями оферты.
                            <input type="checkbox" checked="checked" name="agree">
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="id" value="">
                <input type="hidden" name="type" value="">
                <input type="hidden" name="action" value="prood_order">
            </form>
        </div>

        <div id="prod-preorder" class="mfp-hide city-container">
            <div class="modal-header">
                <h4>Оформить предзаказ</h4>
                <button class="mfp-close">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                        <defs>
                            <path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                        </defs>
                        <g>
                            <g transform="translate(-343 -19)">
                                <use fill="#202020" xlink:href="#acpka"></use>
                            </g>
                        </g>
                    </svg>
                </button>
            </div>
            <form class="feedbacks-modal-body" id="form-prod-preorder">
                <div class="form-items">
                    <div class="form-item">
                        <input type="text" placeholder="Введите имя:" class="input" name="name">
                    </div>
                    <div class="form-item">
                        <input type="text" placeholder="Введите номер телефона:" class="input phonemask" name="phone" required>
                    </div>
                    <div class="form-item">
                        <input type="email" placeholder="Введите ваш e-mail:" class="input" name="email">
                    </div>
                    <div class="form-item">
                        <textarea name="text" cols="20" rows="10" placeholder="Комментарий:" class="textarea"></textarea>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="submit-btn">Отправить</button>
                    </div>
                    <div class="form-item">
                        <label class="checkbox">Согласен на обработку <a href="#">персональных данных</a>, а также с условиями оферты.
                            <input type="checkbox" checked="checked" name="agree">
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="id" value="">
                <input type="hidden" name="type" value="">
                <input type="hidden" name="action" value="prood_preorder">
            </form>
        </div>

        <div id="to-cart-modal" class="mfp-hide city-container add-to-cart__container">
            <div class="modal-header">
                <h4>Товар добавлен в корзину</h4>
                <button class="mfp-close">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                        <defs>
                            <path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                        </defs>
                        <g>
                            <g transform="translate(-343 -19)">
                                <use fill="#202020" xlink:href="#acpka"></use>
                            </g>
                        </g>
                    </svg>
                </button>
            </div>
            <div class="modal__content">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="add-to-cart__img"><img src="" alt="" class="img-responsive js-img"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="add-to-cart-item-info-title marginless js-name"></p>
                        <p class="add-to-cart-item-info-size light-color marginless">Артикул: <span class="js-article"></span></p>
                        <p class="add-to-cart-item-info-size light-color marginless">Размер: <span class="js-size"></span></p>
                        <p class="add-to-cart-item-info-color light-color marginless">Цвет: <span class="js-color"></span></p><br>
                        <h3 class="cart-item-price-value js-price"></h3><br>
                        <?/*<a href="#" class="submit-btn tac js-podbor">Подобрать линзы</a>*/?><a href="/personal/cart/" class="submit-btn tac addcartbtn">Перейти в корзину</a>
                    </div>
                </div>
            </div>
        </div>
        <?if ( !$notShowAuth ):?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:system.auth.form",
                "popup",
                Array(
                    "FORGOT_PASSWORD_URL" => "/personal/?forgot_password=yes",
                    "PROFILE_URL" => "/personal/",
                    "REGISTER_URL" => "/personal/?register=yes",
                    "SHOW_ERRORS" => "Y"
                )
            );?>
            <div id="register-modal" class="mfp-hide city-container">
                <div class="modal-header">
                    <h4>Зарегистрироваться</h4>
                    <button class="mfp-close">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewbox="0 0 12 12">
                            <defs>
                                <path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path>
                            </defs>
                            <g>
                                <g transform="translate(-343 -19)">
                                    <use fill="#202020" xlink:href="#acpka"></use>
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
                <form class="feedbacks-modal-body" id="form-register">
                    <div class="form-items">
                        <div class="form-item form-item-error"></div>
                        <div class="form-item">
                            <input type="text" placeholder="Представьтесь пожалуйста:" class="input" name="name" required>
                        </div>
                        <div class="form-item">
                            <input type="email" placeholder="Введите ваш e-mail:" class="input" name="email" required>
                        </div>
                        <div class="form-item">
                            <input type="password" placeholder="Введите пароль:" class="input" name="password" required>
                        </div>
                        <div class="form-item">
                            <input type="password" placeholder="Повторите пароль:" class="input" name="repassword" required>
                        </div>
                        <div class="form-item"><a href="#" class="back-btn js-link_auth_popup">Вернуться назад</a></div>
                        <div class="form-item">
                            <button type="submit" class="submit-btn">Зарегистрироваться</button>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="reg">
                </form>
            </div>
        <?endif;?>
    <?endif;?>
</body>
</html>