<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 login-form">
        <h3 class="login-form-title"><?=GetMessage("AUTH_PLEASE_AUTH")?></h3>

        <?
        ShowMessage($arParams["~AUTH_RESULT"]);
        ShowMessage($arResult['ERROR_MESSAGE']);
        ?>

        <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />
            <?if (strlen($arResult["BACKURL"]) > 0):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>

            <div class="form-item">
                <input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN")?>" class="input">
            </div>
            <div class="form-item">
                <input type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" placeholder="<?=GetMessage("AUTH_PASSWORD")?>" class="input">
                <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="remember-btn">Забыли?</a>
            </div>

            <?if($arResult["CAPTCHA_CODE"]):?>
                <div class="form-item">
                    <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br/>
                    <input class="input" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" />
                </div>
            <?endif;?>

            <div class="form-item">
                <button type="submit" class="submit-btn">Вход</button>
            </div>
        </form>
<?/*
        <div class="form-item">
            <a href="<?=$arResult['AUTH_REGISTER_URL']?>" class="submit-btn button_transparent">Регистрация</a>
        </div>

        <?if($arResult["AUTH_SERVICES"]):?>
        <div class="login-form-socials">
            <h4 class="login-form-socials-title">Вход через соцсети</h4>
            <?
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                array(
                    "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                    "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
                    "AUTH_URL" => $arResult["AUTH_URL"],
                    "POST" => $arResult["POST"],
                    "SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
                    "FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
                    "AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
                ),
                $component,
                array("HIDE_ICONS"=>"Y")
            );
            ?>
        </div>
        <?endif?>
*/?>
    </div>
    <div class="col-3"></div>
</div>

<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>