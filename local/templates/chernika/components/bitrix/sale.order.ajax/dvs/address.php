<?
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
/** @global CMain $APPLICATION */
/** @global CUser $USER */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<div class="order-data">
    <h2 class="c-legend">
        <small class="c-legend_name">Адрес доставки</small>
    </h2>
    <div class="row row-offset-30">
        <? if ($property = $arResult['ORDER_PROPS']['LOCATION']) {
            $required = ($property['REQUIRED'] === 'Y');
            $asterisk = $required ? ' *' : '';
            ?>
            <div class="col-md-8">
                <label class="c-label">Город<?= $asterisk; ?></label>
                <div class="c-input-field">
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
                            // "JS_CALLBACK" => "dvsChangeCity",
                        ),
                        false
                    );
                    ?>
                    <?if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}?>
                </div>
            </div>
        <?}?>
        <? if ($property = $arResult['ORDER_PROPS']['ZIP']) {
            $required = ($property['REQUIRED'] === 'Y');
            $asterisk = $required ? ' *' : '';
            ?>
            <div class="col-md-4">
                <label class="c-label">Индекс<?= $asterisk; ?></label>
                <div class="c-input-field">
                    <input type="text" class="c-input" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>">
                    <?if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}?>
                </div>
            </div>
        <?}?>
    </div>

    <? if ($property = $arResult['ORDER_PROPS']['ADDRESS']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <label class="c-label">Ваш адрес<?= $asterisk; ?></label>
        <div class="c-input-field">
            <input type="text" class="c-input" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>">
            <?if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}?>
        </div>
    <?}?>

    <div class="order-data-caption">
        <strong>Свяжитесь с нами</strong>
        <ul>
            <li>+7 (454) 600-00-00</li>
            <li>Skype: noir</li>
            <li><a href="#">Правила магазина</a></li>
            <li><a href="#">Время работы</a></li>
        </ul>
    </div>

</div>
