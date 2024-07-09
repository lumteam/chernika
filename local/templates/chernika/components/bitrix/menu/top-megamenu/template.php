<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
foreach( $arResult as $i => $arSection ):

    if ( empty($arSection['PARAMS']['SECTION_ID']) && $arSection['LINK'] != '/linzy/' )
        continue;
    ?>
    <?if ( !empty($arSection['CHILDS']) || !empty($arSection['PROPERTIES']) || $arSection['LINK']=='/linzy/' ){?>
        <div id="megamenu_<?=$i?>" class="navbar-top-megamenu">
            <div class="container">
                <div class="row">
                    <?if ($arSection['LINK']=='/linzy/'):?>
                        <div class="col-xl-4">
                            <div class="navbar-top-megamenu-submenu">
                                <div class="h3">По типу</div>
                                <ul class="brands__scroll">
                                    <li><a href="/linzy/progressivnye-linzy-dlya-ochkov/">Прогрессивные линзы</a></li>
                                     <li><a href="/linzy/ochki-dlya-raboty-za-kompyuterom/">Компьютерные линзы</a><li>
                                    <li><a href="/linzy/ofisnye-linzy/">Офисные линзы</a></li>
                                    <li><a href="/linzy/multifokusnye-linzy/">Мультифокусные линзы</a></li>
                                    <li><a href="/linzy/fotokhromnye-linzy-khameleony/">Фотохромные линзы</a></li>
                                    <li><a href="/proverka-zrenija/">Бесплатная проверка зрения</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="navbar-top-megamenu-submenu">
                                <div class="h3">По брендам</div>
                                <ul class="brands__scroll">
                                    <li><a href="/linzy/ochkovye-linzy-essilor/">Линзы для очков Essilor</a></li>
                                    <li><a href="/linzy/linzy-zeiss/">Линзы для очков ZEISS</a></li>
                                    <li><a href="/linzy/progressivnye-linzy-essilor/">Прогрессивные линзы Essilor</a></li>
                                    <li><a href="/linzy/progressivnye-linzy-seiko/">Прогрессивные линзы Seiko</a></li>
                                    <li><a href="/linzy/progressivnye-linzy-shamir/">Прогрессивные линзы Shamir</a><li>
                                     <li><a href="/linzy/progressivnye-linzy-hoya/">Прогрессивные линзы Hoya</a><li>
                                    <li><a href="/linzy/">Все очковые линзы</a><li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="navbar-top-megamenu-submenu">
                                <div class="h3">Детские линзы</div>
                                <ul class="brands__scroll">
                                    <li><a href="/linzy-stellest/">Детские линзы Stellest</a></li>
                                    <li><a href="/linzy-myopilux/">Детские линзы Myopilux</a></li>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>
                    
                    <?if (!empty($arSection['CHILDS']) ):?>
                        <div class="col-xl-2">
                            <div class="navbar-top-megamenu-submenu">
                                <div class="h3">По типу</div>
                                <ul class="brands__scroll">
                                    <?foreach ( $arSection['CHILDS'] as $item){?>
                                        <li><a href="<?=$item['SECTION_PAGE_URL']?>"><?=$item['NAME']?></a></li>
                                    <? } ?>
                                </ul>
                                <? if ($arSection['LINK']=='/eyeglass-frames/'): ?>
                                    <div class="h3">По типу рамки</div>
                                    <ul class="brands__scroll">
                                        <li><a href="/eyeglass-frames/filter/style-is-obodkovie/apply/">Ободковая</a></li>
                                        <li><a href="/eyeglass-frames/filter/style-is-poluobodkovie/apply/">Полуободковая</a></li>
                                        <li><a href="/eyeglass-frames/filter/style-is-bezobodkovie/apply/">Безободковая</a></li>
                                    </ul>
                                <? endif; ?>
                                <?if($arSection['LINK']=='/eyeglass-frames/' || $arSection['LINK']=='/sunglasses/') {?>
                                    <ul style="margin-top: 10px;">
                                        <li>
                                            <a href="/outlet/" style="color: #7336d7;">Черника Outlet</a>
                                        </li>
                                    </ul>
                                <?}?>
                            </div>
                        </div>
                    <?endif;?>

                    <?if (!empty($arSection['PROPERTIES']['BRANDS']) ):?>
                        <div class="col-xl-6">
                            <div class="navbar-top-megamenu-submenu" style="max-height: 532px; overflow: hidden;">
                                <div class="h3">Популярные бренды</div>
                                <ul class="with-brands">
                                    <?
                                    foreach ( $arSection['PROPERTIES']['BRANDS'] as $item ) {
                                        if ( !empty($item['PROPERTY_NOT_SHOW_IN_MENU_VALUE']) ) continue;
                                    ?>
                                        <li><a href="<?=$item['URL']?>"><?=$item['NAME']?></a></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>

                    <?if (!empty($arSection['PROPERTIES']['FORMS']) ):?>
                        <div class="col-xl-4">
                            <div class="navbar-top-megamenu-submenu">
                                <div class="h3">По форме</div>
                                <ul class="with-boxes">
                                    <?
                                    foreach ( $arSection['PROPERTIES']['FORMS'] as $item ) {
                                        if ( !empty($item['UF_NOT_SHOW_IN_MENU']) ) continue;
                                    ?>
                                        <li>
                                            <a href="<?=$item['URL']?>">
                                                <?/*<svg class="submenu_type-icon"><use xlink:href="#<? echo $item['UF_XML_ID'] ?>"/></svg>*/?>
                                                <?if(!empty($item['UF_FILE'])){?><img src="<?=CFile::GetPath($item['UF_FILE'])?>" alt="<?=$item['UF_NAME']?>"><?}?><?=$item['UF_NAME']?>
                                            </a>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>

                    <?if (!empty($arSection['PROPERTIES']['LENSES_FEATURES']) ):?>
                        <div class="col-xl-4">
                            <div class="navbar-top-megamenu-submenu">
                                <div class="h3">Особенности</div>
                                <ul class="lenses-features">
                                    <?
                                    foreach ( $arSection['PROPERTIES']['LENSES_FEATURES'] as $item ) {
                                        if ( !empty($item['UF_NOT_SHOW_IN_MENU']) ) continue;
                                    ?>
                                        <li><a href="<?=$item['URL']?>"><?=$item['NAME']?></a></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    <? } ?>
<?endforeach?>