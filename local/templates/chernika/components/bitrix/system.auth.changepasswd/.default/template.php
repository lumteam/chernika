<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">
    <div class="col-3"></div>
    <div class="col-6 login-form">
        <div class="h3 login-form-title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></div>
        <?
        ShowMessage($arParams["~AUTH_RESULT"]);
        ?>

        <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
            <?if (strlen($arResult["BACKURL"]) > 0): ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <? endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="CHANGE_PWD">

            <div class="form-item">
                <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN")?>" class="input">
            </div>

            <div class="form-item">
                <input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" placeholder="<?=GetMessage("AUTH_CHECKWORD")?>" class="input">
            </div>

            <div class="form-item">
                <input type="text" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>" class="input">
            </div>

            <div class="form-item">
                <input type="text" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>" class="input">
            </div>

            <?if($arResult["CAPTCHA_CODE"]):?>
                <div class="form-item">
                    <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br/>
                    <input class="input" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" />
                </div>
            <?endif;?>

            <div class="form-item">
                <input type="submit" name="change_pwd" class="submit-btn" value="<?=GetMessage("AUTH_CHANGE")?>" />
            </div>

            <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
            <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
            <p>
                <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
            </p>

        </form>
    </div>
    <div class="col-3"></div>
</div>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>