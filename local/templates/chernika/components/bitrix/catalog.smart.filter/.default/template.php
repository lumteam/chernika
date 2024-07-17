<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$notShowPriceCode = 'PRISE';
if ( in_array($arParams['CITY_NAME'], ['Москва','Санкт-Петербург']) )
    $notShowPriceCode = 'PRICE';

$delUrl = str_replace('filter/clear/apply/','',$arResult['SEF_DEL_FILTER_URL']);
$arr = explode('?', $delUrl);
$delUrl = $arr[0];
unset($arr);
?>

<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" id="filter-side" class="smartfilter filter-side initializable" data-reset-href='<?=$delUrl?>'>
    <?foreach($arResult["HIDDEN"] as $arItem):?>
        <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="mobile_<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
    <?endforeach;?>
    <ul>
        <?
        //prices
        foreach($arResult["ITEMS"] as $key=>$arItem)
        {
            $key = $arItem["ENCODED_ID"];
            if(isset($arItem["PRICE"])):
                if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                    continue;
                ?>
                <li class="bx_filter_parameters_box_container">
                    <a href="#">Стоимость</a>
                    <div class="cost-range">
                        <label for="from_coast">от</label>
                        <input
                            class="min-price"
                            type="text"
                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                            id="mobile_<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                            size="5"
                            onchange="smartFilter.keyup(this)"
                        />
                        <label for="from_coast">до</label>
                        <input
                            class="max-price"
                            type="text"
                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                            id="mobile_<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                            size="5"
                            onchange="smartFilter.keyup(this)"
                        />
                    </div>
                    <?
                    /*$diff = round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 3, -2);
                    ?>
                    <ul>
                        <?
                        for ( $i=0; $i<3; $i++){
                            $from = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*$i);
                            $to = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*($i+1));
                            if ( $i == 2 && $to != $arItem["VALUES"]["MAX"]["VALUE"] )
                                $to = round($arItem["VALUES"]["MAX"]["VALUE"]);
                            ?>
                            <li>
                                <label class="checkbox">от <?=number_format($from,0,'',' ')?>₽ до <?=number_format($to,0,'',' ')?>₽
                                    <input name="price_range" type="checkbox" class="js-price_range" data-from="<?=$from?>" data-to="<?=$to?>">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                        <? } ?>
                    </ul>*/?>
                </li>
            <?endif;
        }

        //not prices
        $arrLabels = [];
        foreach($arResult["ITEMS"] as $key=>$arItem)
        {
            if ( in_array($arItem['CODE'], array('POPULAR','NEW','SALE') )){
                $arrLabels[] = $arItem;
            }
        }

        if ( !empty($arrLabels) ) {
            ?>
            <li class="opened_default"><span class="transparent-menu-item">Блоки</span>
                <div class="sort-list filter-side__submenu">
                    <?foreach ( $arrLabels as $arItem ){?>
                        <div class="sort-list__item filter-side__item">
                            <?foreach($arItem["VALUES"] as $val => $ar):?>
                                <label data-role="label_mobile_<?=$ar["CONTROL_ID"]?>" class="checkbox bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="mobile_<? echo $ar["CONTROL_ID"] ?>">
                                    <?=$arItem["NAME"]?>
                                    <input
                                        type="checkbox"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="mobile_<? echo $ar["CONTROL_ID"] ?>"
                                        <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                        onclick="smartFilter.click(this)"
                                    />
                                    <div class="control__indicator"></div>
                                </label>
                            <?endforeach;?>
                        </div>
                    <? } ?>
                </div>
            </li>
            <?
        }

        foreach($arResult["ITEMS"] as $key=>$arItem)
        {
            if(
                empty($arItem["VALUES"])
                || isset($arItem["PRICE"])
            )
                continue;

            if (
                $arItem["DISPLAY_TYPE"] == "A"
                && (
                    $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;

            $st = '';
            if ( in_array($arItem['CODE'], array('POPULAR','NEW','SALE',$notShowPriceCode) ))
                $st = ' style="display:none"';
            ?>
                <li class="js-prop_wrap"<?=$st?>>
                    <span><?=$arItem["NAME"]?></span>
                    <div class="filter-side__submenu">
                        <?
                        $arCur = current($arItem["VALUES"]);
                        switch ($arItem["DISPLAY_TYPE"])
                        {
                            case "A"://NUMBERS
                                ?>
                                <div class="cost-range">
                                    <label for="from_coast">от</label>
                                    <input
                                        class="min-price"
                                        type="text"
                                        name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                        id="mobile_<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                        value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                        size="5"
                                        onchange="smartFilter.keyup(this)"
                                    />
                                    <label for="from_coast">до</label>
                                    <input
                                        class="max-price"
                                        type="text"
                                        name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                        id="mobile_<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                        value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                        size="5"
                                        onchange="smartFilter.keyup(this)"
                                    />
                                </div>
                                <?
                                /*$diff = round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 3, -2);
                                ?>
                                <?
                                for ( $i=0; $i<3; $i++){
                                    $from = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*$i);
                                    $to = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*($i+1));
                                    if ( $i == 2 && $to != $arItem["VALUES"]["MAX"]["VALUE"] )
                                        $to = round($arItem["VALUES"]["MAX"]["VALUE"]);
                                    ?>
                                    <div class="filter-side__item">
                                        <label class="checkbox">от <?=number_format($from,0,'',' ')?>₽ до <?=number_format($to,0,'',' ')?>₽
                                            <input name="price_range" type="checkbox" class="js-price_range" data-from="<?=$from?>" data-to="<?=$to?>">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                <? }*/ ?>
                                <?
                                break;
                            case 'G':
                                $arrColor = \PDV\Tools::getHexColors();
                                $i=0;
                                ?>
                                <div class="colors">
                                    <?foreach($arItem["VALUES"] as $val => $ar):?>
                                        <input
                                            style="display: none"
                                            type="checkbox"
                                            name="<?=$ar["CONTROL_NAME"]?>"
                                            id="mobile_<?=$ar["CONTROL_ID"]?>"
                                            value="<?=$ar["HTML_VALUE"]?>"
                                            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                        />
                                        <?
                                        $classSpan = '';
                                        if ( $ar['VALUE'] == 'Белый' )
                                            $classSpan = ' class="white"';

                                        $class = "";
                                        if ($ar["CHECKED"])
                                            $class.= " active";
                                        if ($ar["DISABLED"])
                                            $class.= " disabled";
                                        ?>
                                        <label for="mobile_<?=$ar["CONTROL_ID"]?>" data-role="label_mobile_<?=$ar["CONTROL_ID"]?>" class="colors-item<?if($i==0)echo' first';?> bx_filter_param_label dib<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape("mobile_".$ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');" title="<?=$ar['VALUE']?>">
                                            <?if ( !empty($ar['FILE']['SRC']) ){?>
                                                <span<?=$classSpan?> style="background: url('<?=$ar['FILE']['SRC']?>') no-repeat center center;"></span>
                                            <?}else{?>
                                                <span<?=$classSpan?> style="background-color: #<?=trim($arrColor[ $ar['URL_ID'] ]['UF_RGB'])?>;"></span>
                                            <? } ?>
                                        </label>
                                        <?
                                        $i++;
                                    endforeach;
                                    ?>
                                </div>
                                <?
                                break;
                            default://CHECKBOXES
                                if ( $arItem["NAME"] == 'Бренд' ) {
                                    $countInRow = ceil(count($arItem["VALUES"])/2);
                                    $tempBrand = [];
                                    $j = 0;
                                    foreach ( $arItem["VALUES"] as $item ) {
                                        if ( $j/2 == $countInRow )
                                            $j = 1;
                                        $tempBrand[ $j ] = $item;
                                        $j += 2;
                                    }
                                    $arItem["VALUES"] = [];
                                    for ( $j=0; $j<=count($tempBrand)-1; $j++ ) {
                                        $arItem["VALUES"][] = $tempBrand[$j];
                                    }
                                    unset($tempBrand);
                                }
                            ?>
                                <?foreach($arItem["VALUES"] as $val => $ar):?>
                                    <div class="filter-side__item">
                                        <label data-role="label_mobile_<?=$ar["CONTROL_ID"]?>" class="checkbox bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="mobile_<? echo $ar["CONTROL_ID"] ?>">
                                            <?=$ar["VALUE"];?>
                                            <input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="mobile_<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                onclick="smartFilter.click(this)"
                                            />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                <?endforeach;?>
                            <?
                        }
                        ?>
                    </div>
                </li>
            <?
        }
        ?>
    </ul>
    <div class="bx_filter_button_box" style="display: none">
        <div class="bx_filter_block">
            <div class="bx_filter_parameters_box_container">
                <input class="bx_filter_search_button" type="submit" id="mobile_set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
                <input class="bx_filter_search_reset" type="submit" id="mobile_del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />

                <div class="bx_filter_popup_result <?=$arParams["POPUP_POSITION"]?>" id="mobile_modef" style="display: inline-block;">
                    <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="mobile_modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                    <span class="arrow"></span>
                    <a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="aside-filter bx_filter aside-filter">
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
        <?foreach($arResult["HIDDEN"] as $arItem):?>
            <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
        <?endforeach;
        //prices
        foreach($arResult["ITEMS"] as $key=>$arItem)
        {
            $key = $arItem["ENCODED_ID"];
            if(isset($arItem["PRICE"])):
                if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                    continue;
                ?>
                <div class="aside-filter-item bx_filter_parameters_box js-prop_wrap">
                    <span class="bx_filter_container_modef"></span>
                    <div class="aside-filter-item-title">Стоимость</div>
                    <div class="bx_filter_block">
                        <div class="bx_filter_parameters_box_container">
                            <div class="cost-range">
                                <label for="from_coast">от</label>
                                <input
                                    class="min-price"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    size="5"
                                    onchange="smartFilter.keyup(this)"
                                />
                                <label for="from_coast">до</label>
                                <input
                                    class="max-price"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    size="5"
                                    onchange="smartFilter.keyup(this)"
                                />
                            </div>
                            <?
                            /*$diff = round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 3, -2);
                            ?>
                            <ul>
                                <?
                                for ( $i=0; $i<3; $i++){
                                    $from = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*$i);
                                    $to = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*($i+1));
                                    if ( $i == 2 && $to != $arItem["VALUES"]["MAX"]["VALUE"] )
                                        $to = round($arItem["VALUES"]["MAX"]["VALUE"]);
                                ?>
                                    <li>
                                        <label class="checkbox">от <?=number_format($from,0,'',' ')?>₽ до <?=number_format($to,0,'',' ')?>₽
                                            <input name="price_range" type="checkbox" class="js-price_range" data-from="<?=$from?>" data-to="<?=$to?>">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </li>
                                <? } ?>
                            </ul>*/?>
                        </div>
                    </div>
                </div>
            <?endif;
        }


        //not prices
        foreach($arResult["ITEMS"] as $key=>$arItem)
        {
            if(
                empty($arItem["VALUES"])
                || isset($arItem["PRICE"])
            )
                continue;


            if (
                $arItem["DISPLAY_TYPE"] == "A"
                && (
                    $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;

            $st = '';
            if ( in_array($arItem['CODE'], array('POPULAR','NEW','SALE',$notShowPriceCode) ))
                $st = ' style="display:none"';
            ?>
            <div class="aside-filter-item bx_filter_parameters_box js-prop_wrap key-<?=$key?> "<?=$st?>>
                <span class="bx_filter_container_modef"></span>
                <div class="aside-filter-item-title"><?=$arItem["NAME"]?></div>



                <div class="bx_filter_block">
                    <div class="bx_filter_parameters_box_container">

                    <?
                    //поле для фильтрации брендов по названию
                    if(145 === $key) { ?>
                        <div>
                            <input type="text" class="" id="brandFilter" placeholder="Введите название бренда" />
                        </div>
                        <?
                    }
                    ?>

                    <?
                    $arCur = current($arItem["VALUES"]);
                    switch ($arItem["DISPLAY_TYPE"])
                    {
                        case "A"://NUMBERS
                            ?>
                            <div class="cost-range">
                                <label for="from_coast">от</label>
                                <input
                                    class="min-price"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    size="5"
                                    onchange="smartFilter.keyup(this)"
                                />
                                <label for="from_coast">до</label>
                                <input
                                    class="max-price"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    size="5"
                                    onchange="smartFilter.keyup(this)"
                                />
                            </div>
                            <?
                            /*$diff = round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 3, -2);
                            ?>
                            <ul>
                                <?
                                for ( $i=0; $i<3; $i++){
                                    $from = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*$i);
                                    $to = round($arItem["VALUES"]["MIN"]["VALUE"]+$diff*($i+1));
                                    if ( $i == 2 && $to != $arItem["VALUES"]["MAX"]["VALUE"] )
                                        $to = round($arItem["VALUES"]["MAX"]["VALUE"]);
                                    ?>
                                    <li>
                                        <label class="checkbox">от <?=number_format($from,0,'',' ')?>₽ до <?=number_format($to,0,'',' ')?>₽
                                            <input name="price_range" type="checkbox" class="js-price_range" data-from="<?=$from?>" data-to="<?=$to?>">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </li>
                                <? } ?>
                            </ul>
                            <?*/
                            break;
                        case 'G':
                            $arrColor = \PDV\Tools::getHexColors();
                            $i=0;
                            ?>
                            <ul class="colors">
                                <?foreach($arItem["VALUES"] as $val => $ar):?>
                                    <input
                                        style="display: none"
                                        type="checkbox"
                                        name="<?=$ar["CONTROL_NAME"]?>"
                                        id="<?=$ar["CONTROL_ID"]?>"
                                        value="<?=$ar["HTML_VALUE"]?>"
                                        <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                    />
                                    <?
                                    $classSpan = '';
                                    if ( $ar['VALUE'] == 'Белый' )
                                        $classSpan = ' class="white"';

                                    $class = "";
                                    if ($ar["CHECKED"])
                                        $class .= " active";
                                    if ($ar["DISABLED"])
                                        $class .= " disabled";
                                    ?>
                                    <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="colors-item<?if($i==0)echo' first';?> bx_filter_param_label dib<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');" title="<?=$ar['VALUE']?>">
                                        <?if ( !empty($ar['FILE']['SRC']) ){?>
                                            <span<?=$classSpan?> style="background: url('<?=$ar['FILE']['SRC']?>') no-repeat center center;"></span>
                                        <?}else{?>
                                            <span<?=$classSpan?> style="background-color: #<?=$arrColor[ $ar['URL_ID'] ]['UF_RGB']?>;"></span>
                                        <? } ?>
                                    </label>
                                <?
                                $i++;
                                endforeach;
                            ?>
                            </ul>
                        <?
                            break;
                        default://CHECKBOXES
                            ?>
                            <ul<?if(count($arItem["VALUES"])>6){?> class="long"<?}?>>
                                <?foreach($arItem["VALUES"] as $val => $ar):?>
                                    <li>
                                        <label data-role="label_<?=$ar["CONTROL_ID"]?>" class="checkbox bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
                                            <?=$ar["VALUE"];?>
                                            <input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                    onclick="smartFilter.click(this)"
                                            />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </li>
                                <?endforeach;?>
                            </ul>
                    <?
                    }
                    ?>
                    </div>

                    <?
                    //кнопки "показать все" и "свернуть".
                    if(145 === $key) { ?>
                        <div id="expandButton" class="toggle-button more-link">
                            Все
                        </div>
                        <div id="collapseButton" class="toggle-button more-link more-link-seo open" style="display: none;">
                            Свернуть
                        </div>
                        <?
                    }
                    ?>

                    <div class="clb"></div>


                </div>
            </div>
        <?
        }
        ?>

        <div class="bx_filter_button_box" style="display: none">
            <div class="bx_filter_block">
                <div class="bx_filter_parameters_box_container">
                    <input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
                    <input class="bx_filter_search_reset" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />

                    <div class="bx_filter_popup_result <?=$arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
                        <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                        <span class="arrow"></span>
                        <a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var smartFilterSettings = {
        'formAction': '<?=CUtil::JSEscape($arResult["FORM_ACTION"])?>',
        'filterViewMode': '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>',
        'jsFilterParams': <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>
    };
</script>
<script>
	//var smartFilter = new JCSmartFilter('<?//echo CUtil::JSEscape($arResult["FORM_ACTION"])?>//', 'vertical');
</script>