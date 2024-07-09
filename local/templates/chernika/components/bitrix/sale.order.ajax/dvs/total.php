<?php
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

//show($arResult['JS_DATA']['TOTAL']);
?>

<div class="checkout-cart">
    <div class="checkout-cart-items-container">
        <? foreach ($arResult['BASKET_ITEMS'] as $arItem) {
            $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture($arItem['PRODUCT_ID']);
            ?>
            <div class="checkout-cart-item">
                <div class="checkout-cart-item-img"><img src="<?= $arItem['PICTURE'] ?>" alt=""></div>
                <div class="checkout-cart-item-content">
                    <h4 class="checkout-cart-item-title"><?= preg_replace("/\(([^()]|(?R))*\)/", "", $arItem['NAME']) ?></h4>
                    
                    <?
                    $size = [];
                    $color = '';
                    foreach ($arItem['PROPS'] as $prop) {
                        if (in_array($prop['CODE'], ['DUZHKA', 'MOST', 'LINZA', 'HEIGHT']))
                            $size[] = $prop['VALUE'];
                        if ($prop['CODE'] == 'COLOR')
                            $color = $prop['VALUE'];
                    }
                    if (!empty($size)) {
                        ?>
                        <p class="checkout-cart-item-text">Размер: <?= implode('-', $size) ?></p>
                    <? } ?>
                    <? if (!empty($color)) { ?>
                        <p class="checkout-cart-item-text">Цвет: <?= $color ?></p>
                    <? } ?>
                    <p class="checkout-cart-item-text">Количество: <?= round($arItem['QUANTITY']) ?>
                        x <?= number_format($arItem['PRICE'], 0, '', ' ') ?> <span class="currency">₽</span></p>
                    <p class="checkout-cart-item-price"><?= number_format($arItem['QUANTITY'] * $arItem['PRICE'], 0, '', ' ') ?>
                        <span class="currency">₽</span></p>
                </div>
            </div>
        <? } ?>
    </div>
    <table class="table">
        <tbody>
        <tr>
            <td>Товаров</td>
            <?
            if(SITE_ID!='m1' || SITE_ID!='m2') {?>
                <td><?=$arResult['JS_DATA']['TOTAL']['ORDER_TOTAL_PRICE_FORMATED']?></td>
            <?} else {?>
                <td><?=$arResult['JS_DATA']['TOTAL']['PRICE_WITHOUT_DISCOUNT']?></td>
            <?}?>
               
            

        </tr>

        <tr>
            <td>Доставка</td>
            <td><?=intval($arResult['JS_DATA']['TOTAL']['DELIVERY_PRICE_FORMATED']) > 0 ? $arResult['JS_DATA']['TOTAL']['DELIVERY_PRICE_FORMATED'] : 'Бесплатно'?></td>
        </tr>

        <?if(!empty($arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE'])) {
            if(SITE_ID!='m1') {
            if(SITE_ID!='m2') {?>
            <tr>
                <td>Экономия</td>
                <td><?=$arResult['JS_DATA']['TOTAL']['DISCOUNT_PRICE_FORMATED']?></td>
            </tr>
        <?}
        }
        }?>
        </tbody>
        <tfoot>
        <tr>
            <th>Всего</th>
            <th><?=$arResult['JS_DATA']['TOTAL']['ORDER_TOTAL_PRICE_FORMATED']?></th>
        </tr>
        <?/* if ($property = $arResult['ORDER_PROPS']['GIFT_WRAP']) {
            $required = ($property['REQUIRED'] === 'Y');
            ?>
            <tr>
                <td colspan="100">
                    <input type="hidden" name="<?= $property['FIELD_NAME']; ?>" value="N">
                    <label class="c-check">
                        <input type="checkbox" class="c-checkbox" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="Y" <?=$property['VALUE'] == 'Y' ? 'checked' : ''?>>
                        <?= $property['NAME']; ?>
                    </label>
                </td>
            </tr>
        <?}*/?>
        </tfoot>
    </table>
</div>
