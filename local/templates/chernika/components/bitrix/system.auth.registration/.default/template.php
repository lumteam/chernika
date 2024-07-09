<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="row">
    <div class="col-3"></div>
    <div class="col-6 login-form">
        <div class="h3 login-form-title"><?=GetMessage("AUTH_REGISTER")?></div>

        <?
        ShowMessage($arParams["~AUTH_RESULT"]);
        ?>

        <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
            <p><?echo GetMessage("AUTH_EMAIL_SENT")?></p>
        <?else:?>

            <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
                <p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
            <?endif?>

            <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" enctype="multipart/form-data">
                <? if (strlen($arResult["BACKURL"]) > 0) {?>
                    <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" >
                <? } ?>
                <input type="hidden" name="AUTH_FORM" value="Y" >
                <input type="hidden" name="TYPE" value="REGISTRATION" >

                <?/*<div class="form-item">
                    <input type="text" name="USER_NAME" maxlength="255" value="<?=$arResult["USER_NAME"]?>" placeholder="<?=GetMessage("AUTH_NAME")?>" class="input">
                </div>

                <div class="form-item">
                    <input type="text" name="USER_LAST_NAME" maxlength="255" value="<?=$arResult["USER_LAST_NAME"]?>" placeholder="<?=GetMessage("AUTH_LAST_NAME")?>" class="input">
                </div>*/?>

                <div class="form-item">
                    <input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" placeholder="<?=GetMessage("AUTH_EMAIL")?>" class="input" onkeyup="BX('USER_LOGIN').value = this.value">
                </div>

                <div class="form-item">
                    <input type="password" name="USER_PASSWORD" maxlength="255" value="" placeholder="<?=GetMessage("AUTH_PASSWORD_REQ")?>" class="input">
                </div>

                <div class="form-item">
                    <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="" placeholder="<?=GetMessage("AUTH_CONFIRM")?>" class="input">
                </div>

                <?if($arResult["CAPTCHA_CODE"]):?>
                    <div class="form-item">
                        <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" >
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br/>
                        <input class="input" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" />
                    </div>
                <?endif;?>
<?/*
                <div class="form-item">
                    <button name="Register" type="submit" class="submit-btn"><?=GetMessage("AUTH_REGISTER")?></button>
                </div>
*/?>
                <input type="hidden" id="USER_LOGIN" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN_MIN")?>" class="input">
            </form>

            <div class="form-item">
                <a href="<?=$arResult['AUTH_AUTH_URL']?>" class="submit-btn button_transparent">Вход</a>
            </div>


            <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
        <?endif?>
    </div>
    <div class="col-3"></div>
</div>


<script type="text/javascript">
    document.bform.USER_EMAIL.focus();
</script>