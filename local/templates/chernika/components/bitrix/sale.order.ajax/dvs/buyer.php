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
        <small class="c-legend_name">Контактная информация</small>
    </h2>

    <? if ($property = $arResult['ORDER_PROPS']['USER_NAME']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Имя<?= $asterisk; ?></label>
            <input id="field-<?=$property['ID']?>" type="text" class="c-input" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>" pattern="\S">
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
    <?}?>
    <? if ($property = $arResult['ORDER_PROPS']['USER_SECOND_NAME']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Фамилия<?= $asterisk; ?></label>
            <input id="field-<?=$property['ID']?>" type="text" class="c-input" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>" pattern="\S">
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
    <?}?>
    <? if ($property = $arResult['ORDER_PROPS']['EMAIL']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Ваш e-mail<?= $asterisk; ?></label>
            <input id="field-<?=$property['ID']?>" type="email" class="c-input required" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>" pattern='^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$'>
            <?/*if($required){?><i class="c-error">Пожалуйста, введите корректный адрес электронной почты.</i><?}*/?>
        </div>
    <?}?>
    <? if ($property = $arResult['ORDER_PROPS']['PHONE']) {
        $required = ($property['REQUIRED'] === 'Y');
        $asterisk = $required ? ' *' : '';
        ?>
        <div class="form-item">
            <label class="c-label" for="field-<?=$property['ID']?>">Ваш телефон<?= $asterisk; ?></label>
            <input id="field-<?=$property['ID']?>" type="tel" class="c-input required js-phone-mask" name="<?= $property['FIELD_NAME']; ?>"<?= ($required ? ' required' : ''); ?> value="<?= $property['VALUE']; ?>" pattern="<?=PHONE_PATTERN?>">
            <?/*if($required){?><i class="c-error">Пожалуйста, заполните поле.</i><?}*/?>
        </div>
    <?}?>
</div>

<script>
function maskInput() {
    $('#ORDER_PROP_3').mask("+7(999) 999 99-99",{placeholder:"_"});
    $('.phonemask').mask("+7(999) 999 99-99",{placeholder:"_"});
    $('.js-phone-mask').mask("+7(999) 999 99-99",{placeholder:"_"});
}
maskInput();
</script>