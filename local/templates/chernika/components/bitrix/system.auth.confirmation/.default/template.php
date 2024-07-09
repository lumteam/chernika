<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<p><?echo $arResult["MESSAGE_TEXT"]?></p>
<?//here you can place your own messages
	switch($arResult["MESSAGE_CODE"])
	{
	case "E01":
		?><? //When user not found
		break;
	case "E02":
		?><? //User was successfully authorized after confirmation
		break;
	case "E03":
		?><? //User already confirm his registration
		break;
	case "E04":
		?><? //Missed confirmation code
		break;
	case "E05":
		?><? //Confirmation code provided does not match stored one
		break;
	case "E06":
		?><? //Confirmation was successfull
		break;
	case "E07":
		?><? //Some error occured during confirmation
		break;
	}
?>
<?if($arResult["SHOW_FORM"]):?>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 login-form">
            <div class="h3 login-form-title"><?=GetMessage("AUTH_PLEASE_AUTH")?></div>

            <form method="post" action="<?echo $arResult["FORM_ACTION"]?>">
                <div class="form-item">
                    <input type="text" name="<?echo $arParams["LOGIN"]?>" maxlength="255" value="<?=$arResult["LOGIN"]?>" placeholder="<?=GetMessage("CT_BSAC_LOGIN")?>" class="input">
                </div>

                <div class="form-item">
                    <input type="text" name="<?echo $arParams["CONFIRM_CODE"]?>" maxlength="255" value="<?=$arResult["CONFIRM_CODE"]?>" placeholder="<?=GetMessage("CT_BSAC_CONFIRM_CODE")?>" class="input">
                </div>

                <div class="form-item">
                    <input type="submit" value="<?echo GetMessage("CT_BSAC_CONFIRM")?>" class="submit-btn"/>
                </div>

                <input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />
            </form>
        </div>
        <div class="col-3"></div>
    </div>
<?elseif(!$USER->IsAuthorized()):?>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", array());?>
<?endif?>