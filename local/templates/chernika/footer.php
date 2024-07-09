    <?if ( !$isAjax ):?>
        <? if (!$isHomePage && !$isCatalog && !$is404) { ?>
            </div>
        <? } ?>

<?
if(
    CSite::InDir('/spasibo/') ||
    CSite::InDir('/spasibo-2/') ||
    CSite::InDir('/sunglasses/') ||
    CSite::InDir('/sports-glasses/') ||
    CSite::InDir('/progressivnye-linzy/') ||
    CSite::InDir('/linzy/progressivnye-linzy-dlya-ochkov/') ||
    CSite::InDir('/progressivnye-linzy-varilux/') ||
    CSite::InDir('/linzy/progressivnye-linzy-seiko/') ||
    CSite::InDir('/linzy/progressivnye-linzy-essilor/') ||
    CSite::InDir('/progressivnye-linzy_new/') ||
    CSite::InDir('/linzy-myopilux/') ||
    CSite::InDir('/linzy-stellest/')
){} else{
?>

<div class="quiz_wrap">
    <div class="container">
        <?//84 мск 85 спб?>
         <?if ( $CITY_ID == 85 ) {?>
	        <div class="row">
	            <div class="col-12 text-center">
	                <div class="h2" style="margin-bottom: 0;">Получите дополнительную скидку в 1 000 ₽ на новые очки!</div>
	                <p style="margin-top: 0;">Пройдите опрос на 1 минуту</p>
	            </div>
	        </div>
       		 <div class="row" style="margin-top: 15px;">
            		<div class="col-12">
				<div data-marquiz-id="640b8b35200b6d003d041eb2"></div> <script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Inline', {id: '640b8b35200b6d003d041eb2', buttonText: 'Получить скидку', bgColor: '#9971db', textColor: '#fff', rounded: true, blicked: true, buttonOnMobile: true})</script>
<?} else {?>
            <div class="row">
            <div class="col-12 text-center">
                <div class="h2" style="margin-bottom: 0;">Получите максимальную скидку!</div>
                <p style="margin-top: 0;">Пройдите опрос на 1 минуту — получите максимальную скидку на оправы и линзы для очков.</p>
            </div>
        </div>
<div data-marquiz-id="61cc7442090194003f84cff7"></div> <script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Inline', {id: '61cc7442090194003f84cff7', buttonText: 'Получить скидку', bgColor: '#9971db', textColor: '#fff', rounded: true, blicked: true, buttonOnMobile: true})</script>
<?}?>                
            </div>
        </div>
    </div>
</div>

<?}?>
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
                        <?=\PDV\Tools::getAddressFooter($CITY_ID)?>
                        <?=str_replace('&nbsp;',' ',\PDV\Tools::getPhoneFooter($CITY_ID));?>
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
		<!--noindex-->
                <div class="footer-oferta">
                    <p style="color: rgba(255, 255, 255, .3);">Информация на сайте носит информационный характер и не является публичной офертой, определяемой положениями Статьи 437 ГК РФ.</p>
                    <? global $CITY_NAME; ?>
                    <? if ($CITY_NAME === 'Уфа'): ?>
                        <p style="color: rgba(255, 255, 255, .3);">ООО "ГрандОптика", ОГРН: 1221800000322. Юр. адрес: 426053, г. Ижевск, ул. Салютовская, д. 15, пом. 44.</p>
                    <? else: ?>
                        <p style="color: rgba(255, 255, 255, .3);">ООО "СОЮЗ-ОПТИКА", ОГРН: 1117847426729, Юр. адрес: 195196, Санкт-Петербург, ул. Таллинская, д. 7, литер О, помещ. 1н, офис 411-2</p>
                        <p style="color: rgba(255, 255, 255, .3);">Медицинская лицензия: Л041-01137-77/00340956. Юр. адрес: 119334, Россия, Москва, ул. Вавилова, д. 3</p>
                    <? endif; ?>
 		</div>
		<!--/noindex-->
                <div class="footer-bottom" style="padding-top: 0;"><a href="/data-processing/">Обработка данных</a><a href="/privacy-policy/">Политика конфиденциальности</a>
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
        <?if (IS_MOBILE) {
            $APPLICATION->IncludeComponent(
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
                    "CITY_ID" => $CITY_ID
                )
            );
        }?>
        <!-- оставить? </div> wrapper-->

        <div id="map_city" class="mfp-hide city-container map-container">
            <button class="mfp-close">
                <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
            </button>
            <div id="popup_salon_map" class="map_city"></div>
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
                    <div class="h4">Зарегистрироваться</div>
                    <button class="mfp-close">
                        <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
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

    <?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/include/callback_form.php", Array(), Array("MODE" => "php", "NAME" => "Форма обратного звонка"));?>

    <div id="chernika-preloader">
        <div id="chernika-preloader_loading">
            <svg id="chernika-preloader_spinner"><use xlink:href="#chernika-logo"/></svg>
        </div>
    </div>

    <div style="display:none;width:0;height:0;overflow:hidden">
      
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <symbol id="chernika-logo" viewBox="0 0 762.5 130.4">
                <path fill="#80BC22" d="M95.4 50.6c-9.7 6.8-21 17.2-30.4 32.5l-.6-1.6C62 75 51.3 49.9 29.5 38.1c-.6-.4-.2-1.3.5-1.1a57.4 57.4 0 0 1 35.7 31.3c.7 1.6 3.1 1.5 3.6-.2a39.6 39.6 0 0 0-49.9-49C8.7 22.4 2.2 29.7 1.4 35.8-.1 48.4 12.8 55.3 24.3 65.4c5.7 5 11.8 10.4 18.3 14.2 2.3 1.3 4.8 2.5 7.5 3 2.4.4 4.8-.2 7.2.2 5.3.9 3.4 4.4 2.2 8.3l-4.2 12c-.4.9-.1 2 .8 2.6l.4.3c1.2.9 3 .4 3.5-1.1a103 103 0 0 1 38.1-50.7c.8-.5 1.2-1.5.9-2.5-.5-1.6-2.2-2.1-3.6-1.1z"/><ellipse cx="116" cy="41.2" fill="#472968" rx="39.9" ry="39.9" transform="rotate(-14.5 116 41.2)"/><ellipse cx="130" cy="34.8" fill="#FFF" rx="19.1" ry="22.9" transform="rotate(-14.5 130 34.8)"/><ellipse cx="129" cy="36.5" fill="#250F3B" rx="16.1" ry="19.3" transform="rotate(-14.5 129 36.5)"/><ellipse cx="124.9" cy="37.7" fill="#472968" rx="10.5" ry="12.6" transform="rotate(-14.5 124.9 37.7)"/><path fill="#341952" d="M190.8 41.5c0 8.3 5.3 12.3 13.3 12.3 3.7 0 7.5-.6 10.2-1.8V21.4h6.5c1.8 0 2.6.6 2.6 2v53.9h-6.5c-1.8 0-2.6-.6-2.6-2V59.1c-3 1.6-7.5 2.5-11.9 2.5-11.8 0-20.8-7.3-20.8-19.7V21.7c1.9-.6 4.1-.9 6.4-.9 1.9 0 2.7.6 2.7 2v18.7zm71.9 30.7c0 2.6-5.1 6-13.1 6-12.5 0-21.4-9.3-21.4-22.1 0-14.1 9.7-22.4 21.4-22.4 10.2 0 17.1 6.7 17.1 15.5 0 2.6-.6 5.1-1.4 6.8-1.3 2.6-3 3.5-6.3 3.5h-22c1 7.7 6.5 11.4 14 11.4 3.8 0 7-.7 10.4-2.4.7.8 1.3 2.4 1.3 3.7zm-25.6-19.9h20.5c.4-.8.6-1.8.6-2.6 0-5.3-3.2-8.6-9.1-8.6-6.5-.1-11 4.1-12 11.2zm33.2-17.4c2-.6 4.1-.8 6-.8 1.8 0 2.6.6 2.6 2v5.5c3-4.9 8.2-7.9 14-7.9 10.3 0 18.4 7.8 18.4 20.7 0 14.5-10.1 23.9-21.2 23.9-4.2 0-8.2-1.4-11.1-4.1v13.7h-6.1c-1.8 0-2.6-.6-2.6-2v-51zm8.6 16.2v16.4c2.6 2.5 6 3.4 9.6 3.4 8.1 0 14-6.7 14-16.2 0-8.4-4.2-13.7-11.6-13.7-4.9-.1-9.6 3-12 10.1zm66.4 26.1c-1.8 0-2.6-.6-2.6-2V58.8h-18.9v18.4h-6.1c-1.8 0-2.6-.6-2.6-2V34.9c2-.6 4.1-.8 6-.8 1.8 0 2.6.6 2.6 2v15.6h18.9v-17h6.1c1.8 0 2.6.6 2.6 2v40.6h-6zm49.7 0h-6c-1.8 0-2.6-.6-2.6-2V48l-20 28.5c-.6.9-1.4 1.3-2.7 1.3-1.4 0-4.1-1-5.9-2.6V34.9c2-.6 4.1-.8 6-.8 1.8 0 2.6.6 2.6 2v27.8l20-28.5c.6-.9 1.4-1.3 2.7-1.3 1.4 0 4.1 1 5.9 2.6v40.5zm9 0c-1.8 0-2.6-.6-2.6-2V34.9c2-.6 4.1-.8 6-.8 1.8 0 2.6.6 2.6 2v17.6c7.2-4.3 16-12.1 20.8-19.6 4.5 1.6 5.8 2.9 5.8 4.8 0 .6-.2 1.2-.5 1.9a52.3 52.3 0 0 1-14.1 14 103 103 0 0 0 10.6 13.3c2.3 2.3 3.4 2.8 4.7 2.8h1.6c.3 1 .5 1.9.5 3 0 1.8-2.2 3.9-6 3.9-2.8 0-5.7-1.5-9.4-6a98.5 98.5 0 0 1-8.7-12.7l-5.3 3v15.1h-6zm76-6.3c.3 1 .5 1.9.5 3 0 1.8-2.2 3.9-6 3.9-3.1 0-6.5-2-7.5-6.9a15.3 15.3 0 0 1-13.5 7.3c-8.5 0-14.4-5.4-14.4-13.3 0-8.8 6.7-14 17.2-14 3.6 0 8 .9 10.4 2.2v-2.7c0-6.1-3.8-9.3-12-9.3-3.8 0-7.4.7-10.8 2.4a7.4 7.4 0 0 1-1.2-3.8c0-2.6 6-6 14.3-6 11.4 0 18.3 5.7 18.3 17v16c0 3.3 1.1 4.2 3 4.2h1.7zm-13.4-6.7v-4.9c-1.9-.7-6.4-1.1-9.1-1.1-6.3 0-9.8 2.2-9.8 6.4s3.4 6.2 7.9 6.2c4.3.1 8.9-2.4 11-6.6zm17.5-12.1c0-3.4 2.2-5.4 5.3-5.4 3 0 5.7 2.2 5.7 5.9 0 3.4-2.2 5.4-5.3 5.4-3 0-5.7-2.2-5.7-5.9zm46.4-31.7c14.4 0 26.5 9.8 26.5 28.9s-12.1 28.9-26.5 28.9S504 68.4 504 49.3s12.1-28.9 26.5-28.9zm-.5 7.8c-8.4 0-16.8 6.1-16.8 20.4 0 13.6 8 21.8 17.7 21.8 8.4 0 16.8-6.1 16.8-20.4 0-13.5-8-21.8-17.7-21.8zm67.5 49h-6.1c-1.8 0-2.6-.6-2.6-2V41.8H570v35.4h-6.1c-1.8 0-2.6-.6-2.6-2V34.6H595c1.8 0 2.6.6 2.6 2v40.6zm19.4 0c-1.8 0-2.6-.6-2.6-2V41.8H602c-1.4 0-2-.7-2-2.6 0-1.4.2-3.2.6-4.6h34.6c1.4 0 2 .7 2 2.6v4.6H623v35.4h-6.1zm60.2 0H671c-1.8 0-2.6-.6-2.6-2V48l-20 28.5c-.6.9-1.4 1.3-2.7 1.3-1.4 0-4.1-1-5.9-2.6V34.9c2-.6 4.1-.8 6-.8 1.8 0 2.6.6 2.6 2v27.8l20-28.5c.6-.9 1.4-1.3 2.7-1.3 1.4 0 4.1 1 5.9 2.6v40.5zm8.9 0c-1.8 0-2.6-.6-2.6-2V34.9c2-.6 4.1-.8 6-.8 1.8 0 2.6.6 2.6 2v17.6c7.2-4.3 16-12.1 20.8-19.6 4.5 1.6 5.8 2.9 5.8 4.8 0 .6-.2 1.2-.5 1.9a52.3 52.3 0 0 1-14.1 14 103 103 0 0 0 10.6 13.3c2.3 2.3 3.4 2.8 4.7 2.8h1.6c.3 1 .5 1.9.5 3 0 1.8-2.2 3.9-6 3.9-2.8 0-5.7-1.5-9.4-6a98.5 98.5 0 0 1-8.7-12.7l-5.3 3v15.1h-6zm76-6.3c.3 1 .5 1.9.5 3 0 1.8-2.2 3.9-6 3.9-3.1 0-6.5-2-7.5-6.9a15.3 15.3 0 0 1-13.5 7.3c-8.5 0-14.4-5.4-14.4-13.3 0-8.8 6.7-14 17.2-14 3.6 0 8 .9 10.4 2.2v-2.7c0-6.1-3.8-9.3-12-9.3-3.8 0-7.4.7-10.8 2.4a7.4 7.4 0 0 1-1.2-3.8c0-2.6 6-6 14.3-6 11.4 0 18.3 5.7 18.3 17v16c0 3.3 1.1 4.2 3 4.2h1.7zm-13.3-6.7v-4.9c-1.9-.7-6.4-1.1-9.1-1.1-6.3 0-9.8 2.2-9.8 6.4s3.4 6.2 7.9 6.2c4.3.1 8.9-2.4 11-6.6zm-516.1 55h-2.8V99.7h-11.4v19.6h-2.8V97.4h17v21.8zm13.9.5c-5.5 0-8.4-3.4-8.4-8.9s2.9-8.9 8.4-8.9 8.4 3.4 8.4 8.9c-.1 5.5-3 8.9-8.4 8.9zm-5.6-8.9c0 4.2 1.7 6.8 5.6 6.8 3.9 0 5.6-2.6 5.6-6.8 0-4.2-1.7-6.8-5.6-6.8-3.9 0-5.6 2.7-5.6 6.8zm32.1 8.4h-2.7v-14.6h-6.6c0 10.1-1.2 15-5.6 15h-.7v-2.1h.3c2.7 0 3.5-4.1 3.5-15H273v16.7zm19.7-2.8s-1.7 3.3-6.8 3.3c-5 0-8.3-2.8-8.3-8.5s3.1-9.2 8.1-9.2c4.5 0 7 3 7 7.8 0 1.2-.3 1.8-.3 1.8h-12.1v.1c0 3.8 2.1 6 5.7 6 3.5 0 5-2.2 5-2.2l1.7.9zm-12.2-6.8h9.8v-.4c0-3.1-1.5-5.1-4.6-5.1-3.3-.1-5 2.3-5.2 5.5zm15.4-5s1.1-2.6 5.8-2.6c4.1 0 6.3 1.9 6.3 4.5 0 1.9-1 3.1-2.1 3.8 1.6.7 2.9 2 2.9 4.2 0 3.1-2.3 5.3-7.1 5.3-5.6 0-6.6-2.8-6.6-2.8l1.3-1.5s1.1 2.3 5.2 2.3c3.3 0 4.5-1.5 4.5-3.4 0-1.7-1.4-2.8-3.8-2.8h-3.2v-1.8h3.3c.4 0 3.1-.3 3.1-2.9 0-1.6-1.3-2.8-4.1-2.8-3.1 0-4 1.7-4 1.7l-1.5-1.2zm17.6-2.2h2.7v7h9v-7h2.7v16.8h-2.7v-7.5h-9v7.5h-2.7v-16.8zm30.1 14.3c-.3.8-1.6 3-5.3 3-3.8 0-5.9-1.8-5.9-4.8 0-4.9 7.2-6 11.3-6.3v-.5c0-2.8-1.2-4.1-4.1-4.1-3.1 0-4.4 1.8-4.4 1.8l-1.5-1.3s1.5-2.6 6.2-2.6c4.4 0 6.5 1.9 6.5 6.1v11.2H344l-.4-2.5zm0-2v-4.2c-3.9.3-8.5 1.1-8.5 4.1 0 2 1.3 3.1 4 3.1 3.4.1 4.4-2.7 4.5-3zm34.6 9.3h-2.1l-.1-4.8h-14.4l-.2 4.8h-1.9l-.1-6.9h2.3c1.6-3.9 2.1-8.2 2.1-14.7h12v14.7h2.8l-.4 6.9zm-14-6.9h9v-12.6h-7.1c0 5.2-.5 9.1-1.9 12.6zm32 2.1h-2.7v-14.6h-6.6c0 10.1-1.2 15-5.6 15h-.7v-2.1h.3c2.7 0 3.5-4.1 3.5-15h11.8v16.7zm18.5 0H412v-6.4h-4.4l-3.5 6.4h-2.9l3.8-6.7c-2.6-.7-3.9-2.4-3.9-4.9 0-3.4 2.1-5.2 6.9-5.2h6.6v16.8zm-8.3-8.4l1.7.2h3.8v-6.6h-3.6c-3.2 0-4.6 1.1-4.6 3.3 0 1.6.8 2.6 2.4 3.1h.3zm22.5-6.2s1.1-2.6 5.8-2.6c4.1 0 6.3 1.9 6.3 4.5 0 1.9-1 3.1-2.1 3.8 1.6.7 2.9 2 2.9 4.2 0 3.1-2.3 5.3-7.1 5.3-5.6 0-6.6-2.8-6.6-2.8l1.3-1.5s1.1 2.3 5.2 2.3c3.3 0 4.5-1.5 4.5-3.4 0-1.7-1.4-2.8-3.8-2.8h-3.2v-1.8h3.3c.4 0 3.1-.3 3.1-2.9 0-1.6-1.3-2.8-4.1-2.8-3.1 0-4 1.7-4 1.7l-1.5-1.2zm17.6-2.2h2.4l.2 2.4c.4-.7 1.8-2.8 5.6-2.8 4.6 0 7.6 3.1 7.6 8.4 0 5.5-2.8 9.3-8 9.3-3.7 0-5.2-2.1-5.2-2.1v10h-2.7v-25.2zm2.6 4.8v8.2c.2.3 1.3 2.2 4.3 2.2 4.3 0 6.1-2.7 6.1-7.2 0-4.4-2.1-6.3-5.7-6.3a5 5 0 0 0-4.7 3.1zm31.4 9.2s-1.7 3.3-6.8 3.3c-5 0-8.3-2.8-8.3-8.5s3.1-9.2 8.1-9.2c4.5 0 7 3 7 7.8 0 1.2-.3 1.8-.3 1.8h-12.1v.1c0 3.8 2.1 6 5.7 6 3.5 0 5-2.2 5-2.2l1.7.9zm-12.2-6.8h9.8v-.4c0-3.1-1.5-5.1-4.6-5.1-3.3-.1-5 2.3-5.2 5.5zm16.6-7.2h2.7v7h9v-7h2.7v16.8h-2.7v-7.5h-9v7.5h-2.7v-16.8zm20.5 0h2.7v12.7l9.6-12 .2-.7h2.4v16.8h-2.7v-12.5l-9.6 12-.2.5h-2.4v-16.8zm33.3 16.8H536v-6.4h-4.4l-3.5 6.4h-2.9l3.8-6.7c-2.6-.7-3.9-2.4-3.9-4.9 0-3.4 2.1-5.2 6.9-5.2h6.6v16.8zm-8.2-8.4l1.7.2h3.8v-6.6h-3.6c-3.2 0-4.6 1.1-4.6 3.3 0 1.6.8 2.6 2.4 3.1h.3z"/>
            </symbol>
            <symbol id="babochka" viewBox="0 0 66 23">
                <g fill="none" fill-rule="evenodd" stroke="#6F6F6F" stroke-width="2"><path d="M1 8c1-2 1-8 7-6l17 2c3 0 4 2 4 5-1 4-4 13-12 13C8 23 0 18 1 8zM65 7c-1-2-1-7-7-6L41 4c-3 0-4 2-4 4 1 4 4 13 12 14 9 0 17-5 16-15z"/><path d="M27 5l6 1 6-1"/></g>
            </symbol>
            <symbol id="pryamougolnie" viewBox="0 0 64 22">
                <g fill="none" fill-rule="evenodd" stroke="#6F6F6F" stroke-width="2"><path d="M2.5 3.5c1-1.1 2.8-1.8 5.5-2h13c3.3.7 5.5 2.2 6.5 4.5C29 9.5 29 13 29 14s-1 2.5-2.5 4-3.5 2.5-7 2.5c-6 0-6 0-12-.5-2-.5-3.3-.9-5-4-1.7-3.1-1.4-10.9 0-12.5zM61.5 4c-1-1.1-2.8-1.8-5.5-2H43c-3.3.7-5.5 2.2-6.5 4.5-1.5 3.5-1.5 7-1.5 8s1 2.5 2.5 4 3.5 2.5 7 2.5c6 0 6 0 12-.5 2-.5 3.3-.9 5-4 1.7-3.1 1.4-10.9 0-12.5zM29 12.5h6"/></g>
            </symbol>
            <symbol id="kruglie" viewBox="0 0 59 27">
                <g fill="none" fill-rule="evenodd" stroke="#6F6F6F" stroke-width="2" transform="translate(1 1)"><circle cx="12.5" cy="12.5" r="12.5"/><circle cx="44.5" cy="12.5" r="12.5"/><path d="M25 10.5h7"/></g>
            </symbol>
            <symbol id="aviator" viewBox="0 0 62 25">
                <g fill="none" fill-rule="nonzero" stroke="#6F6F6F" stroke-width="2"><path d="M1.7 10.9c-.4-4.5 2.3-7.5 7.8-9 3.6-.4 6-.4 9.8 0 3.8.4 5.8.9 7.3 4 1.6 3-2 10-5.8 13.6-2.8 3-5.9 3.8-12 3.8-4.2 0-6.5-4.1-7.1-12.4zM60.3 11.3c.4-4.5-2.3-7.5-7.8-9-3.6-.4-6-.4-9.8 0-3.8.4-5.8.9-7.3 4-1.6 3 2 10 5.8 13.7 2.8 3 5.9 3.7 12 3.7 4.2 0 6.5-4.1 7.1-12.4zM22.4 2.4h19.8"/><path d="M26.9 6.7c1.3-1.4 2.7-2.2 4-2.2 1.5 0 2.8.8 4.2 2.2"/></g>
            </symbol>
            <symbol id="koshglaz" viewBox="0 0 69 24">
                <g fill="none" fill-rule="evenodd" stroke="#6F6F6F" stroke-width="2"><path d="M2 6c-.7-3.7.8-5.2 4.5-4.5C12 2.5 26.5 8 28 9s7 7-1.5 12.5C15 24 9 19 6.5 16.5A24 24 0 0 1 2 6zM67.1 5.7c.7-3.7-.8-5.2-4.5-4.5-5.5 1-20 6.5-21.5 7.5s-7 7 1.5 12.5c11.5 2.5 17.5-2.5 20-5a24 24 0 0 0 4.5-10.5z"/><path d="M30 11.5c1.6.7 3.1 1 4.5 1s2.7-.3 4-1"/></g>
            </symbol>
            <symbol id="trapecya" viewBox="0 0 70 21">
                <g fill="none" fill-rule="evenodd"><path stroke="#6F6F6F" stroke-width="2" d="M4.5 7c0-3 .5-5 5-5.5C12.5 1.2 17 1 23 1c4 .7 6.3 2.2 7 4.5 1 3.5-1 12-6.5 13.5s-11.5.5-13.5-.5S4.6 10 4.5 7z"/><path fill="#6F6F6F" d="M4.5 8.5C1.5 7.8 0 7 0 6V4c.7-1.7 1.3-2.7 2-3 .7-.3 3.3-.5 8-.5l3 .5-5.5 1.5-2 .5L5 5l-.5 3.5z"/><path stroke="#6F6F6F" stroke-width="2" d="M65.5 7c0-3-.5-5-5-5.5C57.5 1.2 53 1 47 1c-4 .7-6.3 2.2-7 4.5-1 3.5 1 12 6.5 13.5s11.5.5 13.5-.5S65.4 10 65.5 7z"/><path fill="#6F6F6F" d="M65.5 8.5C68.5 7.8 70 7 70 6V4c-.7-1.7-1.3-2.7-2-3-.7-.3-3.3-.5-8-.5L57 1l5.5 1.5 2 .5.5 2 .5 3.5z"/><path stroke="#6F6F6F" stroke-width="2" d="M30 5.5a13.4 13.4 0 0 1 10 0"/></g>
            </symbol>
            <symbol id="close" viewBox="0 0 12 12">
                <defs><path id="acpka" d="M355 29.59l-1.4 1.4-4.6-4.58-4.59 4.59-1.4-1.41 4.58-4.59-4.59-4.59 1.41-1.4 4.6 4.58 4.58-4.59 1.41 1.41-4.59 4.59z"></path></defs><g><g transform="translate(-343 -19)"><use xlink:href="#acpka"></use></g></g>
            </symbol>
            <symbol id="metro-msk" viewBox="337.5 232.3 125 85.9">
                <polygon fill="#FF0013" points="453.9,306.2 424.7,232.3 400,275.5 375.4,232.3 346.1,306.2 337.5,306.2 337.5,317.4 381.7,317.4 381.7,306.2 375.1,306.2 381.5,287.8 400,318.2 418.5,287.8 424.9,306.2 418.3,306.2 418.3,317.4 462.5,317.4 462.5,306.2 "/>
            </symbol>
            <symbol id="metro-spb" viewBox="0 0 20000000 16431925">
                <path fill="#2250a3" d="M16587653 2210131C14887634 677267 13271193 203530 13271193 203530l-3260695 11105962h-27915L6694029 203530S5077588 663361 3377560 2210131C1566039 3854375 5372 6376582 270123 10375821c209033 3163155 2550066 5852573 2550066 5852573l4528798-13953s-3887793-2062319-4821418-5309108c-1114789-3832028 627052-6493587 1964789-7761634 543465-473793 1337728-585286 1630338 431972 1003305 3246789 3873840 12541230 3873840 12541230l13962 47s2856629-9294441 3873831-12541230c306573-1017258 1100845-905756 1630347-431972 1337737 1268056 3079577 3929559 1964779 7761634-933615 3246789-4821408 5309108-4821408 5309108l4528798 13962s2354986-2703324 2550066-5852582c236892-3999286-1323831-6521493-3149258-8165737z"/>
            </symbol>
        </svg>
    </div>


    <?// $APPLICATION->ShowCSS(false, false); ?>
    <?php $asset = \Bitrix\Main\Page\Asset::getInstance(); ?>
    <?php if ($USER->IsAdmin()) {
        $APPLICATION->ShowCSS(false, false);
    } else {
        echo $asset->getCss(2);
    }?>

    <?php if (! CSite::InDir('/personal/')) {
        echo $asset->getJs(2);
    }?>

    <? if (CSite::InDir('/contacts/') || CSite::InDir('/proverka-zrenija/')) { ?>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <? } ?>
    <?php /* ?><script >
        function jivo_onLoadCallback() {
            var clientID = yaCounter24545261.getClientID();
            var referer = sbjs.get.current_add.rf;
            console.log(referer);
            if (referer == '(none)') {
                referer = 'pryamoy';
                $('input[name="referer"]').val('pryamoy');
            } else {
                $('input[name="referer"]').val(referer);
            }
            jivo_api.setContactInfo(
                {
                    description: referer
                }
            );
            setTimeout(function () {
                jivo_api.setUserToken(clientID);
            }, 1000);
        }
    </script><?php */ ?>

    <? include_once($analyticCountersPath . '/analitics_bottom.php'); ?>
    <script src="/local/templates/chernika/js/sourcebuster.min.js" ></script>
   <script >sbjs.init();</script>
   <script>
       $(document).ready(function () {
        var utm_source = sbjs.get.current.src;
        var utm_medium = sbjs.get.current.mdm;
        var utm_content = sbjs.get.current.cnt;
        var utm_campaign = sbjs.get.current.cmp;
        var utm_term = sbjs.get.current.trm;

        $('input[name="utm_source"]').val(utm_source);
        $('input[name="utm_medium"]').val(utm_medium);
        $('input[name="utm_content"]').val(utm_content);
        $('input[name="utm_campaign"]').val(utm_campaign);
        $('input[name="utm_term"]').val(utm_term);

       })
   </script>
    <script>
    $(document).ready(function() {
        $(window).on("scroll", function() {
            if($(window).scrollTop()>300){
                $('.filter-elements').addClass('fixed');
            }
            else {
                $('.filter-elements').removeClass('fixed');
            }
        });
    });
    </script>

    <?php /* ?><script>
        // $(document).ready(function () {
        //     function hidinp() {
        //         var clientID = yaCounter24545261.getClientID();
        //         if (clientID.length > 0) {
        //             $('input[name="clientID"]').val(clientID);
        //         }
        //         var freferer = sbjs.get.first_add.rf;
        //         if (freferer == '(none)') {
        //             freferer = 'pryamoy';
        //             $('input[name="freferer"]').val('pryamoy');
        //         } else {
        //             $('input[name="freferer"]').val(freferer);
        //         }
        //         ;
        //
        //         var referer = sbjs.get.current_add.rf;
        //         if (referer == '(none)') {
        //             referer = 'pryamoy';
        //             $('input[name="referer"]').val('pryamoy');
        //         } else {
        //             $('input[name="referer"]').val(referer);
        //         }
        //         ;
        //     }
        //
        //     setInterval(hidinp, 3000);
        // });
    </script><?php */ ?>


    <?php /* ?>
    <script>
    // \u00A0
    if ( sbjs.get.current.mdm === "cpc" ) {
    $('a[href="tel:+74950082828"]').each(function () {
        this.text = "8 (499) 112-42-59";
        this.href = 'tel:+74991124259';
    });
    }

    if ( sbjs.get.current.mdm === "cpc" ) {
    $('a[href="tel:+74950082828"]').each(function () {
        this.text = "8 (499) 112-42-59";
        this.href = 'tel:+74991124259';
    });
    }

    if ( sbjs.get.current.mdm === "cpc" ) {
    $('a[href="tel:+78124081532"]').each(function () {
        this.text = "8 (812) 507-60-83";
        this.href = 'tel:+78125076083';
    });
    }

    if ( sbjs.get.current.mdm === "cpc" ) {
    $('a[href="tel:+78124081532"]').each(function () {
        this.text = "8 (812) 507-60-83";
        this.href = 'tel:+78125076083';
    });
    }

    if ( sbjs.get.current.mdm === "cpc" ) {
    $('a[href="tel:+78003023289"]').each(function () {
        this.text = "8 (800) 551-63-66";
        this.href = 'tel:+78005516366';
    });
    }
        </script>
    <?php */?>

    <?php /* ?><script>
        // if (sbjs.get.current.mdm === "cpc") {
        //     $('a[href="tel:88003023289"]').each(function () {
        //         this.text = "8 (800) 551-63-66";
        //         this.href = 'tel:88005516366';
        //     });
        // }
    </script><?php */ ?>
    <?php /* ?><!-- BEGIN OF UTMSTAT.COM CODE FOR CHERNIKA-OPTIKA.RU -->
        <script >
            var utmStatConf = {
                projectId: "a935811ede37f98f81bd073d8c265f78",
                replaceTextElements: [],
                hasJivosite: true,
                hasCarrotQuest: false,
                hasMetrika: true,
                hasAnalytics: true,
                useCookieSync: true
            };
            (function (u, t, m) {
                var s = u.createElement(t), n = u.getElementsByTagName(t)[0];
                s.type = "text/javascript";
                s.async = true;
                s.src = m + "?v=" + Date.now();
                n.parentNode.insertBefore(s, n);
            })(document, "script", "//static.utmstat.com/client.min.js");
        </script>
        <!-- END OF UTMSTAT.COM CODE FOR CHERNIKA-OPTIKA.RU --><?php */ ?>
    <script async src="/local/templates/chernika/js/readmore.min.js"></script>
    <?php /*?><script> see /local/templates/chernika/js/readmore.js
            $('article').readmore({
                maxHeight: 0,
                moreLink: '<a href="#" class="link-video-block"><span>Смотреть видео о компании</span></a>',
                lessLink: '<a href="#" class="link-video-block">Свернуть</a>'
            });
        </script><?php*/ ?>

    <div style="text-align: right; display: none;">
        <?= SITE_ID; ?>
    </div>
 

    <?php
    // МСК колтрекинг задарма
    $zadarmaId = '4998bf9ccfb96d1f86e165795fa80d796229';
    if (85 === (int) $CITY_ID) {
        // СПБ колтрекинг задарма
        $zadarmaId = '8e2572b9dc77c7a4827ed1d8d697eca16238';
    }
    ?>

<script>
    var sub_domain = window.location.host.split('.')[1] ? window.location.host.split('.')[0] : false;
    if (sub_domain == 'market' || sub_domain == 'market-spb') {
        $('a[href="tel:88003023289"]').remove();
    }

    if (sub_domain == 'market-spb') {
        $('a[href="tel:88124081532"]:not(.imgPhone)').each(function () {
            this.text = "8 (812) 241-16-72";
            this.href = 'tel:+78122411672';
        });
        $('a[href="tel:+78124081532"]').each(function () {
            this.text = "8 (812) 241-16-72";
            this.href = 'tel:+78122411672';
        });

        $('.new_fl_infoBlock').each(function() {
            var text = $(this).html();
            text = text.replace('+7 (812) 408-15-32', '+7 (812) 241-16-72');
            $(this).html(text);
        });
        $('a[href="tel:88124081532"].imgPhone').each(function () {
            this.href = 'tel:+78122411672';
        });
    }

     if (sub_domain == 'market') {
        $('a[href="tel:84950082828"]:not(.imgPhone)').each(function () {
            this.text = "8 (499) 348-94-42";
            this.href = 'tel:+74993489442';
        });
        $('a[href="tel:+74950082828"]').each(function () {
            this.text = "8 (499) 348-94-42";
            this.href = 'tel:+74993489442';
        });

        $('.new_fl_infoBlock').each(function() {
            var text = $(this).html();
            text = text.replace('+7 (495) 008-28-28', '+7 (499) 348-94-42');
            $(this).html(text);
        });

        $('a[href="tel:84950082828"].imgPhone').each(function () {
            this.href = 'tel:+78122411672';
        });
    }
</script>



    <script>(function(w, c){(w[c]=w[c]||[]).push(function(){new zTracker({"id":"<?php echo $zadarmaId; ?>>","metrics":{"metrika":"24545261","ga":"UA-133866473-1"}});});})(window, "zTrackerCallbacks");</script>
    <script async id="zd_ct_phone_script" src="/local/templates/chernika/js/seo/ct_phone.min.js"></script>
    <script>
        $('a[href="tel:+74950082828"], ' +
            'a[href="tel:+74950082828"], ' +
            'a[href="tel:84950082828"], ' +
            'a[href="tel:+78124081532"], ' +
            'a[href="tel:88124081532"], ' +
            'a[href="tel:+78124081532"]'
        ).each(function () {
            $(this).addClass('zphone');
        });
        $('nobr').each(function () {
            var text = $(this).html();
            text = text.replace('+7 (495) 008-28-28', '<span class="zphone">+7 (495) 008-28-28</span>');
            text = text.replace('+7 (812) 408-15-32', '<span class="zphone">+7 (812) 408-15-32</span>');
            $(this).html(text);
        })
    </script>



<?//$CITY_ID?>
<?//84 мск 85 спб?>
<?
$date = \COption::GetOptionString( "askaron.settings", "UF_LABEL_AFTER_PERCENT");
if ( $CITY_ID == 85 ) {
    $discont_text = 'Скидки: 50% на прогрессивные линзы и до 50% на оправы';
} else {
    $discont_text = 'Скидки: 30% на прогрессивные линзы и до 50% на оправы';
}
?>

<?
$promocode = \COption::GetOptionString( "askaron.settings", "UF_PROMOCODE");
?>
<script>
$(function() {
    var progressUrl = window.location.href.split('/')[3];
    if (progressUrl == 'progressivnye-linzy-varilux' || progressUrl == 'progressivnye-linzy') {
        $('.note-warring > .container > p').html('<strong>Акция <?=$date?>!</strong> <?=$discont_text?>').css('font-size','24px');
        $('.note-warring > .container p.tile').html('Мы гарантируем лучшую цену на прогрессивные линзы среди салонов города. Если вы нашли дешевле — позвоните нам: <nobr><a href="tel:74950082828" class="zphone">8 (495) 008-28-28</a></nobr>, мы сделаем индивидуальное предложение для вас');
    }
    $('.addPromo').click(function(e){
        e.preventDefault();
        let promocode = $(this).attr('data-promocode');
        if(!promocode) {
            promocode = '<?=$promocode?>';
        }
        $(this).siblings('.form-item').children('input[name="promocode"]').attr('value', promocode);
    })
    $('.scroll').click(function() {
          $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top-100
        }, 500);
          return false;
      });
});
</script>

<script>
const choseFileBtn = document.getElementById('choseFile-btn');
const fileChosen = document.getElementById('file-chosen');
if (choseFileBtn) {
    choseFileBtn.addEventListener('change', function(){
      fileChosen.innerHTML = this.files[0].name+'<span onclick="delFile()">Удалить</span>';
    });
}
function delFile() {
    fileChosen.innerHTML = "";
    choseFileBtn.value = "";
}
</script>

<script>
    $('.data-js').click(function(e){
        e.preventDefault();
        $('#data-js-input').attr('value', $(this).attr('data-product') );

        $.magnificPopup.open({
            items: {
                src: '#popup-consult',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark",
            fixedContentPos: false,
            callbacks: {
                            open: function() {
                               jQuery('body').addClass('magnificpopupnoscroll');
                            },
                            close: function() {
                               jQuery('body').removeClass('magnificpopupnoscroll');
                            }
                        }
        });
    })
</script>

<script>
    $(document).ready(function() {

    $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
            verticalFit: true
        }

    });

    $('.image-popup-fit-width').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        image: {
            verticalFit: false
        }
    });

    $('.image-popup-no-margins').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });

});
</script>


<script>
$(document).ready(function() {
	$(".description .toggle-qa").not(".link").click(function(e){e.preventDefault();var t=$(this).closest(".description"),e=t.find(".description-inner");t.toggleClass("active"),e.slideToggle("fast")});

    $('.open-popup-link').magnificPopup({
      type:'inline',
      midClick: true
    });
    $('.rezerv__close').click(function() {
        parent.$.magnificPopup.close();
    });

    var rezerv = $("#rezerv_form-wrap").steps({
        headerTag: "div",
        titleTemplate: "#title#",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        enableAllSteps: false,
        enablePagination: false,
        onStepChanged: function (event, currentIndex, newIndex) { return true; },
    });


     $('.rezerv_btn-selectSalon').click(function(){
        $(rezerv).steps("next");
        let salonID = $(this).attr('data-salon');
        $('.rezerv_form-salonID').removeClass('active');
        $('.rezerv_form-salonID-'+salonID).addClass('active');
        $('.phonemask').mask("+7(999) 999 99-99",{placeholder:"_"});
        $('input[name="rezrvSalonID"]').attr('value',salonID);
    })

    $('.rezerv_form-salonBack').click(function(){
        $(rezerv).steps("previous");
    })

    $('.sendRezervBtn').click(function(){
        form = $(this).parents('form');
        phoneInp = form.find('.phonemask.required');

        if ( phoneInp.val().length == 0 ) {
            phoneInp.css('border-color','red');
        } else {
            phoneInp.css('border-color','#b5b5b5');
            form.submit();
        }
    })
});
</script>

<script>
    var an = $(".analog-slider");
        an.on("init", function(an, i) {
            an.preventDefault();
            $(this).addClass("analog-slider_initialized");
        }),
            an.slick({
                dots: !1,
                arrows: !1,
                slidesToShow: 2,
                mobileFirst: !0,
                responsive: [{
                    breakpoint: 1023,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            }), $(".analog-nav-prev").click(function(an) {
            an.preventDefault(), $(".analog-slider").slick("slickPrev");
        }), $(".analog-nav-next").click(function(an) {
            an.preventDefault(), $(".analog-slider").slick("slickNext");
        }), 0 < $(".slick-dots").length && $(".slick-dots").wrap('<div class="container slick-dots-container"></div>');
</script>

<script>
    var pop = $(".popular-slider");
        pop.on("init", function(pop, i) {
            pop.preventDefault();
            $(this).addClass("popular-slider_initialized");
        }),
            pop.slick({
                dots: !1,
                arrows: !1,
                slidesToShow: 2,
                mobileFirst: !0,
                responsive: [{
                    breakpoint: 1023,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            }), $(".popular-nav-prev").click(function(pop) {
            pop.preventDefault(), $(".popular-slider").slick("slickPrev");
        }), $(".popular-nav-next").click(function(pop) {
            pop.preventDefault(), $(".popular-slider").slick("slickNext");
        }), 0 < $(".slick-dots").length && $(".slick-dots").wrap('<div class="container slick-dots-container"></div>');
</script>



<?php /* >
<script src="https://unpkg.com/webp-hero@0.0.0-dev.27/dist-cjs/polyfills.js"></script>
<script src="https://unpkg.com/webp-hero@0.0.0-dev.27/dist-cjs/webp-hero.bundle.js"></script>

<script>
    var webpMachine = new webpHero.WebpMachine()
    webpMachine.polyfillDocument()
</script>
<?php */ ?>


<?//84 мск 85 спб?>
<?if ( $CITY_ID == 85 ) {?>
   <script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Pop', {id: '640b3d4dd9eb7c003d97d9bb', title: 'Скидка на оправы и линзы', text: 'Получите скидку до 1000 ₽', delay: 20, textColor: '#fff', bgColor: '#9971db', svgColor: '#fff', closeColor: '#ffffff', bonusCount: 2, bonusText: 'Вам доступны бонусы', type: 'side', position: 'position_bottom-left', rounded: true, blicked: true})</script>
<?} else {?>
    <script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Pop', {id: '61c5e0a186b413003fc46f6d', title: 'Скидка на оправы и линзы', text: 'Получите скидку до 70%!', delay: 20, textColor: '#fff', bgColor: '#9971db', svgColor: '#fff', closeColor: '#ffffff', bonusCount: 2, bonusText: 'Вам доступны бонусы', type: 'side', position: 'position_bottom-left', rounded: true, blicked: true})</script>
<?}?>

<?// popup?>
<div id="es-city-modal" class="mfp-hide city-container">
    <div class="modal-header">
        <div class="h4">Выберите город</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <div>
        <div class="es-city-modal1">
            <a href="javascript:void(0);" onclick="ESCityGo(1);" class="es-city-item">Москва</a>
            <a href="javascript:void(0);" onclick="ESCityGo(2);" class="es-city-item">Санкт-Петербург</a>
            <a href="javascript:void(0);" onclick="ESCityGo(3);" class="es-city-item">Уфа</a>
            <a href="javascript:void(0);" onclick="ESCityShowOther();" class="es-city-item">Другой</a>
        </div>
        <div class="es-city-modal2">
            <a href="javascript:void(0);" onclick="ESCityGo(2);" class="es-city-item">Санкт-Петербург</a>
            <a href="javascript:void(0);" onclick="ESCityGo(1);" class="es-city-item">Москва</a>
            <a href="javascript:void(0);" onclick="ESCityGo(3);" class="es-city-item">Уфа</a>
            <a href="javascript:void(0);" onclick="ESCityShowOther();" class="es-city-item">Другой</a>
        </div>
        <div class="es-city-modal3">
            <a href="javascript:void(0);" onclick="ESCityGo(3);" class="es-city-item">Уфа</a>
            <a href="javascript:void(0);" onclick="ESCityGo(1);" class="es-city-item">Москва</a>
            <a href="javascript:void(0);" onclick="ESCityGo(2);" class="es-city-item">Санкт-Петербург</a>
            <a href="javascript:void(0);" onclick="ESCityShowOther();" class="es-city-item">Другой</a>
        </div>
    </div>
</div>

<div id="es-city-other-modal" class="mfp-hide city-container">
    <div class="modal-header">
        <div class="h4">Доставляем заказы по всей России</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <div class="es-city-body">
        <div class="es-city-content">Вы переходите на московский сайт "Черника-Оптика" - на нем доступен полный каталог оправ для зрения и солнцезащитных очков.</div>
        <div class="es-city-content">Чтобы узнать стоимость и сроки доставки в Ваш город - позвоните по бесплатному номеру <a href="tel:+78003023289">8 (800) 302-32-89</a>.</div>
        <a href="javascript:void(0);" onclick="ESCityGo(1);" class="es-city-item city-center">Перейти на сайт</a>
    </div>
</div>

<script>
var esCity1 = "chernika-optika.ru";
var esCity2 = "spb.chernika-optika.ru";
var esCity3 = "ufa.chernika-optika.ru";

$(document).ready(function()
{
    const urlParams = new URLSearchParams(window.location.search);
    if($.cookie("ES_POPUP") !== "Y" && !urlParams.has('utm_medium'))
    {
        switch (document.location.hostname)
        {
            case esCity2:
                $(".es-city-modal1").hide();
                $(".es-city-modal2").show();
                $(".es-city-modal3").hide();
                break;
            case esCity3:
                $(".es-city-modal1").hide();
                $(".es-city-modal2").hide();
                $(".es-city-modal3").show();
                break;
            default:
                $(".es-city-modal1").show();
                $(".es-city-modal2").hide();
                $(".es-city-modal3").hide();
        }
        setTimeout(function()
        {
            $.magnificPopup.open({
                items: {
                    src: '#es-city-modal',
                    type: "inline",
                    removalDelay: 300
                },
                mainClass: "mfp-fade_dark"
            });
        }, 250);
    }
    if($.cookie("ES_POPUP") === "Y")
    {
        if($.cookie("ES_POPUP_SITE") === esCity1 && (document.location.hostname === esCity2 || document.location.hostname === esCity3)) document.location.href = "https://" + esCity1 + document.location.pathname + document.location.search;
        if($.cookie("ES_POPUP_SITE") === esCity2 && (document.location.hostname === esCity1 || document.location.hostname === esCity3)) document.location.href = "https://" + esCity2 + document.location.pathname + document.location.search;
        if($.cookie("ES_POPUP_SITE") === esCity3 && (document.location.hostname === esCity1 || document.location.hostname === esCity2)) document.location.href = "https://" + esCity3 + document.location.pathname + document.location.search;
    }
});
function ESCityShow()
{
    setTimeout(function()
    {
        $.magnificPopup.close();
        switch (document.location.hostname)
        {
            case esCity2:
                $(".es-city-modal1").hide();
                $(".es-city-modal2").show();
                $(".es-city-modal3").hide();
                break;
            case esCity3:
                $(".es-city-modal1").hide();
                $(".es-city-modal2").hide();
                $(".es-city-modal3").show();
                break;
            default:
                $(".es-city-modal1").show();
                $(".es-city-modal2").hide();
                $(".es-city-modal3").show();
        }
        $.magnificPopup.open({
            items: {
                src: '#es-city-modal',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });
    }, 250);
};
function ESCityShowOther()
{
    setTimeout(function()
    {
        $.magnificPopup.close();
        $.magnificPopup.open({
            items: {
                src: '#es-city-other-modal',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade_dark"
        });
    }, 250);
};
function ESCityGo(id)
{
    if(id == 1)
    {
        ESCitySetCookie("ES_POPUP=Y");
        ESCitySetCookie("ES_POPUP_SITE=" + esCity1);
        if(document.location.hostname != esCity1) document.location.href = "https://" + esCity1 + document.location.pathname + document.location.search;
    }
    if(id == 2)
    {
        ESCitySetCookie("ES_POPUP=Y");
        ESCitySetCookie("ES_POPUP_SITE=" + esCity2);
        if(document.location.hostname != esCity2) document.location.href = "https://" + esCity2 + document.location.pathname + document.location.search;
    }
    if(id == 3)
    {
        ESCitySetCookie("ES_POPUP=Y");
        ESCitySetCookie("ES_POPUP_SITE=" + esCity3);
        if(document.location.hostname != esCity3) document.location.href = "https://" + esCity3 + document.location.pathname + document.location.search;
    }
    $.magnificPopup.close();
};
function ESCitySetCookie(id)
{
    var d = new Date();
    d.setTime(d.getTime() + (10 * 365 * 24 * 60 * 60 * 1000));
    document.cookie = id + "; expires=" + d.toUTCString() + "; path=/; domain=." + esCity1;
};
</script>
<?// popup?>

</body>
</html>