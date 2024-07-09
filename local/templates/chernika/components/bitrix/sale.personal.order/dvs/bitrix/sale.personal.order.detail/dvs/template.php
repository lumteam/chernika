<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

//use Bitrix\Main\Localization\Loc,
//    Bitrix\Main\Page\Asset;

use Bitrix\Main\Localization\Loc;

\Bitrix\Main\Loader::IncludeModule("sale");

//if ($arParams['GUEST_MODE'] !== 'Y')
//{
//    Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
//    Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
//}
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

//CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle(Loc::getMessage('SPOD_LIST_MY_ORDER', [
    '#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])
]));

if (!empty($arResult['ERRORS']['FATAL'])) {
    foreach ($arResult['ERRORS']['FATAL'] as $error) {
        ShowError($error);
    }

    $component = $this->__component;

    if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
        $APPLICATION->AuthForm('', false, false, 'N', false);
    }
} else {
    if (!empty($arResult['ERRORS']['NONFATAL'])) {
        foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
            ShowError($error);
        }
    }

    $orderStatusColor = '#fbaf5d'; // orange
    if (!empty($arResult['STATUS']['ID'])) {
        $obOrderStatusColorResult = \Bitrix\Sale\Internals\StatusTable::getById($arResult['STATUS']['ID']);
        if ($arOrderStatusColorResult = $obOrderStatusColorResult->fetch()) {
            if ($arOrderStatusColorResult['COLOR'] != 'Y') {
                $orderStatusColor = $arOrderStatusColorResult['COLOR'];
            }
        }
    }

    $orderStatus = false;
    if ($arResult['CANCELED'] !== 'Y') {
        $orderStatus = htmlspecialcharsbx($arResult['STATUS']['NAME']);
    } else {
        $orderStatus = Loc::getMessage('SPOD_ORDER_CANCELED');
        $orderStatusColor = '#f26d7d';
    }

    $isBufferedOutput = false;
    foreach ($arResult['PAYMENT'] as $payment) {
        if ($payment['PAID'] !== 'Y' &&
//            $payment['PAY_SYSTEM']['IS_CASH'] !== 'Y' &&
            $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y' &&
            $arResult['CANCELED'] !== 'Y' &&
            $arResult['IS_ALLOW_PAY'] !== 'N'
        ) {

            $isBufferedOutput = true;
        }
    }
    ?>

    <div class="row">
        <div class="col-sm-8">
            <h4 class="margin-b_0">
                <?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', [
                    "#ACCOUNT_NUMBER#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
                    "#DATE_ORDER_CREATE#" => $arResult["DATE_INSERT_FORMATED"]
                ]) ?>
                <?= count($arResult['BASKET']); ?>
                <?
                $count = count($arResult['BASKET']) % 10;
                if ($count == '1') {
                    echo Loc::getMessage('SPOD_TPL_GOOD');
                } elseif ($count >= '2' && $count <= '4') {
                    echo Loc::getMessage('SPOD_TPL_TWO_GOODS');
                } else {
                    echo Loc::getMessage('SPOD_TPL_GOODS');
                }
                ?>
                <?= Loc::getMessage('SPOD_TPL_SUMOF') ?>
                <?= $arResult["PRICE_FORMATED"] ?>
            </h4>
        </div>
        <div class="col-sm-4 text-right">
            <h4 class="margin-b_0"><span class="order-status" style="background-color:<?=$orderStatusColor?>;border-color:<?=$orderStatusColor?>"></span> <?=$orderStatus?></h4>
        </div>
    </div>
    <?if ($isBufferedOutput) {?>
        <div class="row flb fl-ai_c history-item-footer">
            <div class="col-sm-6">
                <?if ($arResult['CAN_CANCEL'] === 'Y') {?>
                    <small style="margin-right:10px">
                        <a class="print-btn" href="<?= $arResult["URL_TO_CANCEL"] ?>">
                            <?= Loc::getMessage('SPOD_ORDER_CANCEL') ?>
                        </a>
                    </small>
                <?}?>
                <?if ($arParams['GUEST_MODE'] !== 'Y') {?>
                    <a class="submit-btn btn-inverse-width btn-inverse" href="<?= $arResult["URL_TO_COPY"] ?>">
                        <?= Loc::getMessage('SPOD_ORDER_REPEAT') ?>
                    </a>
                <?}?>
            </div>
            <div class="col-sm-6 text-right">
                <?=$payment['BUFFERED_OUTPUT']?>
            </div>
        </div>
    <?}?>

    <hr>
    <div class="row margin-b_30"></div>

    <div class="row margin-b_30">
        <div class="col-sm-6">
            <h4 class="margin_0"><?= Loc::getMessage('SPOD_ORDER_PAYMENT') ?></h4>
        </div>
        <div class="col-sm-6">
            <?
            $arResult['PAYMENT'] = array_values($arResult['PAYMENT']);
            foreach ($arResult['PAYMENT'] as $paymentKey => $payment) {?>
                <div class="order-charac-item">
                    <div class="order-charac-item_value">
                        <?php if (!IS_MOBILE && !empty($payment['PAY_SYSTEM']['CODE'])) { ?>
                        <svg class="order-payment_icon">
                            <use xlink:href="#<?php echo $payment['PAY_SYSTEM']['CODE']?>"></use>
                        </svg>
                        <?php } ?>
                        <?=html_entity_decode($payment['PAY_SYSTEM_NAME'])?>
                    </div>
                </div>
                <div class="order-charac-item">
                    <div class="order-charac-item_value">
                        <?
                        $paymentData[$payment['ACCOUNT_NUMBER']] = [
                            "payment" => $payment['ACCOUNT_NUMBER'],
                            "order" => $arResult['ACCOUNT_NUMBER'],
                            "allow_inner" => $arParams['ALLOW_INNER'],
                            "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                            "refresh_prices" => $arParams['REFRESH_PRICES'],
                            "path_to_payment" => $arParams['PATH_TO_PAYMENT']
                        ];
                        $paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL') . " " . Loc::getMessage('SPOD_NUM_SIGN') . $payment['ACCOUNT_NUMBER'];
                        if (isset($payment['DATE_BILL'])) {
                            $paymentSubTitle .= " " . Loc::getMessage('SPOD_FROM') . " " . $payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
                        }
    //                    $paymentSubTitle .= ",";
                        echo htmlspecialcharsbx($paymentSubTitle);
    //                    echo html_entity_decode($payment['PAY_SYSTEM_NAME']);
                        ?>
                    </div>
                </div>

                <div class="order-charac-item">
                    <div class="order-charac-item_value">
                        <?if ($payment['PAID'] === 'Y') {?>
                            <strong class="text-green"><?= Loc::getMessage('SPOD_PAYMENT_PAID') ?></strong>
                        <?} elseif ($arResult['IS_ALLOW_PAY'] == 'N') {?>
                            <strong class="text-orange"><?= Loc::getMessage('SPOD_TPL_RESTRICTED_PAID') ?></strong>
                        <?} else {?>
                            <strong class="text-orange"><?= Loc::getMessage('SPOD_PAYMENT_UNPAID') ?></strong>
                        <?}?>
                    </div>
                </div>

                <?
                /*if (!empty($payment['CHECK_DATA'])) {
                    $listCheckLinks = "";
                    foreach ($payment['CHECK_DATA'] as $checkInfo) {
                        $title = Loc::getMessage('SPOD_CHECK_NUM', ['#CHECK_NUMBER#' => $checkInfo['ID']]) . " - " . htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                        if (strlen($checkInfo['LINK']) > 0) {
                            $link = $checkInfo['LINK'];
                            $listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
                        }
                    }
                    if (strlen($listCheckLinks) > 0) {
                        ?>
                        <div class="sale-order-detail-payment-options-methods-info-total-check">
                            <div class="sale-order-detail-sum-check-left"><?= Loc::getMessage('SPOD_CHECK_TITLE') ?>
                                :
                            </div>
                            <div class="sale-order-detail-sum-check-left">
                                <?= $listCheckLinks ?>
                            </div>
                        </div>
                        <?
                    }
                }
                if (
                    $payment['PAID'] !== 'Y'
                    && $arResult['CANCELED'] !== 'Y'
                    && $arParams['GUEST_MODE'] !== 'Y'
                    && $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
                ) {
                    ?>
                    <a href="#" id="<?= $payment['ACCOUNT_NUMBER'] ?>"
                       class="sale-order-detail-payment-options-methods-info-change-link"><?= Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE') ?></a>
                    <?
                }*/
                ?>
                <?
                /*if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y') {
                    ?>
                    <div class="sale-order-detail-status-restricted-message-block">
                        <span class="sale-order-detail-status-restricted-message"><?= Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE') ?></span>
                    </div>
                    <?
                }*/
                ?>

                <?/*if ($payment['PAY_SYSTEM']["IS_CASH"] !== "Y") {
                    if ($payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult["IS_ALLOW_PAY"] !== "N") {?>
                        <a class="btn-theme sale-order-detail-payment-options-methods-button-element-new-window"
                           target="_blank"
                           href="<?= htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE']) ?>">
                            <?= Loc::getMessage('SPOD_ORDER_PAY') ?>
                        </a>
                        <?
                    } else {
                        if ($payment["PAID"] === "Y" || $arResult["CANCELED"] === "Y" || $arResult["IS_ALLOW_PAY"] === "N") {
                            ?>
                            <a class="btn-theme sale-order-detail-payment-options-methods-button-element inactive-button"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
                            <?
                        } else {
                            ?>
                            <a class="btn-theme sale-order-detail-payment-options-methods-button-element active-button"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
                            <?
                        }
                    }
                }*/?>
                <?/*?><div class="sale-order-detail-payment-inner-row-template col-md-offset-3 col-sm-offset-5 col-md-5 col-sm-10 col-xs-12">
                    <a class="sale-order-list-cancel-payment">
                        <i class="fa fa-long-arrow-left"></i> <?= Loc::getMessage('SPOD_CANCEL_PAYMENT') ?>
                    </a>
                </div><?*/?>

                <?/*if ($payment["PAID"] !== "Y"
                    && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                    && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                    && $arResult['CANCELED'] !== 'Y'
                    && $arResult["IS_ALLOW_PAY"] !== "N") {?>
                    <p>
                        <?= $payment['BUFFERED_OUTPUT'] ?>
                    </p>
                <?}*/?>
                <?if ($paymentKey) {?>
                <hr>
                <?}?>
            <?}?>
        </div>
    </div>

    <?if (count($arResult['SHIPMENT'])) {?>
    <div class="row margin-b_30">
        <div class="col-sm-6">
            <h4 class="margin_0"><?= Loc::getMessage('SPOD_ORDER_SHIPMENT') ?></h4>
        </div>
        <div class="col-sm-6">
            <?foreach ($arResult['SHIPMENT'] as $shipmentKey => $shipment) {
                $shipmentStatusColor = '#fbaf5d'; // orange
                if (!empty($shipment['STATUS_ID'])) {
                    $obShipmentStatusColorResult = \Bitrix\Sale\Internals\StatusTable::getById($shipment['STATUS_ID']);
                    if ($arShipmentStatusColorResult = $obShipmentStatusColorResult->fetch()) {
                        if ($arShipmentStatusColorResult['COLOR'] != 'Y') {
                            $shipmentStatusColor = $arShipmentStatusColorResult['COLOR'];
                        }
                    }
                }

                if (isset($arResult['ORDER_PROPS'])) {
                    $shipmentAddress = [];
                    foreach ($arResult['ORDER_PROPS'] as $key => $property) {
                        if ($property['CODE'] == 'ZIP') {
                            $shipmentAddress[0] = $property['VALUE'];
                            unset($arResult['ORDER_PROPS'][$key]);
                        }
                        if ($property['CODE'] == 'LOCATION') {
                            $shipmentAddress[1] = $property['VALUE'];
                            unset($arResult['ORDER_PROPS'][$key]);
                        }
                        if ($property['CODE'] == 'ADDRESS') {
                            $shipmentAddress[2] = $property['VALUE'];
                            unset($arResult['ORDER_PROPS'][$key]);
                        }
                    }
                    unset($property);
                }?>
                <?if (!empty($shipmentAddress)) {
                    ksort($shipmentAddress);?>
                    <div class="order-charac-item flb_nw">
                        <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_STORE_ADDRESS') ?>:</span></div><?*/?>
                        <div class="order-charac-item_value"><?= implode(', ', $shipmentAddress) ?></div>
                    </div>
                <?}?>
                <?if (strlen($shipment["DELIVERY_NAME"])) {?>
                    <div class="order-charac-item flb_nw">
                        <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_ORDER_DELIVERY') ?>:</span></div><?*/?>
                        <div class="order-charac-item_value"><?= htmlspecialcharsbx($shipment["DELIVERY_NAME"]) ?></div>
                    </div>
                <?}?>
                <?if (!strlen($shipment['PRICE_DELIVERY_FORMATED'])) {
                    $shipment['PRICE_DELIVERY_FORMATED'] = 0;
                }?>
                <?if ($shipment["DATE_DEDUCTED"]) {?>
                    <div class="order-charac-item flb_nw">
                        <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_FROM') ?>:</span></div><?*/?>
                        <div class="order-charac-item_value"><?= $shipment["DATE_DEDUCTED"]->format($arParams['ACTIVE_DATE_FORMAT']) ?></div>
                    </div>
                <?}?>
                <div class="order-charac-item flb_nw">
                    <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_SUB_PRICE_DELIVERY') ?>:</span></div><?*/?>
                    <div class="order-charac-item_value"><?= $shipment['PRICE_DELIVERY_FORMATED'] ?></div>
                </div>
                <?/*?><div class="order-charac-item flb_nw">
                    <div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT') ?>:</span></div>
                    <div class="order-charac-item_value"><?= Loc::getMessage('SPOD_NUM_SIGN') . $shipment["ACCOUNT_NUMBER"] ?></div>
                </div><?*/?>
                <div class="order-charac-item flb_nw">
                    <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS') ?>:</span></div><?*/?>
                    <div class="order-charac-item_value"><strong style="color:<?=$shipmentStatusColor?>"><?= htmlspecialcharsbx($shipment['STATUS_NAME']) ?></strong></div>
                </div>
                <?if (strlen($shipment['TRACKING_NUMBER'])) {?>
                    <div class="order-charac-item flb_nw">
                        <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?>:</span></div><?*/?>
                        <div class="order-charac-item_value">
                            <?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                            <?if (strlen($shipment['TRACKING_URL'])) {?>
                                <br><a href="<?= $shipment['TRACKING_URL'] ?>"><?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING') ?></a>
                            <?}?>
                        </div>
                    </div>
                <?}?>
                <?
                $store = $arResult['DELIVERY']['STORE_LIST'][$shipment['STORE_ID']];
                if (isset($store)) {
                ?>
                    <div class="order-charac-item flb_nw">
                        <p class="h4"><?= Loc::getMessage('SPOD_SHIPMENT_STORE') ?></p>
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:map.yandex.view",
                            "",
                            [
                                "INIT_MAP_TYPE" => "COORDINATES",
                                "MAP_DATA" => serialize(
                                    [
                                        'yandex_lon' => $store['GPS_S'],
                                        'yandex_lat' => $store['GPS_N'],
                                        'PLACEMARKS' => [
                                            [
                                                "LON" => $store['GPS_S'],
                                                "LAT" => $store['GPS_N'],
                                                "TEXT" => htmlspecialcharsbx($store['TITLE'])
                                            ]
                                        ]
                                    ]
                                ),
                                "MAP_WIDTH" => "100%",
                                "MAP_HEIGHT" => "300",
                                "CONTROLS" => ["ZOOM", "SMALLZOOM", "SCALELINE"],
                                "OPTIONS" => [
                                    "ENABLE_DRAGGING",
                                    "ENABLE_SCROLL_ZOOM",
                                    "ENABLE_DBLCLICK_ZOOM"
                                ],
                                "MAP_ID" => ""
                            ]
                        );
                        ?>
                    </div>
                    <?if (strlen($store['ADDRESS'])) {?>
                        <div class="order-charac-item flb_nw">
                            <div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_STORE_ADDRESS') ?>:</span></div>
                            <div class="order-charac-item_value"><?= htmlspecialcharsbx($store['ADDRESS']) ?></div>
                        </div>
                    <?}
                }?>

                <?if ($shipmentKey) {?>
                <hr>
                <?}?>
            <?}?>
        </div>
    </div>
    <?}?>

    <div class="row margin-b_30">
        <div class="col-sm-6">
            <h4 class="margin_0">Получатель</h4>
        </div>
        <div class="col-sm-6">
            <?/*?>
            <?if (isset($arResult['ORDER_PROPS'])) {
                $personName = [];
                foreach ($arResult['ORDER_PROPS'] as $key => $property) {
                    if ($property['CODE'] == 'USER_NAME') {
                        $personName[1] = $property['VALUE'];
                        unset($arResult['ORDER_PROPS'][$key]);
                    }
                    if ($property['CODE'] == 'USER_SECOND_NAME') {
                        $personName[0] = $property['VALUE'];
                        unset($arResult['ORDER_PROPS'][$key]);
                    }
                }
                unset($property);
            }?>
            <p class="inline-block"><?=implode(' ', $personName)?></p>
            <?*/?>

            <?if (strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO'])) {?>
                <div class="order-charac-item flb_nw">
                    <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_LOGIN') ?>:</span></div><?*/?>
                    <div class="order-charac-item_value"><?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?></div>
                </div>
            <?}
            /*if (strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO'])) {?>
                <div class="order-charac-item flb_nw">
                    <div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_EMAIL') ?>:</span></div>
                    <div class="order-charac-item_value"><a class="sale-order-detail-about-order-inner-container-list-item-link" href="mailto:<?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?>"><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></a></div>
                </div>
            <?}*/
            if (strlen($arResult["USER"]["PERSON_TYPE_NAME"]) && !in_array("PERSON_TYPE_NAME", $arParams['HIDE_USER_INFO'])) {?>
                <div class="order-charac-item flb_nw">
                    <?/*?><div class="order-charac-item_attr"><span><?= Loc::getMessage('SPOD_PERSON_TYPE_NAME') ?>:</span></div><?*/?>
                    <div class="order-charac-item_value"><?= htmlspecialcharsbx($arResult["USER"]["PERSON_TYPE_NAME"]) ?></div>
                </div>
            <?}
            if (isset($arResult["ORDER_PROPS"])) {
                foreach ($arResult["ORDER_PROPS"] as $property) {
                    if (in_array($property['CODE'], $arParams['HIDE_USER_INFO'])) {
                        continue;
                    }?>
                    <div class="order-charac-item flb_nw">
                        <?/*?><div class="order-charac-item_attr"><span><?= htmlspecialcharsbx($property['NAME']) ?>:</span></div><?*/?>
                        <div class="order-charac-item_value">
                            <?
                            if ($property["TYPE"] == "Y/N") {
                                echo Loc::getMessage('SPOD_' . ($property["VALUE"] == "Y" ? 'YES' : 'NO'));
                            } else {
                                if ($property['MULTIPLE'] == 'Y'
                                    && $property['TYPE'] !== 'FILE'
                                    && $property['TYPE'] !== 'LOCATION') {
                                    $propertyList = unserialize($property["VALUE"]);
                                    foreach ($propertyList as $propertyElement) {
                                        echo $propertyElement . '</br>';
                                    }
                                } elseif ($property['TYPE'] == 'FILE') {
                                    echo $property["VALUE"];
                                } else {
                                    echo htmlspecialcharsbx($property["VALUE"]);
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?}
            }?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4><?= Loc::getMessage('SPOD_ORDER_BASKET') ?></h4>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2"><?= Loc::getMessage('SPOD_NAME') ?></th>
                            <th><?= Loc::getMessage('SPOD_PRICE') ?></th>
                            <?if (strlen($arResult["SHOW_DISCOUNT_TAB"])) {?>
                            <th><?= Loc::getMessage('SPOD_DISCOUNT') ?></th>
                            <?}?>
                            <th><?= Loc::getMessage('SPOD_QUANTITY') ?></th>
                            <th><?= Loc::getMessage('SPOD_ORDER_PRICE') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach ($arResult['BASKET'] as $basketItem) {?>
                            <tr>
                                <td class="cart-item-img is-xs-hidden">
                                    <a class="nt" href="<?=$basketItem['DETAIL_PAGE_URL']?>">
                                        <?$arPicture = $basketItem['PICTURE'];
                                        if (!empty($arPicture['2X'])) {?>
                                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?=$arPicture['1X']['SRC']?>" data-srcset="<?=$arPicture['1X']['SRC']?> 1x, <?=$arPicture['2X']['SRC']?> 2x" width="<?=$arPicture['1X']['WIDTH']?>" height="<?=$arPicture['1X']['HEIGHT']?>" alt="<?=$item['NAME']?>">
                                        <?} else {?>
                                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?=$arPicture['1X']['SRC']?>" width="<?=$arPicture['1X']['WIDTH']?>" height="<?=$arPicture['1X']['HEIGHT']?>" alt="<?=$item['NAME']?>">
                                        <?}?>
                                        <noscript>
                                            <img src="<?=$arPicture['1X']['SRC']?>" alt="<?=$item['NAME']?>">
                                        </noscript>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= $basketItem['DETAIL_PAGE_URL'] ?>">
                                        <?= htmlspecialcharsbx($basketItem['NAME']) ?>
                                    </a>
                                    <?if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS'])) {
                                        foreach ($basketItem['PROPS'] as $itemProps) {?>
                                            <div class="sale-order-detail-order-item-color">
                                            <span class="sale-order-detail-order-item-color-name">
                                                <?= htmlspecialcharsbx($itemProps['NAME']) ?>:</span>
                                                <span class="sale-order-detail-order-item-color-type">
                                                <?= htmlspecialcharsbx($itemProps['VALUE']) ?></span>
                                            </div>
                                        <?}
                                    }?>
                                </td>
                                <td><?= $basketItem['BASE_PRICE_FORMATED'] ?></td>
                                <?if (strlen($arResult["SHOW_DISCOUNT_TAB"]) || strlen($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"])) {?>
                                    <td><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></td>
                                <?}?>
                                <td>
                                    <?= $basketItem['QUANTITY'] ?>&nbsp;
                                    <?if (strlen($basketItem['MEASURE_NAME'])) {
                                        echo htmlspecialcharsbx($basketItem['MEASURE_NAME']);
                                    } else {
                                        echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
                                    }?>
                                </td>
                                <td><?= $basketItem['FORMATED_SUM'] ?></td>
                            </tr>
                        <?}?>
                        <tr>
                            <td colspan="<?=(strlen($arResult["SHOW_DISCOUNT_TAB"]) > 0 ? '4' : '3')?>">
                                <?if (floatval($arResult["ORDER_WEIGHT"])) {?>
                                    <p class="text-right"><?= Loc::getMessage('SPOD_TOTAL_WEIGHT') ?>:</p>
                                <?}

                                if ($arResult['PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_FORMATED'])) {?>
                                    <p class="text-right"><?= Loc::getMessage('SPOD_COMMON_SUM') ?>:</p>
                                <?}

                                if (strlen($arResult["PRICE_DELIVERY_FORMATED"])) {?>
                                    <p class="text-right"><?= Loc::getMessage('SPOD_DELIVERY') ?>:</p>
                                    <?
                                }

                                if ((float)$arResult["TAX_VALUE"] > 0) {?>
                                    <p class="text-right"><?= Loc::getMessage('SPOD_TAX') ?>:</p>
                                <?}?>

                                <p class="text-right"><?= Loc::getMessage('SPOD_SUMMARY') ?>:</p>
                            </td>
                            <td colspan="2">
                                <?if (floatval($arResult["ORDER_WEIGHT"])) {?>
                                    <p><strong><?= $arResult['ORDER_WEIGHT_FORMATED'] ?></strong></p>
                                <?}

                                if ($arResult['PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_FORMATED'])) {?>
                                    <p><strong><?= $arResult['PRODUCT_SUM_FORMATED'] ?></strong></p>
                                <?}

                                if (strlen($arResult["PRICE_DELIVERY_FORMATED"])) {?>
                                    <p><strong><?= $arResult["PRICE_DELIVERY_FORMATED"] ?></strong></p>
                                <?}

                                if ((float)$arResult["TAX_VALUE"] > 0) {?>
                                    <p><strong><?= $arResult["TAX_VALUE_FORMATED"] ?></strong></p>
                                <?}?>
                                <p><strong><?= $arResult['PRICE_FORMATED'] ?></strong></p>
                            </td>
                        </tr>
                    </tbody>
                </table><!-- /table -->
            </div><!-- /table-container -->
        </div>
    </div>

    <hr>

    <?/*?><div class="row margin-b_30 flb fl-ai_c">
        <div class="col-sm-6">
            <?if ($arParams['GUEST_MODE'] !== 'Y') {?>
                <a class="btn btn-white_invert" href="<?= $arResult["URL_TO_COPY"] ?>">
                    <mark>
                        <?= Loc::getMessage('SPOD_ORDER_REPEAT') ?>
                    </mark>
                </a>
            <?}?>
            <?if ($arResult["CAN_CANCEL"] === "Y") {?>
                <small style="margin-left:10px">
                    <a href="<?= $arResult["URL_TO_CANCEL"] ?>">
                        <?= Loc::getMessage('SPOD_ORDER_CANCEL') ?>
                    </a>
                </small>
            <?}?>
        </div>
        <div class="col-sm-6 text-right">
            <?foreach ($arResult['PAYMENT'] as $payment) {
               if ($payment["PAID"] !== "Y"
                    && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                    && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                    && $arResult['CANCELED'] !== 'Y'
                    && $arResult["IS_ALLOW_PAY"] !== "N"
               ) {

                    echo $payment['BUFFERED_OUTPUT'];
               }
            }?>
        </div>
    </div><?*/?>

    <div class="row margin-b_30 flb fl-ai_c">
        <div class="col-sm-6">
            <?if ($arParams['GUEST_MODE'] !== 'Y') {?>
                <a href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>">
                    &larr;&nbsp;<?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?>
                </a>
            <?}?>
        </div>
        <div class="col-sm-6 text-right">

        </div>
    </div>

    <?
    $javascriptParams = [
        "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
        "templateFolder" => CUtil::JSEscape($templateFolder),
        "templateName" => $this->__component->GetTemplateName(),
        "paymentList" => $paymentData
    ];
    $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
    ?>
    <?/*?><script>
        BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
    </script><?*/?>
<?
}