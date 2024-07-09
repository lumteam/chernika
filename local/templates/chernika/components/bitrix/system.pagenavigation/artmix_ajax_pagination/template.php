<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

if (!$arResult['NavShowAlways']) {
    if ($arResult['NavRecordCount'] == 0 || ($arResult['NavPageCount'] == 1 && $arResult['NavShowAll'] == false)) {
        return;
    }
}

$strNavQueryString = ($arResult['NavQueryString'] != '' ? $arResult['NavQueryString'] . '&amp;' : '');

$strNavQueryStringFull = ($arResult['NavQueryString'] != '' ? '?' . $arResult['NavQueryString'] : ''); 

?>
<div class="col-12 ax-pagination js-ax-ajax-pagination-container ax-grey">
    <div class="ax-pagination-container">

        <?php if ($arResult['NavPageNomer'] < $arResult['NavPageCount']) { ?>
            <a class="ax-show-more-pagination js-ax-show-more-pagination" rel="nofollow"
               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] + 1) ?>">
                <span class="btn-default"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_SHOW_MORE') ?></span>
            </a>
        <?php } elseif ($arResult['NavPageNomer'] == $arResult['NavPageCount']) { ?>
            <span class="ax-show-more-pagination js-ax-show-more-pagination last-page" rel="nofollow">
                <span class="ax-no-more"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_SHOW_NO_MORE') ?></span>
            </span>
        <?php } ?>

        <ul class="ax-pagination-ul">
            <?php if ($arResult['bDescPageNumbering'] === true) { ?>

                <?php if ($arResult['NavPageNomer'] < $arResult['NavPageCount']) { ?>
                    <?php if ($arResult['bSavePage']) { ?>
                        <li class="ax-pagination-li ax-pag-prev">
                            <a class="ax-pagination-link" href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] + 1) ?>">
                                <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span>
                            </a>
                        </li>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link" href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] + 1) ?>">
                                <span class="ax-pagination-span">1</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <?php if (($arResult['NavPageNomer'] + 1) == $arResult['NavPageCount']) { ?>
                            <li class="ax-pagination-li ax-pag-prev">
                                <a class="ax-pagination-link js-ax-pager-link" href="<?php echo $arResult['sUrlPath'] ?><?php echo $strNavQueryStringFull ?>">
                                    <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="ax-pagination-li ax-pag-prev">
                                <a class="ax-pagination-link js-ax-pager-link"
                                   href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] + 1) ?>">
                                    <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?><?php echo $strNavQueryStringFull ?>">
                                <span class="ax-pagination-span">1</span>
                            </a>
                        </li>
                    <?php } ?>
                <?php } else { ?>
                    <li class="ax-pagination-li ax-pag-prev"><span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span></li>
                    <li class="ax-pagination-li ax-active"><span class="ax-pagination-span">1</span></li>
                <?php } ?>

                <?php
                $arResult['nStartPage']--;

                while ($arResult['nStartPage'] >= $arResult['nEndPage'] + 1) {
                    $NavRecordGroupPrint = $arResult['NavPageCount'] - $arResult['nStartPage'] + 1;
                    
                    if ($arResult['nStartPage'] == $arResult['NavPageNomer']) { ?>
                        <li class="ax-pagination-li ax-active"><span class="ax-pagination-span"><?php echo $NavRecordGroupPrint ?></span></li>
                    <?php } else { ?>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo $arResult['nStartPage'] ?>">
                                <span class="ax-pagination-span"><?php echo $NavRecordGroupPrint ?></span></a>
                        </li>
                    <?php } ?>
                    <?php $arResult['nStartPage']-- ?>
                <?php } ?>

                <?php if ($arResult['NavPageNomer'] > 1) { ?>
                    <?php if ($arResult['NavPageCount'] > 1) { ?>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=1">
                                <span class="ax-pagination-span"><?php echo $arResult['NavPageCount'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="ax-pagination-li ax-pag-next">
                        <a class="ax-pagination-link js-ax-pager-link"
                           href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] - 1) ?>">
                            <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_FORWARD') ?></span>
                        </a>
                    </li>
                <?php } else { ?>
                    <?php if ($arResult['NavPageCount'] > 1) { ?>
                        <li class="ax-pagination-li ax-active"><span class="ax-pagination-span"><?php echo $arResult['NavPageCount'] ?></span></li>
                    <?php } ?>
                    <li class="ax-pagination-li ax-pag-next"><span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_FORWARD') ?></span></li>
                <?php } ?>

            <?php } else { ?>

                <?php if ($arResult['NavPageNomer'] > 1) { ?>
                    <?php if ($arResult['bSavePage']) { ?>
                        <li class="ax-pagination-li ax-pag-prev">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] - 1) ?>">
                                <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span>
                            </a>
                        </li>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=1">
                                <span class="ax-pagination-span">1</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <?php if ($arResult['NavPageNomer'] > 2) { ?>
                            <li class="ax-pagination-li ax-pag-prev">
                                <a class="ax-pagination-link js-ax-pager-link"
                                   href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] - 1) ?>">
                                    <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="ax-pagination-li ax-pag-prev">
                                <a class="ax-pagination-link js-ax-pager-link"
                                   href="<?php echo $arResult['sUrlPath'] ?><?php echo $strNavQueryStringFull ?>">
                                    <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?><?php echo $strNavQueryStringFull ?>">
                                <span class="ax-pagination-span">1</span>
                            </a>
                        </li>
                    <?php } ?>
                <?php } else { ?>
                    <li class="ax-pagination-li ax-pag-prev"><span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_BACK') ?></span></li>
                    <li class="ax-pagination-li ax-active"><span class="ax-pagination-span">1</span></li>
                <?php } ?>

                <?php
                $arResult['nStartPage']++;

                while ($arResult['nStartPage'] <= $arResult['nEndPage'] - 1) {
                    if ($arResult['nStartPage'] == $arResult['NavPageNomer']) { ?>
                        <li class="ax-pagination-li ax-active">
                            <span class="ax-pagination-span"><?php echo $arResult['nStartPage'] ?></span>
                        </li>
                    <?php } else { ?>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo $arResult['nStartPage'] ?>">
                                <span class="ax-pagination-span"><?php echo $arResult['nStartPage'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php $arResult['nStartPage']++ ?>
                <?php } ?>

                <?php if ($arResult['NavPageNomer'] < $arResult['NavPageCount']) { ?>
                    <?php if ($arResult['NavPageCount'] > 1) { ?>
                        <li class="ax-pagination-li">
                            <a class="ax-pagination-link js-ax-pager-link"
                               href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo $arResult['NavPageCount'] ?>">
                                <span class="ax-pagination-span"><?php echo $arResult['NavPageCount'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="ax-pagination-li ax-pag-next">
                        <a class="ax-pagination-link js-ax-pager-link"
                           href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>PAGEN_<?php echo $arResult['NavNum'] ?>=<?php echo ($arResult['NavPageNomer'] + 1) ?>">
                            <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_FORWARD') ?></span>
                        </a>
                    </li>
                <?php } else { ?>
                    <?php if ($arResult['NavPageCount'] > 1) { ?>
                        <li class="ax-pagination-li ax-active">
                            <span class="ax-pagination-span"><?php echo $arResult['NavPageCount'] ?></span>
                        </li>
                    <?php } ?>
                    <li class="ax-pagination-li ax-pag-next">
                        <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_FORWARD') ?></span>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if ($arResult['bShowAll']) { ?>
                <?php if ($arResult['NavShowAll']) { ?>
                    <li class="ax-pagination-li ax-pag-all">
                        <a class="ax-pagination-link js-ax-pager-link"
                           rel="nofollow"
                           href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>SHOWALL_<?php echo $arResult['NavNum'] ?>=0">
                                <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_PAGES') ?></span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="ax-pagination-li ax-pag-all">
                        <a class="ax-pagination-link js-ax-pager-link"
                           rel="nofollow"
                           href="<?php echo $arResult['sUrlPath'] ?>?<?php echo $strNavQueryString ?>SHOWALL_<?php echo $arResult['NavNum'] ?>=1">
                            <span class="ax-pagination-span"><?php echo Loc::getMessage('ARTMIX_AJAXPAGINATION_ALL') ?></span>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div style="clear:both"></div>
    </div>
</div>
