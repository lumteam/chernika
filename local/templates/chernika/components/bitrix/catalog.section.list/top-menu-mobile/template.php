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

<nav id="main-menu">
    <ul>
    <?
    foreach ($arResult['SECTIONS'] as $i => $arSection)
    {
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    ?>
        <li>
            <a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
            <?if ( !empty($arSection['CHILDS']) || !empty($arSection['PARAMS'])){ ?>
                <ul>
                    <?foreach ( $arSection['CHILDS'] as $item){?>
                        <li><a href="<?=$item['SECTION_PAGE_URL']?>"><?=$item['NAME']?></a></li>
                    <? } ?>
                    <?foreach ( $arSection['PARAMS']['FORMS'] as $item){?>
                        <li>
                            <a href="<?=$item['URL']?>" class="box">
                                <?if(!empty($item['UF_FILE'])){?><img src="<?=CFile::GetPath($item['UF_FILE'])?>" alt="<?=$item['UF_NAME']?>"><?}?><?=$item['UF_NAME']?>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            <? } ?>
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
</nav>