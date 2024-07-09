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
?>


<?  if (CSite::InDir('/index.php') && !$arParams['IS_MOBILE']) { $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "indextags_inc",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "AREA_FILE_RECURSIVE" => "Y"
                            ),
                            false);
}?>
<div class="header-slider-wrapper">
    <div class="header-slider-arrows">
        <div class="container">
            <button type="button" class="header-slider-prev">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                    <defs>
                        <path id="h8nqa" d="M344.66 389l1.34-1.32-8.75-8.68 8.75-8.68-1.34-1.32-9.66 10z"></path>
                    </defs>
                    <g>
                        <g transform="translate(-335 -369)">
                            <use fill="#fff" xlink:href="#h8nqa"></use>
                        </g>
                    </g>
                </svg>
            </button>
            <button type="button" class="header-slider-next">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="20" viewbox="0 0 11 20">
                    <defs>
                        <path id="9u38a" d="M1575.34 389l-1.34-1.32 8.75-8.68-8.75-8.68 1.34-1.32 9.66 10z"></path>
                    </defs>
                    <g>
                        <g transform="translate(-1574 -369)">
                            <use fill="#fff" xlink:href="#9u38a"></use>
                        </g>
                    </g>
                </svg>
            </button>
        </div>
    </div>
    <div class="header-slider">
        <?foreach($arResult["ITEMS"] as $i => $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="header-slider-item header-slider-item_empty" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <? if (!$arParams['IS_MOBILE']) { ?>
                    <div data-bg="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>"
                         class="header-slider-item_big lazyload"></div>
                <? } else { ?>
                    <div data-bg="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                         class="header-slider-item_small lazyload"></div>
                <? } ?>
                <a href="<?=$arItem['CODE']?>" class="header-slider__link"></a>
            </div>
        <?endforeach;?>
    </div>
</div>
<? if (CSite::InDir('/index.php') && $arParams['IS_MOBILE']) { $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "indextags_inc",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "AREA_FILE_RECURSIVE" => "Y"
                            ),
                            false);
}?>