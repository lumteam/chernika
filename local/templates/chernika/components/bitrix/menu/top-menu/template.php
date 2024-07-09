<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <div class="navbar-top-menu d-none d-xl-block">
        <ul>
        <?
        foreach($arResult as $i => $arItem):
            if ( $arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1 )
                continue;
        ?>
            <li<?if ( !empty($arItem['PARAMS']['SECTION_ID']) || $arItem['LINK']=='/linzy/'){?> class="has-megamenu"<?}?>>
                <a href="<?=$arItem['LINK']?>" data-menu-item="<?=$i?>"><?=$arItem['TEXT']?></a>
            </li>
        <?endforeach?>

        </ul>
    </div>
<?endif?>