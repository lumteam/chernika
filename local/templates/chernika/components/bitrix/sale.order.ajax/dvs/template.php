<?
use Bitrix\Main\Context;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 * @var $USER CUser
 * @var string $templateFolder
 * @var $component SaleOrderAjax
 */

$request = Context::getCurrent()->getRequest();

$isAjaxRequest = ($request->isAjaxRequest() && $request->get('ajax'));
$isConfirmOrder = ($request->getPost('confirmorder') === 'Y');

if ($isAjaxRequest) {
    $APPLICATION->RestartBuffer();
} else {
//    if ($_SESSION['GEO_IP']['ID'] > 0) {
//        $arResult['ORDER_PROPS']['LOCATION']['VALUE'] = $_SESSION['GEO_IP']['ID'];
//    }
}
?>

<div class="order" id="js-order-form-container">
<div style="color:red"><b>Цена со скидкой действительна только при заказе очков вместе линзами</b><br/>
Ожидайте подтверждение резерва от менеджера</div>
    <?php /*if (strlen($request->get('ORDER_ID')) > 0) {
        include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/confirm.php');
    }*/
    if (isset($arResult['USER_VALS']['CONFIRM_ORDER']) && $arResult['USER_VALS']['CONFIRM_ORDER'] == 'Y') {
        include($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/confirm.php');
    } elseif (!empty($arResult['BASKET_ITEMS'])) {?>
        <form id="js-order-form" class="checkout" action="<?=POST_FORM_ACTION_URI?>" data-order-form="" onsubmit="ym(24545261, 'reachGoal', 'order'); return true;">
            <?=bitrix_sessid_post();?>
            <input type="hidden" name="profile_change" value="N">
            <input type="hidden" name="PERSON_TYPE" value="<?=$arResult['USER_VALS']['PERSON_TYPE_ID'];?>">
            <input type="hidden" name="PROFILE_ID" value="<?=$arResult['USER_VALS']['PROFILE_ID'];?>">
            <input type="hidden" name="confirmorder" value="N">
            <?if($locationProperty = $arResult['ORDER_PROPS']['LOCATION']) {?>
                <input type="hidden" name="<?= $locationProperty['FIELD_NAME'];?>" value="<?=$locationProperty['VALUE'];?>">
            <?}?>



            <div class="row">
                <div class="col-12 col-md-12 col-xl-6">
                    <div class="order-content">
                        <?if ($isConfirmOrder && !empty($arResult['ERROR'])) {?>
                        <div id="order-error" style="color:red" data-order-errors>
                            <?foreach ($arResult['ERROR'] as &$error) {
                                if (stripos($error, 'Пользователь с таким e-mail') !== false) {
                                    $errorText =  'Если это ваш электронный адрес, пожалуйста, <a href="javascript:void(0)" onclick="$(\'.js-profile\').click();$(\'#login-modal\').find(\'input[name=USER_LOGIN]\').val(\''.$arResult['ORDER_DATA']['USER_EMAIL'].'\');">авторизуйтесь</a>.';
                                    $errorText .= ' ';
                                    $errorText .= 'Если вы&nbsp;забыли пароль&nbsp;&mdash; воспользуйтесь <a href="/personal/?forgot_password=yes&email='.rawurlencode($arResult['ORDER_DATA']['USER_EMAIL']).'">формой восстановления пароля</a>.';

                                    $error = str_ireplace(['e-mail', '<br>', '<br/>', '<br />'], ['электронным адресом', ''], $error);
                                    $error .= ' ' . $errorText;
                                }
                            }
                            echo implode('<br>', $arResult['ERROR']);?>
                            <br><br>
                            <script>
                                window.location.hash = '#js-order-form-container';
                                chromeHash('#js-order-form-container');
                            </script>
                        </div>
                        <?}?>

                        <?
                        include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/delivery_combo.php');
                        //include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/address.php');
                        // include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/delivery.php');
                        include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/buyer.php');
                        // include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/address.php');
                        // include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/delivery.php');
                        
                    include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/payment.php');
                        ?>
                    </div>
                </div>
                <div class="d-none d-xl-block col-xl-1"></div>
                <div class="d-none d-xl-block col">
                    <h4 class="checkout-title with-btn">
                        <span>Состав заказа</span>
                        <a href="<?= $arParams['PATH_TO_BASKET'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="15" height="10"
                                 viewbox="0 0 15 10">
                                <defs>
                                    <path id="w7x2a" d="M1434 243h13.5"></path>
                                    <path id="w7x2b" d="M1438 247l-4-4 4-4"></path>
                                </defs>
                                <g>
                                    <g transform="translate(-1433 -238)">
                                        <g>
                                            <use fill="#fff" fill-opacity="0" stroke="#979797"
                                                 stroke-linecap="round"
                                                 stroke-miterlimit="50" xlink:href="#w7x2a"></use>
                                        </g>
                                        <g>
                                            <use fill="#fff" fill-opacity="0" stroke="#979797"
                                                 stroke-linecap="round"
                                                 stroke-miterlimit="50" xlink:href="#w7x2b"></use>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span>Редактировать</span>
                        </a>
                    </h4>
                    <div class="order-results">
                        <?include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/total.php');?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-xl-6">
                    <h4 class="checkout-title mt-30">Комментарий к заказу</h4>
                    <div class="form-item">
                        <textarea name="ORDER_DESCRIPTION" rows="4" placeholder="Ваш комментарий" class="textarea"><?=$arResult['JS_DATA']['ORDER_DESCRIPTION']?></textarea>

                        <input type="hidden" name="UTM_SOURCE" value="<?php if (isset($_SESSION['utm_source'])) {
                            echo $_SESSION['utm_source'];
                        } ?>">
                        <input type="hidden" name="referer" value="">
                        <input type="hidden" name="freferer" value="">
                        <input type="hidden" name="clientID" value="">
                    </div>
                    <div class="form-item">
                    
                    <?$isPaymentOrder = false;?>
                        <button id="order-submit"  class="submit-btn" data-order-submit><?=($isPaymentOrder ? 'Оплатить заказ' : 'Оформить заказ')?></button>
                    </div>
                    <div class="form-item">
                        <p>Нажимая на&nbsp;кнопку «<?=($isPaymentOrder ? 'Оплатить заказ' : 'Оформить заказ')?>», вы&nbsp;подтверждаете, что согласны <a class="underline" href="/privacy-policy/">с&nbsp;условиями</a> обработки персональных данных.</p>
                    </div>
                </div>
            </div>

        </form>
    <?}?>
</div>

<?
//show($arResult);
if ($isAjaxRequest) {
    die();
}
?>

<script>
    var phonePattern = /<?=PHONE_PATTERN?>/,
        phoneFormat = '<?=PHONE_FORMAT?>',
        locationInputName = '<?=$arResult['ORDER_PROPS']['LOCATION']['FIELD_NAME']?>';
</script>
