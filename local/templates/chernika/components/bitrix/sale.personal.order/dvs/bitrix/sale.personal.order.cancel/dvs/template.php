<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">
    <?if (strlen($arResult["ERROR_MESSAGE"]) <= 0){?>
        <div class="col-sm-7">
            <form method="post" action="<?=POST_FORM_ACTION_URI?>">

                <input type="hidden" name="CANCEL" value="Y">
                <?=bitrix_sessid_post()?>
                <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

                <p class="inline-block margin-b_50"><?=GetMessage("SALE_CANCEL_ORDER1") ?> <a href="<?=$arResult["URL_TO_DETAIL"]?>"><?=GetMessage("SALE_CANCEL_ORDER2")?> #<?=$arResult["ACCOUNT_NUMBER"]?></a>? <strong><?= GetMessage("SALE_CANCEL_ORDER3") ?></strong></p>

                <div class="form-item">
                    <label for="reason-canceled" class="c-label"><?= GetMessage("SALE_CANCEL_ORDER4") ?>:</label>
                    <div class="c-input-field">
                        <textarea id="reason-canceled" class="textarea" name="REASON_CANCELED"></textarea>
                    </div>
                </div>
                <div class="form-item">
                    <input class="submit-btn" type="submit" name="action" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
                </div>

            </form>
        </div>
    <?} else{ ?>
        <?=ShowError($arResult["ERROR_MESSAGE"]);?>
    <?}?>

</div>

<hr>

<a href="<?=$arResult["URL_TO_LIST"]?>">&larr;&nbsp;<?=GetMessage("SALE_RECORDS_LIST")?></a>