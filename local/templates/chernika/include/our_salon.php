<div class="navbar-xl-top_left">
    <div class="city-adresses">
        <?foreach ( $arrSaloon as $item ){?>
            <div class="city-adresses-column"
			<? if (count($arrSaloon) === 1): ?> style="width:100%;"<? endif; ?>
			>
		<? if (!empty($item['PROPERTY_DOPTEXT_VALUE'])) { ?>
		<div class="row">
			<div class="col-md-6">
		<? } ?>
				<p><strong><?=$item['NAME']?></strong><? if (!empty($item['PROPERTY_COMMENT_VALUE'])) { ?><br/><span style="font-weight: 400;"><?= $item['PROPERTY_COMMENT_VALUE'] ?></span><? } ?></p>
		                <p class="metro">
		                    <?if ( !empty($item['PROPERTY_ICON_VALUE']) ){?>
		                        <img src="<?=CFile::GetPath($item['PROPERTY_ICON_VALUE'])?>" alt="">
		                    <?} else {?>
		                        <?=htmlspecialchars_decode($item['DETAIL_TEXT'])?>
		                    <? } ?>
		                    <span>&nbsp;<?= $item['PROPERTY_METRO_VALUE'] ?></span>
		                </p>
		                <div class="adress"><?=$item['PREVIEW_TEXT']?></div>
		                <?if ( !empty($item['PROPERTY_MAP_VALUE']) ){?>
		                    <?/*?><a href="#" class="on-map js-openmap" data-coord="<?= $item['PROPERTY_MAP_VALUE'] ?>"
		                       data-name="<?= $item['NAME'] ?>"><?*/?>
		                    <a href="/contacts/#salon-map" class="on-map_header">
		                        <div class="on-map-img">
		                            <svg  version="1.1" xmlns="http://www.w3.org/2000/svg" height="15" width="15"
		                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 15 15"
		                                 style="enable-background:new 0 0 15 15;" xml:space="preserve">
		                            <g>
		                                <g>
		                                    <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                      c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                      c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
		                                </g>
		                            </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
		                        </svg>
		                        </div>
		                        Показать на&nbsp;карте</a>
		                <? } ?>
		<? if (!empty($item['PROPERTY_DOPTEXT_VALUE'])) { ?>
			<? if (SUB_DOMAIN == 'spb'): ?>
				<div class="new_saloon_quiz_head">
					<p><strong>Рядом с какой станцией метро вы бы хотели видеть новый салон оптики?</strong></p>
					<div><div data-marquiz-id="667042b420caed0026352e51"></div></div>
				</div>
<script>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Button', {id: '667042b420caed0026352e51', buttonText: 'Выбрать', bgColor: '#9971db', textColor: '#fff', rounded: true, blicked: true})</script>
<style>
.new_saloon_quiz_head {
    display: flex;
	flex-direction: column;
	align-items: center;
	align-content: center;
}
.marquiz_container_inline .marquiz_button {
color: #ffffff;
background-color: #9971db;
font-family: "Open Sans", sans-serif;
font-size: 14px;
border-radius: 5px;
border: 2px solid #9971db;
padding: 15px 30px;
font-weight: bold;
transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out, border-color 0.3s ease-in-out;
}
</style>
			<? endif; ?>
			</div>
			<div class="col-md-6"><?=$item['PROPERTY_DOPTEXT_VALUE'] ?>
			</div>
		</div>
		<? } ?>
            </div><!-- city-adresses-column -->
        <? } ?>
    </div><!-- city-adresses -->

    <a href="javascript:void(0);" class="city" onclick="ESCityShow();">
        <div class="city-img">
            <svg id="Layer_2" version="1.1" xmlns="http://www.w3.org/2000/svg" height="15" width="15" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 15 15" style="enable-background:new 0 0 15 15;" xml:space="preserve">
                <g>
                    <g>
                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                    </g>
                </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
            </svg>
        </div><span class="js-selcity"><?=$CITY_NAME?></span>
    </a>
    <?if ( !empty($arrSaloon) ){?>
        <span class="place-btn">Наши салоны</span>
    <? } ?>


<?//if ($CITY_NAME == 'Санкт-Петербург'){?>
   <!-- <a href='/viezdnaja-optika' class="viezd-btn" title="Выездная оптика">Выездная оптика</a>-->
	<?//} else {};?>
	
	
	<a href="/proverka-zrenija/" class="proverka-btn" onclick="ym(24545261,'reachGoal','proverka_orange');return true;">Проверка зрения</a>
</div>

