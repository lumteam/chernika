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

<div class="navbar-top-menu d-none d-xl-block">
    <ul>
        <?
        foreach ($arResult['SECTIONS'] as $i => $arSection)
        {
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            if ( $arSection['DEPTH_LEVEL'] > 1) continue;
        ?>
            <li<?if( !empty($arSection['CHILDS']) || !empty($arSection['PARAMS'])){?> class="has-megamenu"<?}?>>
                <a href="<?=$arSection['SECTION_PAGE_URL']?>" data-menu-item="<?=$arSection['ID']?>"><?=$arSection['NAME']?></a>
            </li>
        <? } ?>
        <li>
            <a href="/linzy/">Линзы</a>
        </li>
        <li>
            <a href="/brands/">Бренды</a>
        </li>
        <?/*global $USER; if ($USER->IsAdmin()) {?>
        <li>
            <a href="/lenses/">Линзы new</a>
        </li>
        <?}*/?>
        <li>
            <a href="/action/">Акции</a>
        </li>
    </ul>
</div>
