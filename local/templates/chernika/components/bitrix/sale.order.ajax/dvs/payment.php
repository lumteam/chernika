<?php

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$isPaymentOrder = false;

if (!empty($arResult['PAY_SYSTEM'])) {?>
    <div class="order-data">
        <h2 class="c-legend">
            <small class="c-legend_name">Способ оплаты</small>
        </h2>
        <ul class="order-grid">
            <?foreach ($arResult['PAY_SYSTEM'] as $arPaySystem) {?>
                <?if ($arPaySystem['CHECKED'] === 'Y' && $arPaySystem['PSA_HAVE_RESULT_RECEIVE'] === 'Y') {
                    $isPaymentOrder = true;
                }?>
                <!-- <li class="col-xs-6 col-sm-3"> -->
                <li class="form-item order-delivery-item">
                    <label class="checkbox" for="payment_<?=$arPaySystem['ID']?>">
                        <input class="radio__input" type="radio" name="PAY_SYSTEM_ID" id="payment_<?=$arPaySystem['ID']?>" value="<?=$arPaySystem['ID']?>" data-order-payment <?=$arPaySystem["CHECKED"] == 'Y' ? 'checked' : ''?>>
                        <div class="control__indicator"></div>
                        <span class="order-check-in flb_nw fl-ai_c">
                            <?php if (!IS_MOBILE && !empty($arPaySystem['CODE'])) { ?>
                            <svg class="order-payment_icon">
                                <use xlink:href="#<?php echo $arPaySystem['CODE']?>"></use>
                            </svg>
                            <?php } ?>
                            <span class="order-payment_info">
                                <span class="order-payment_title order-check-title">
                                    <?=$arPaySystem['NAME']?>
                                </span>
                                <?php if (!empty($arPaySystem['DESCRIPTION'])) { ?>
                                <span class="order-payment_description">
                                    <?php echo $arPaySystem['DESCRIPTION']?>
                                </span>
                                <?php } ?>
                            </span>
                        </span>
                    </label>
                </li>
            <?}?>
        </ul>
    </div>
<?}?>
