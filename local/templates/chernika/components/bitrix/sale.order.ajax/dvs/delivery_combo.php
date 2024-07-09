<?php

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
?>
<div class="order-data">
    <h2 class="c-legend">
        <small class="c-legend_name">Доставка</small>
    </h2>

    <? if ($property = $arResult['ORDER_PROPS']['LOCATION']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Город<?= $asterisk; ?></label>
            <?
            $APPLICATION->IncludeComponent(
                'bitrix:sale.location.selector.search',
                '.default',
                array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "FILTER_BY_SITE" => "N",
                    "PROVIDE_LINK_BY" => "id",
                    "ID" => $property['VALUE'],
                    "INPUT_NAME" => $property['FIELD_NAME'],
                    "REQUIRED" => $required,
                    "FIELD_ID" => $property['ID'],
                    // "JS_CALLBACK" => "dvsChangeCity",
                ),
                false
            );
            ?>
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
        
    <?}?>
    <? if ($property = $arResult['ORDER_PROPS']['ZIP']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Индекс<?= $asterisk; ?></label>
            <input id="field-<?=$property['ID']?>" type="text" class="c-input" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>" pattern="[0-9]{6}">
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
    <?}?>
</div>

<?if(!empty($arResult['DELIVERY'])) {
    $checkedDeliveryId = 0;?>
    <h4>Способ доставки</h4>
    <ul class="order-grid" data-order-delivery>
        <?foreach($arResult['DELIVERY'] as $arDelivery) {?>
            <!-- <li class="col-xs-6 col-sm-4"> -->
            <li class="form-item order-delivery-item">
                <label class="checkbox" for="delivery_<?=$arDelivery['ID']?>">
                    <input class="radio__input" type="radio" name="DELIVERY_ID" id="delivery_<?=$arDelivery['ID']?>" value="<?=$arDelivery['ID']?>" <?=$arDelivery['CHECKED'] == 'Y' ? 'checked' : ''?>>
                    <div class="control__indicator"></div>
                    <span class="order-check-in">
                        <?/*if(!empty($arDelivery['LOGOTIP'])) {?>
                            <span class="order-icon" style="background: url('<?=$arDelivery['LOGOTIP']['SRC']?>') 0 0 no-repeat"></span>
                        <?}*/?>
                        <span class="col-xs-10 order-check-span">
                            <span class="order-check-title"><?=$arDelivery['NAME']?></span>
                            <?if (!empty($arDelivery['DESCRIPTION'])) {?>
                                <span class="order-check-description"><?=htmlspecialchars_decode($arDelivery['DESCRIPTION'])?></span>
                            <?}?>
                        </span>
                        <span class="col-xs-2 order-check-span">
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
            <?if ($arDelivery['CHECKED'] == 'Y') {
                $checkedDeliveryId = $arDelivery['ID'];
            }?>
        <?}?>
    </ul>

    
    <? if ($property = $arResult['ORDER_PROPS']['USER_ADRESS'] && $checkedDeliveryId==='14' || 
        $property = $arResult['ORDER_PROPS']['USER_ADRESS'] && $checkedDeliveryId==='16' ||
        $property = $arResult['ORDER_PROPS']['USER_ADRESS'] && $checkedDeliveryId==='17') {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-9"><strong>Адрес доставки: <?=$asterisk; ?></strong></label>
            <input id="field-9" type="text" class="c-input required" name="USER_ADRESS"<?= ($required ? ' required' : ''); ?> value="<?=$arResult['USER_ADRESS1']?>" pattern='\S'>
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
    <?}?>

<?}?>
<?//show($arResult['DELIVERY'], true)?>
<?if ($checkedDeliveryId == SDEK_PVZ) {?>
    <div id="sdek-pvz-link" class="c-input-field">
        <svg class="svg-spinner"><use xlink:href="#el_anim_svg"></use></svg>
        <?
        /*
        $APPLICATION->IncludeComponent(
            "ipol:ipol.sdekPickup",
            "custom-order",
            Array(
                "CITIES" => array(),
                "CNT_BASKET" => "Y",
                "CNT_DELIV" => "N",
                "COUNTRIES" => array(),
                "FORBIDDEN" => array(),
                "NOMAPS" => "N",
                "PAYER" => "",
                "PAYSYSTEM" => "",
            )
        );
        */?>
    </div>
<?}?>

<?if ($property = $arResult['ORDER_PROPS']['ADDRESS']) {
    if ($checkedDeliveryId == SDEK_PVZ) {
        $property['VALUE'] = empty($property['VALUE']) ? ' ' : $property['VALUE']; // скрываем ошибку про Заполните адрес
        ?>
        <input id="<?= $property['FIELD_NAME']; ?>" type="hidden" name="<?= $property['FIELD_NAME']; ?>" value="<?= $property['VALUE']; ?>">
    <?} else {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Адрес доставки<?= $asterisk; ?></label>
            <input id="field-<?=$property['ID']?>" type="text" class="c-input" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>" pattern="\S">
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
    <?}?>
<?}?>

