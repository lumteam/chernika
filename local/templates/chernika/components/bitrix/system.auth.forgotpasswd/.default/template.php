<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use \Bitrix\Main\Context;
$request = Context::getCurrent()->getRequest();
?>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 login-form">
        <h3 class="login-form-title"><?=GetMessage("AUTH_GET_CHECK_STRING")?></h3>
        <?
        ShowMessage($arParams["~AUTH_RESULT"]);
        ?>
        <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
            <?
            if (strlen($arResult["BACKURL"]) > 0)
            {
            ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
            }
            ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="SEND_PWD">
            <p><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>

            <div class="form-item">
                <input type="text" name="USER_EMAIL" value="<?=(strlen($request->get('email')) > 0 ? $request->get('email') : $arResult["LAST_LOGIN"])?>" placeholder="<?=GetMessage("AUTH_EMAIL")?>" class="input">
            </div>

            <?if($arResult["CAPTCHA_CODE"]):?>
                <div class="form-item">
                    <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br/>
                    <input class="input" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" />
                </div>
            <?endif;?>

            <div class="form-item">
                <input type="submit" name="send_account_info" class="submit-btn" value="<?=GetMessage("AUTH_SEND")?>" />
            </div>

            <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
        </form>
    </div>
    <div class="col-3"></div>
</div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
