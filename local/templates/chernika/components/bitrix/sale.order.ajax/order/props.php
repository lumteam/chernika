<?
$errorFields = array();
foreach ( $arResult["ERROR"] as $error ) {
    if ( stripos($error, 'обязательно для заполнения') ) {
        $errorFields[] = trim(str_ireplace('обязательно для заполнения','',$error));
    }
}
?>

<div class="col-12 col-md-12 col-xl-6">
    <h4 class="checkout-title">Контактные данные</h4>
    <?
    global $USER;
    $rsUser = CUser::GetByID($USER->GetId());
    $arUser = $rsUser->Fetch();

    foreach ($arResult['ORDER_PROP']['USER_PROPS_Y'] as $arProperties) {
        if (!in_array($arProperties['GROUP_NAME'], ['Контактные данные']))
            continue;
        ?>
        <?
        if ($arProperties['TYPE'] == 'FILE') {
            if ($arUser['UF_RECIPE'] > 0) {
                $arr = CFile::GetFileArray($arUser['UF_RECIPE']);
                echo 'Загруженный репепт: <a href="' . $arr['SRC'] . '" target="_blank">' . $arr['ORIGINAL_NAME'] . '</a>';
            }
            ?>
            <div class="recipe">
                <label class="recipe-item">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18"
                         height="19" viewbox="0 0 18 19">
                        <defs>
                            <path id="2pmba" d="M39 197h7.5v8h4l-8 9-7.5-9h4z"></path>
                        </defs>
                        <g>
                            <g transform="translate(-34 -196)">
                                <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linejoin="round"
                                     stroke-miterlimit="50" stroke-width="2" xlink:href="#2pmba"></use>
                            </g>
                        </g>
                    </svg>
                    Загрузить рецепт
                    <input name="<?= $arProperties["FIELD_NAME"] ?>[ID]" value="" type="hidden">
                    <input type="file" id="<?= $arProperties["FIELD_NAME"] ?>" name="<?= $arProperties["FIELD_NAME"] ?>"
                           value="">
                </label>
            </div>
            <br/>
        <? } else if ($arProperties['MULTILINE'] != 'Y') { ?>
            <div class="form-item">
                <input type="text" name="<?= $arProperties["FIELD_NAME"] ?>" id="<?= $arProperties["FIELD_NAME"] ?>"
                       class="input<? if (in_array($arProperties['NAME'], $errorFields))
                           echo ' error'; ?>" placeholder="<?= $arProperties['NAME'] ?>"
                       value="<?= $arProperties["VALUE"] ?>">
            </div>
        <? } else { ?>
            <div class="form-item">
                <textarea name="<?= $arProperties["FIELD_NAME"] ?>" id="<?= $arProperties["FIELD_NAME"] ?>"
                          class="textarea<? if (in_array($arProperties['NAME'], $errorFields))
                              echo ' error'; ?>" placeholder="<?= $arProperties['NAME'] ?>"
                          rows="6"><?= (!empty($arProperties["VALUE"])) ? $arProperties["VALUE"] : $arUser['UF_RECIPE_TEXT'] ?></textarea>
            </div>
        <? } ?>
    <? } ?>
    <? /*<div class="recipe">
        <a href="#" class="recipe-item">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="19" viewbox="0 0 18 19">
                <defs>
                    <path id="2pmba" d="M39 197h7.5v8h4l-8 9-7.5-9h4z"></path>
                </defs>
                <g>
                    <g transform="translate(-34 -196)">
                        <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linejoin="round" stroke-miterlimit="50" stroke-width="2" xlink:href="#2pmba"></use>
                    </g>
                </g>
            </svg>Загрузить рецепт
        </a>
        <a href="#" class="recipe-item">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="19" height="21" viewbox="0 0 19 21">
                <defs>
                    <path id="58mna" d="M209 196c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v17a4 4 0 0 1-4 4h-4z"></path>
                    <path id="58mnb" d="M210 200v-2h6v2z"></path>
                    <path id="58mne" d="M216 212.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 1 1-3 0z"></path>
                    <path id="58mnf" d="M221 212.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 1 1-3 0z"></path>
                    <clippath id="58mnc">
                        <use fill="#fff" xlink:href="#58mna"></use>
                    </clippath>
                    <clippath id="58mnd">
                        <use fill="#fff" xlink:href="#58mnb"></use>
                    </clippath>
                </defs>
                <g>
                    <g transform="rotate(39 385.92 -181.95)">
                        <g>
                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linejoin="round" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#58mnc&quot;)" xlink:href="#58mna"></use>
                        </g>
                        <g>
                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-miterlimit="50" stroke-width="2" clip-path="url(&quot;#58mnd&quot;)" xlink:href="#58mnb"></use>
                        </g>
                    </g>
                    <g transform="translate(-205 -194)">
                        <use fill="#979797" xlink:href="#58mne"></use>
                    </g>
                    <g transform="translate(-205 -194)">
                        <use fill="#979797" xlink:href="#58mnf"></use>
                    </g>
                </g>
            </svg>Ввести вручную
        </a>
    </div>*/ ?>

    <h3>Доставка</h3>

    <?foreach ($arResult['ORDER_PROP']['USER_PROPS_Y'] as $arProperties) {
        if ($arProperties['TYPE'] == 'LOCATION') {?>

        <h4 class="checkout-title mt-30">Город</h4>
        <div class="form-item">
            <?$APPLICATION->IncludeComponent(
                'bitrix:sale.location.selector.search',
                '.default',
                [
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "FILTER_BY_SITE" => "N",
                    "PROVIDE_LINK_BY" => "id",
                    "ID" => $arProperties['VALUE'],
                    "INPUT_NAME" => $arProperties['FIELD_NAME'],
                    "REQUIRED" => $arProperties['REQUIRED'],
                    // "JS_CALLBACK" => "dvsChangeCity",
                ],
                false
            );?>
        </div>
        <?}
    }
    unset($arProperties);
    ?>

    <div class="checkout-delivery">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="19"
             viewbox="0 0 13 19">
            <defs>
                <path id="wysma"
                      d="M26.5 469a6.78 6.78 0 0 1 6.5 7.02c0 3.88-4.59 11.98-6.5 11.98-1.97 0-6.5-8.1-6.5-11.98a6.78 6.78 0 0 1 6.5-7.02zm0 4.13a2.79 2.79 0 0 0-2.67 2.9 2.79 2.79 0 0 0 2.67 2.88 2.79 2.79 0 0 0 2.67-2.89 2.79 2.79 0 0 0-2.67-2.89z"></path>
            </defs>
            <g>
                <g transform="translate(-20 -469)">
                    <use xlink:href="#wysma"></use>
                </g>
            </g>
        </svg>
        <?
        $arProperties = $arResult["ORDER_PROP"]["USER_PROPS_Y"][4];
        //        $CITY_NAME = \Bitrix\Main\Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_NAME');
        //        $CITY_ID = \Bitrix\Main\Context::getCurrent()->getRequest()->getCookie('SELECT_CITY_ID');
        $CITY_NAME = $_SESSION['GEO_IP']['NAME'];
        $CITY_ID = $_SESSION['GEO_IP']['ID'];
        ?>
        <p class="checkout-delivery"><?= $CITY_NAME ?></p><a href="#city-modal" class="checkout-delivery-btn js-city">Изменить
            город</a>
        <input type="hidden" name="<?= $arProperties["FIELD_NAME"] ?>" id="<?= $arProperties["FIELD_NAME"] ?>"
               placeholder="<?= $arProperties['NAME'] ?>" value="<?= $CITY_ID ?>">
        <? if ($arProperties["VALUE"] != $CITY_ID) { ?>
            <script type="text/javascript">submitForm()</script><? } ?>
    </div>

    <h4 class="checkout-title mt-30">Способ доставки</h4>
    <? foreach ($arResult['DELIVERY'] as $delivery) { ?>
        <div class="form-item">
            <label class="checkbox"><?= $delivery['NAME'] ?>
                <input class="radio__input" type="radio" value="<?= $delivery['ID'] ?>"
                       name="DELIVERY_ID"<? if ($delivery['CHECKED'] == 'Y')
                    echo ' checked="checked"'; ?> onchange="submitForm()"/>
                <div class="control__indicator"></div>
            </label>
        </div>
        <? if ($delivery['NAME'] == 'СДЭК (Самовывоз)') { ?>
            <div id="sdev_samovyvoz"></div>
        <? } ?>
    <? } ?>

    <?
    if (!empty($arResult["ORDER_PROP"]["RELATED"])):
        $arProperties = $arResult["ORDER_PROP"]["RELATED"][0];
        ?>
        <div class="form-item">
            <textarea name="<?= $arProperties["FIELD_NAME"] ?>" id="<?= $arProperties["FIELD_NAME"] ?>"
                      class="textarea<? if (in_array($arProperties['NAME'], $errorFields))
                          echo ' error'; ?>" placeholder="<?= $arProperties['NAME'] ?>"
                      rows="6"><?= $arProperties["VALUE"] ?></textarea>
        </div>
    <? endif; ?>

    <h4 class="checkout-title mt-30">Способ оплаты</h4>
    <? foreach ($arResult['PAY_SYSTEM'] as $payment) { ?>
        <div class="form-item">
            <label class="checkbox"><?= $payment['NAME'] ?>
                <input class="radio__input" type="radio" value="<?= $payment['ID'] ?>"
                       name="PAY_SYSTEM_ID"<? if ($payment['CHECKED'] == 'Y')
                    echo ' checked="checked"'; ?> onchange="submitForm()"/>
                <div class="control__indicator"></div>
            </label>
        </div>
    <? } ?>

    <h4 class="checkout-title mt-30">Комментарий к заказу</h4>
    <div class="form-item">
        <textarea name="ORDER_DESCRIPTION" rows="6" placeholder="Ваш комментарий" class="textarea"></textarea>

        <input type="hidden" name="UTM_SOURCE" value="<?php if (isset($_SESSION['utm_source'])) {
            echo $_SESSION['utm_source'];
        } ?>">
        <input type="hidden" name="referer" value="">
        <input type="hidden" name="clientID" value="">
	</div>
    <? /*?><div class="checkout-price">
        <h4 class="checkout-price-total">
            <span class="total">Итого: </span><span><?=number_format($arResult['ORDER_DATA']['PRICE'],0,'',' ')?></span> <span class="currency">₽</span>
        </h4>
    </div><?*/ ?>
    <div class="form-item">
        <button class="submit-btn" onclick="submitForm('Y'); return false;">Оформить заказ</button>
    </div>
    <div class="form-item">
        <label class="checkbox">Согласен на обработку <a href="#">персональных данных</a>, а также с условиями оферты.
            <input type="checkbox" checked="checked">
            <div class="control__indicator"></div>
        </label>
    </div>

</div>
<div class="d-none d-xl-block col-xl-1"></div>
<div class="d-none d-xl-block col">
    <h4 class="checkout-title with-btn">
        <span>Состав заказа</span>
        <a href="<?= $arParams['PATH_TO_BASKET'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="10"
                 viewbox="0 0 15 10">
                <defs>
                    <path id="w7x2a" d="M1434 243h13.5"></path>
                    <path id="w7x2b" d="M1438 247l-4-4 4-4"></path>
                </defs>
                <g>
                    <g transform="translate(-1433 -238)">
                        <g>
                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linecap="round"
                                 stroke-miterlimit="50" xlink:href="#w7x2a"></use>
                        </g>
                        <g>
                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linecap="round"
                                 stroke-miterlimit="50" xlink:href="#w7x2b"></use>
                        </g>
                    </g>
                </g>
            </svg>
            <span>Редактировать</span>
        </a>
    </h4>
    <div class="checkout-cart">
        <div class="checkout-cart-items-container">
            <? foreach ($arResult['BASKET_ITEMS'] as $arItem) {
                $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture($arItem['PRODUCT_ID']);
                ?>
                <div class="checkout-cart-item">
                    <div class="checkout-cart-item-img"><img src="<?= $arItem['PICTURE'] ?>" alt=""></div>
                    <div class="checkout-cart-item-content">
                        <h4 class="checkout-cart-item-title"><?= $arItem['NAME'] ?></h4>
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
            <?
            if (floatval($arResult['ORDER_WEIGHT']) > 0):
                ?>
                <tr>
                    <td class="custom_t1" colspan="<?= $colspan ?>"><?= GetMessage("SOA_SUM_WEIGHT_SUM") ?></td>
                    <td class="custom_t2 price"><?= $arResult["ORDER_WEIGHT_FORMATED"] ?></td>
                </tr>
            <?
            endif;
            ?>
            <tr>
                <td class="custom_t1 itog <?= ($bUseDiscount ? 'with_discount' : '') ?>"
                    colspan="<?= $colspan ?>"><?= GetMessage("SOA_SUM_SUMMARY") ?></td>
                <?
                if ($bUseDiscount) {
                    ?>
                    <td class="custom_t2 price">
                        <?= $arResult["ORDER_PRICE_FORMATED"] ?><br/><span
                                style="text-decoration:line-through; color:#828282;"><?= $arResult["PRICE_WITHOUT_DISCOUNT"] ?></span>
                    </td>
                    <?
                } else {
                    ?>
                    <td class="custom_t2 price"><?= $arResult["ORDER_PRICE_FORMATED"] ?></td>
                    <?
                }
                ?>
            </tr>
            <?
            if (doubleval($arResult["DISCOUNT_PRICE"]) > 0) {
                ?>
                <tr>
                    <td class="custom_t1" colspan="<?= $colspan ?>"><?= GetMessage("SOA_SUM_DISCOUNT") ?><?
                        if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"]) > 0):?> (<?
                            echo $arResult["DISCOUNT_PERCENT_FORMATED"]; ?>)<? endif; ?>:
                    </td>
                    <td class="custom_t2"><?
                        echo $arResult["DISCOUNT_PRICE_FORMATED"] ?></td>
                </tr>
                <?
            }
            if (!empty($arResult["TAX_LIST"])) {
                foreach ($arResult["TAX_LIST"] as $val) {
                    ?>
                    <tr>
                        <td class="custom_t1" colspan="<?= $colspan ?>"
                            class="itog"><?= $val["NAME"] ?> <?= $val["VALUE_FORMATED"] ?>:
                        </td>
                        <td class="custom_t2"><?= $val["VALUE_MONEY_FORMATED"] ?></td>
                    </tr>
                    <?
                }
            }
            if (doubleval($arResult["DELIVERY_PRICE"]) > 0) {
                ?>
                <tr>
                    <td class="custom_t1" colspan="<?= $colspan ?>"><?= GetMessage("SOA_SUM_DELIVERY") ?></td>
                    <td class="custom_t2"><?= $arResult["DELIVERY_PRICE_FORMATED"] ?></td>
                </tr>
                <?
            }

            if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0) {
                ?>
                <tr>
                    <td class="custom_t1" colspan="<?= $colspan ?>" class="itog"><?= GetMessage("SOA_SUM_IT") ?></td>
                    <td class="custom_t2" class="price"><?= $arResult["ORDER_TOTAL_PRICE_FORMATED"] ?></td>
                </tr>
                <tr>
                    <td class="custom_t1" colspan="<?= $colspan ?>" class="itog"><?= GetMessage("SOA_SUM_PAYED") ?></td>
                    <td class="custom_t2" class="price"><?= $arResult["PAYED_FROM_ACCOUNT_FORMATED"] ?></td>
                </tr>
                <tr>
                    <td class="custom_t1 fwb" colspan="<?= $colspan ?>"
                        class="itog"><?= GetMessage("SOA_SUM_LEFT_TO_PAY") ?></td>
                    <td class="custom_t2 fwb" class="price"><?= $arResult["ORDER_TOTAL_LEFT_TO_PAY_FORMATED"] ?></td>
                </tr>
                <?
            } else {
                ?>
                <tr>
                    <td class="custom_t1 fwb" colspan="<?= $colspan ?>"
                        class="itog"><strong><?= GetMessage("SOA_SUM_IT") ?></strong></td>
                    <td class="custom_t2 fwb" class="price">
                        <strong><?= $arResult["ORDER_TOTAL_PRICE_FORMATED"] ?></strong></td>
                </tr>
                <?
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

