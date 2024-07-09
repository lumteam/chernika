<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <nav id="main-menu">
        <ul>
            <?
            foreach($arResult as $i => $arSection):
                if ( $arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1 )
                    continue;
                ?>
                <?if ($arSection['LINK']=='/linzy/'){?>
                    <li>
                        <a href="/linzy/">Линзы для очков</a>
                        <ul style="padding-left: 15px;">
                            <li style="width: 100%;"><a href="/linzy/progressivnye-linzy-dlya-ochkov/">Прогрессивные линзы</a></li>
                            <li style="width: 100%;"><a href="/linzy/ochki-dlya-raboty-za-kompyuterom/">Компьютерные линзы</a><li>
                            <li style="width: 100%;"><a href="/linzy/ofisnye-linzy/">Офисные линзы</a></li>
                            <li style="width: 100%;"><a href="/linzy/fotokhromnye-linzy-khameleony/">Фотохромные линзы</a></li>

                            <li style="width: 100%;"><a href="/linzy/ochkovye-linzy-essilor/">Линзы для очков Essilor</a></li>
                            <li style="width: 100%;"><a href="/linzy/progressivnye-linzy-essilor/">Прогрессивные линзы Essilor</a></li>
                            <li style="width: 100%;"><a href="/linzy/progressivnye-linzy-seiko/">Прогрессивные линзы Seiko</a></li>
                            <li style="width: 100%;"><a href="/linzy/progressivnye-linzy-shamir/">Прогрессивные линзы Shamir</a><li>
                            <li style="width: 100%;"><a href="/linzy/progressivnye-linzy-hoya/">Прогрессивные линзы Hoya</a><li>
                            
                            
                            <li style="width: 100%;"><a href="/linzy-stellest/">Детские линзы Stellest</a></li>
                            <li style="width: 100%;"><a href="/linzy-myopilux/">Детские линзы  Myopilux</a></li>

                            <li style="width: 100%;"><a href="/linzy/">Все очковые линзы</a><li>
                        </ul>       
                    </li>
                    <li><a href="/proverka-zrenija/ ">Бесплатная проверка зрения</a></li>
                <?} else {?>
                    <li>
                        <a href="<?=$arSection['LINK']?>"><?=$arSection['TEXT']?></a>
                        <?if ( !empty($arSection['CHILDS']) || !empty($arSection['PROPERTIES'])){ ?>
                            <ul>
                                <?foreach ( $arSection['CHILDS'] as $key => $item){?>
                                    <li<?if($key==count($arSection['CHILDS'])-1 && $key % 2 == 0){?> class="last-menu-item"<?}?>><a href="<?=$item['SECTION_PAGE_URL']?>"><?=$item['NAME']?></a></li>
                                <? } ?>
                                <? if ($arSection['LINK']=='/eyeglass-frames/'): ?>
                                    <li class="last-menu-item"><a href="/eyeglass-frames/filter/style-is-obodkovie/apply/">Ободковая рамка</a></li>
                                    <li class="last-menu-item"><a href="/eyeglass-frames/filter/style-is-poluobodkovie/apply/">Полуободковая рамка</a></li>
                                    <li class="last-menu-item"><a href="/eyeglass-frames/filter/style-is-bezobodkovie/apply/">Безободковая рамка</a></li>
                                <? endif; ?>
                                <?if($arSection['LINK']=='/eyeglass-frames/' || $arSection['LINK']=='/sunglasses/') {?>
                                    <li style="width: 100%; margin-bottom: 10px;">
                                        <a href="/outlet/" style="color: #7336d7;">Черника Outlet</a>
                                    </li>
                                <?}?>
                                <?
                                foreach ( $arSection['PROPERTIES']['FORMS'] as $item ) {
                                    if ( !empty($item['UF_NOT_SHOW_IN_MENU']) ) continue;
                                ?>
                                    <li>
                                        <a href="<?=$item['URL']?>" class="box">
                                            <?/*<svg class="submenu_type-icon"><use xlink:href="#<? echo $item['UF_XML_ID'] ?>"/></svg>*/?>
                                            <?if(!empty($item['UF_FILE'])){?><img src="<?=CFile::GetPath($item['UF_FILE'])?>" alt="<?=$item['UF_NAME']?>"><?}?><span><?=$item['UF_NAME']?></span>
                                        </a>
                                    </li>
                                <? } ?>
                            </ul>
                        <? } ?>
                    </li>
                <?}?>
            <?endforeach?>
			<li>
                <a href="javascript:void(0);" class="city-btn-mobile" onclick="ESCityShow();">
					<svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="15" width="15" viewbox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<g>
							<g>
								<path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035              c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719              c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
							 </g>
						 </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
					 </svg>
					 <span>Мой город</span>
				</a>
			</li>
            <?=str_replace('&nbsp;',' ', \PDV\Tools::getPhoneHeaderMobile($arParams['CITY_ID']));?>
        </ul>
    </nav>
<?endif?>