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

<?
foreach ($arResult['SECTIONS'] as $i => $arSection)
{
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
?>
    <?if ( !empty($arSection['CHILDS']) || !empty($arSection['PARAMS'])  ){?>
        <div id="megamenu_<?=$i?>" class="navbar-top-megamenu">
            <div class="container">
                <div class="row">
                    <?if (!empty($arSection['CHILDS']) ):?>
                        <div class="col-xl-2">
                            <div class="navbar-top-megamenu-submenu">
                                <h3>По типу</h3>
                                <ul class="brands__scroll">
                                    <?foreach ( $arSection['CHILDS'] as $item){?>
                                        <li><a href="<?=$item['SECTION_PAGE_URL']?>"><?=$item['NAME']?></a></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>

                    <?if (!empty($arSection['PARAMS']['BRANDS']) ):?>
                        <div class="col-xl-6">
                            <div class="navbar-top-megamenu-submenu">
                                <h3>По брэнду</h3>
                                <ul class="with-brands">
                                    <?foreach ( $arSection['PARAMS']['BRANDS'] as $item){?>
                                        <li><a href="<?=$item['URL']?>"><?=$item['NAME']?></a></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>

                    <?if (!empty($arSection['PARAMS']['FORMS']) ):?>
                        <div class="col-xl-4">
                            <div class="navbar-top-megamenu-submenu">
                                <h3>По форме</h3>
                                <ul class="with-boxes">
                                    <?foreach ( $arSection['PARAMS']['FORMS'] as $item){?>
                                        <li>
                                            <a href="<?=$item['URL']?>">
                                                <?if(!empty($item['UF_FILE'])){?><img src="<?=CFile::GetPath($item['UF_FILE'])?>" alt="<?=$item['UF_NAME']?>"><?}?><?=$item['UF_NAME']?>
                                            </a>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>
