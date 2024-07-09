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

$allCount = count($arResult["ITEMS"]);
$count = ceil($allCount/2);
?>
<? if ($allCount): ?>
<div class="row ">
    <?foreach($arResult["ITEMS"] as $i => $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <?if ( $i%$count == 0 ){?><div class="col-6"><ul class="list__links"><?}?>
            <li id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="list__link"><?=$arItem['NAME']?></a></li>
        <?if ( ($i+1)%$count == 0 ){?></ul></div><? } ?>
    <?endforeach;?>
    <?if ( $allCount%$count != 0 ){?></ul></div><? } ?>
</div>
<? endif; ?>
