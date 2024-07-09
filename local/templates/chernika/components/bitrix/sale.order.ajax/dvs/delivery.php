<?php

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
//show($arResult['DELIVERY']);
if(!empty($arResult['DELIVERY'])) {?>
    <div class="order-data">
        <h2 class="c-legend">
            <small class="c-legend_name">Способ доставки</small>
        </h2>
        <ul class="order-grid" data-order-delivery>
            <?foreach($arResult['DELIVERY'] as $arDelivery) {?>
                <!-- <li class="col-xs-6 col-sm-4"> -->
                <li class="col-xs-12">
                    <label class="order-check" for="delivery_<?=$arDelivery['ID']?>">
                        <input type="radio" name="DELIVERY_ID" id="delivery_<?=$arDelivery['ID']?>" value="<?=$arDelivery['ID']?>" <?=$arDelivery['CHECKED'] == 'Y' ? 'checked' : ''?>>
                        <span class="order-check-in">
                            <?/*if(!empty($arDelivery['LOGOTIP'])) {?>
                                <span class="order-icon" style="background: url('<?=$arDelivery['LOGOTIP']['SRC']?>') 0 0 no-repeat"></span>
                            <?}*/?>
                            <span class="col-xs-10">
                                <span class="order-check-title"><?=$arDelivery['NAME']?></span>
                                <?=htmlspecialchars_decode($arDelivery['DESCRIPTION'])?>
                            </span>
                            <span class="col-xs-2">
                                <?if(!empty($arDelivery['PRICE_FORMATED'])) {?>
                                    <p class="order-check-price"><strong><?=$arDelivery['PRICE_FORMATED']?></strong></p>
                                <?}?>
                                <?if(!empty($arDelivery['PERIOD_TEXT'])) {?>
                                    <p class="order-check-period"><?=$arDelivery['PERIOD_TEXT']?></p>
                                <?}?>
                            </span>
                        </span>
                    </label>
                </li>
            <?}?>
        </ul>

        <p class="order-delivery-text"></p>

        <div class="order-data-caption">
            <strong>Сроки доставки</strong>
            <p>Мы стараемся очень быстро все привести, если вы закажите сейчас, ваш заказ будет говтов завтра.</p>
        </div>

    </div>

    <br><br>
<?}?>
