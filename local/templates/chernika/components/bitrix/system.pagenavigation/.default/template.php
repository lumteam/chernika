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

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
$nextUrl = '';
?>

<div class="row d-xl-flex">
    <div class="col">
        <div class="pagination">
            <ul>
            <?if($arResult["bDescPageNumbering"] === true):?>

    <?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
        <?if($arResult["bSavePage"]):?>
            <li class="prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
                <defs>
                    <path id="aluaa" d="M790 3739v-1h70v1z"></path>
                    <path id="aluab" d="M855.5 3743.5l4.5-5-4.5-5"></path>
                </defs>
                <g>
                    <g transform="matrix(-1 0 0 1 861 -3733)">
                        <g>
                            <use fill="#696969" xlink:href="#aluaa"></use>
                        </g>
                        <g>
                            <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#aluab"></use>
                        </g>
                    </g>
                </g>
            </svg></a></li>
        <?else:?>
            <?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
                <li class="prev"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
                    <defs>
                        <path id="aluaa" d="M790 3739v-1h70v1z"></path>
                        <path id="aluab" d="M855.5 3743.5l4.5-5-4.5-5"></path>
                    </defs>
                    <g>
                        <g transform="matrix(-1 0 0 1 861 -3733)">
                            <g>
                                <use fill="#696969" xlink:href="#aluaa"></use>
                            </g>
                            <g>
                                <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#aluab"></use>
                            </g>
                        </g>
                    </g>
                </svg></a></li>
            <?else:?>
                <li class="prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
                    <defs>
                        <path id="aluaa" d="M790 3739v-1h70v1z"></path>
                        <path id="aluab" d="M855.5 3743.5l4.5-5-4.5-5"></path>
                    </defs>
                    <g>
                        <g transform="matrix(-1 0 0 1 861 -3733)">
                            <g>
                                <use fill="#696969" xlink:href="#aluaa"></use>
                            </g>
                            <g>
                                <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#aluab"></use>
                            </g>
                        </g>
                    </g>
                </svg></a></li>
            <?endif?>
        <?endif?>
    <?endif?>

    <?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
        <?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

        <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
            <li class="active"><a href="#"><?=$NavRecordGroupPrint?></a> </li>
        <?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
            <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a></li>
        <?else:?>
            <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a></li>
        <?endif?>

        <?$arResult["nStartPage"]--?>
    <?endwhile?>

    <?
    if ($arResult["NavPageNomer"] > 1):
        $nextUrl = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1);
    ?>
        <li class="next"><a href="<?=$nextUrl?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
            <defs>
                <path id="i5b5a" d="M1383 3739v-1h70v1z"></path>
                <path id="i5b5b" d="M1448.5 3743.5l4.5-5-4.5-5"></path>
            </defs>
            <g>
                <g transform="translate(-1383 -3733)">
                    <g>
                        <use fill="#696969" xlink:href="#i5b5a"></use>
                    </g>
                    <g>
                        <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#i5b5b"></use>
                    </g>
                </g>
            </g>
        </svg></a></li>
    <?endif?>

<?else:?>

    <?if ($arResult["NavPageNomer"] > 1):?>

        <?if($arResult["bSavePage"]):?>
            <li class="prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
                <defs>
                    <path id="aluaa" d="M790 3739v-1h70v1z"></path>
                    <path id="aluab" d="M855.5 3743.5l4.5-5-4.5-5"></path>
                </defs>
                <g>
                    <g transform="matrix(-1 0 0 1 861 -3733)">
                        <g>
                            <use fill="#696969" xlink:href="#aluaa"></use>
                        </g>
                        <g>
                            <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#aluab"></use>
                        </g>
                    </g>
                </g>
            </svg></a></li>
        <?else:?>
            <?if ($arResult["NavPageNomer"] > 2):?>
                <li class="prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
                    <defs>
                        <path id="aluaa" d="M790 3739v-1h70v1z"></path>
                        <path id="aluab" d="M855.5 3743.5l4.5-5-4.5-5"></path>
                    </defs>
                    <g>
                        <g transform="matrix(-1 0 0 1 861 -3733)">
                            <g>
                                <use fill="#696969" xlink:href="#aluaa"></use>
                            </g>
                            <g>
                                <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#aluab"></use>
                            </g>
                        </g>
                    </g>
                </svg></a></li>
            <?else:?>
                <li class="prev"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
                    <defs>
                        <path id="aluaa" d="M790 3739v-1h70v1z"></path>
                        <path id="aluab" d="M855.5 3743.5l4.5-5-4.5-5"></path>
                    </defs>
                    <g>
                        <g transform="matrix(-1 0 0 1 861 -3733)">
                            <g>
                                <use fill="#696969" xlink:href="#aluaa"></use>
                            </g>
                            <g>
                                <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#aluab"></use>
                            </g>
                        </g>
                    </g>
                </svg></a></li>
            <?endif?>
        <?endif?>
    <?endif?>

    <?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

        <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
            <li class="active"><a href="#"><?=$arResult["nStartPage"]?></a> </li>
        <?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
            <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>
        <?else:?>
            <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
        <?endif?>
        <?$arResult["nStartPage"]++?>
    <?endwhile?>

    <?
    if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
        $nextUrl = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
    ?>
        <li class="next"><a href="<?=$nextUrl?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="71" height="11" viewBox="0 0 71 11">
            <defs>
                <path id="i5b5a" d="M1383 3739v-1h70v1z"></path>
                <path id="i5b5b" d="M1448.5 3743.5l4.5-5-4.5-5"></path>
            </defs>
            <g>
                <g transform="translate(-1383 -3733)">
                    <g>
                        <use fill="#696969" xlink:href="#i5b5a"></use>
                    </g>
                    <g>
                        <use fill="#fff" fill-opacity="0" stroke="#696969" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#i5b5b"></use>
                    </g>
                </g>
            </g>
        </svg></a></li>
    <?endif?>

<?endif?>
            </ul>
        </div>
    </div>
</div>
