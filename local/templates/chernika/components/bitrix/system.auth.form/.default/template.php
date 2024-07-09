<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();
?>

<?if($arResult["FORM_TYPE"] == "login"):?>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="login-form">
                <div class="h3 login-form-title"><?=(!empty($arParams['TITLE']))?$arParams['TITLE']:GetMessage("AUTH_PLEASE_AUTH")?></div>
                <form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                    <?
                    ShowMessage($arParams["~AUTH_RESULT"]);
                    ShowMessage($arResult['ERROR_MESSAGE']);
                    ?>

                    <?if($arResult["BACKURL"] <> ''):?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" >
                    <?endif?>
                    <?foreach ($arResult["POST"] as $key => $value):?>
                        <input type="hidden" name="<?=$key?>" value="<?=$value?>" >
                    <?endforeach?>
                        <input type="hidden" name="AUTH_FORM" value="Y" >
                        <input type="hidden" name="TYPE" value="AUTH" >

                    <div class="form-item">
                        <input type="email" name="USER_LOGIN" placeholder="Введите ваш e-mail:" class="input">
                        <script>
                            BX.ready(function() {
                                var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                                if (loginCookie)
                                {
                                    var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
                                    var loginInput = form.elements["USER_LOGIN"];
                                    loginInput.value = loginCookie;
                                }
                            });
                        </script>
                    </div>

                    <div class="form-item">
                        <input type="password" name="USER_PASSWORD" placeholder="Введите ваш пароль:" class="input"><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="remember-btn">Забыли?</a>
                    </div>

                    <?if($arResult["CAPTCHA_CODE"]):?>
                        <div class="form-item">
                            <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" >
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br/>
                            <input class="input" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" />
                        </div>
                    <?endif;?>

                    <div class="form-item">
                        <button name="Login" type="submit" class="submit-btn">Вход</button>
                    </div>
                </form>
<?/*
                <?if($arResult["AUTH_SERVICES"]):?>
                    <div class="login-form-socials">
                        <h4 class="login-form-socials-title">Вход через соцсети</h4>
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:socserv.auth.form",
                            "",
                            array(
                                "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                                "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
                                "AUTH_URL" => $arResult["AUTH_URL"],
                                "POST" => $arResult["POST"],
                                "SHOW_TITLES" => 'N',
                                "FOR_SPLIT" => 'Y',
                                "AUTH_LINE" => 'N'
                            ),
                            $component,
                            array("HIDE_ICONS"=>"Y")
                        );
                        ?>
                    </div>
                <?endif?>
*/?>
            </div>
        </div>
    </div>
<?endif?>



<?
if ( !empty($arResult['ERROR_MESSAGE']) ) {
    echo '<script> setTimeout(function (){
        $.magnificPopup.open({
            items: {
                src: \'#login-modal\',
                type: "inline",
                removalDelay: 300
            },
            mainClass: "mfp-fade"
        });
    }, 1000);</script>';
}
?>
