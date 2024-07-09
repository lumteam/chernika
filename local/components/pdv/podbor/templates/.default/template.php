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

global $USER;
?>

<?if ( !$arResult['FINISH'] ):?>
    <div class="config-page">
        <form class="container" id="form-podbor">
            <?if ( $arResult['STEP'] < 5 ):?>
            <div class="row">
                <div class="col-9">
                    <h2 class="page-title">Подбор линз для очков</h2>
                    <div class="config-steps">
                        <a href="#" class="step step-1<?if( $arResult['STEP'] >= 1 )echo ' active';?>"><span class="count">1</span><span class="text">Тип очков</span></a>
                        <a href="#" class="step step-2<?if( $arResult['STEP'] >= 2 )echo ' active';?>"><span class="count">2</span><span class="text">Рецепт</span></a>
                        <a href="#" class="step step-3<?if( $arResult['STEP'] >= 3 )echo ' active';?>"><span class="count">3</span><span class="text">Линзы и покрытия</span></a>
                    </div>
            <?endif;?>
                    <div class="step-wrap<?if( $arResult['STEP'] == 1 )echo ' active';?>">
                        <div class="row">
                            <div class="col-3">
                                <div class="config-items">
                                    <?foreach ( $arResult['TYPES_SECTION'] as $sect ){?>
                                        <label class="config-item js-config_item<?if($sect['CHECKED'])echo ' active';?>">
                                            <div class="config-item-check"></div>
                                            <a href="#" class="config-item-info">?</a>
                                            <div class="config-item-text"><?=$sect['NAME']?></div>
                                            <input type="radio" name="type_sect" value="<?=$sect['ID']?>"<?if($sect['CHECKED'])echo ' checked';?>>
                                        </label>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="col">
                                <?if ( !empty($arResult['TYPES_ELEMENT']) ):?>
                                    <div class="row config-categories">
                                        <?foreach ( $arResult['TYPES_ELEMENT'] as $item ){?>
                                            <div class="col-4">
                                                <div class="config-categories-item<?if($item['CHECKED'])echo ' active';?>">
                                                    <h3 class="config-categories-item-title"><?=$item['NAME']?></h3>
                                                    <?if ( $item['PREVIEW_PICTURE'] > 0 ){?>
                                                        <img src="<?=CFile::GetPath($item['PREVIEW_PICTURE'])?>" alt="" class="config-categories-item-img">
                                                    <? } ?>
                                                    <label class="config-categories-item-btn js-type_elem">
                                                        Продолжить
                                                        <input type="radio" name="type_elem" value="<?=$item['ID']?>"<?if($item['CHECKED'])echo ' checked';?>>
                                                    </label>
                                                    <div class="config-categories-item-text"><?=$item['PREVIEW_TEXT']?></div>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                <?else:?>
                                    <a href="#" class="config-choose-banner">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="80" height="30" viewbox="0 0 80 30">
                                            <defs>
                                                <path id="6g01a" d="M635 565l-10-13 9.5-13"></path>
                                                <path id="6g01b" d="M625 554v-4h77v4z"></path>
                                            </defs>
                                            <g>
                                                <g transform="translate(-622 -537)">
                                                    <g>
                                                        <use fill="#fff" fill-opacity="0" stroke="#787878" stroke-miterlimit="50" stroke-width="4" xlink:href="#6g01a"></use>
                                                    </g>
                                                    <g>
                                                        <use fill="#787878" xlink:href="#6g01b"></use>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>Выберите тип очков
                                    </a>

                                    <h3 class="config-text-title">Обратите внимание</h3>
                                    <p class="config-text-list"><?=$arResult['DESCRIPTION']?></p>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                    <?if ( $arResult['STEP'] >= 2 ):?>
                        <div class="step-wrap<?if( $arResult['STEP'] == 2 )echo ' active';?>">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="categories-horizontal-title">Ваш рецепт</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="horizontal-menu mt0">
                                        <label<?if( empty($arResult['PODBOR_REQUEST']['type_recept']) || $arResult['PODBOR_REQUEST']['type_recept'] == 'enter')echo ' class="active"';?>>
                                            <span>Ввести данные рецепта</span>
                                            <input type="radio" name="type_recept" value="enter"<?if( empty($arResult['PODBOR_REQUEST']['type_recept']) || $arResult['PODBOR_REQUEST']['type_recept'] == 'enter')echo ' checked';?>>
                                        </label>
                                        <label<?if($arResult['PODBOR_REQUEST']['type_recept'] == 'use')echo ' class="active"';?>>
                                            <span>Использовать рецепт</span>
                                            <input type="radio" name="type_recept" value="use"<?if($arResult['PODBOR_REQUEST']['type_recept'] == 'use')echo ' checked';?>>
                                        </label>
                                        <label<?if($arResult['PODBOR_REQUEST']['type_recept'] == 'send')echo ' class="active"';?>>
                                            <span>Отправить рецепт</span>
                                            <input type="radio" name="type_recept" value="send"<?if($arResult['PODBOR_REQUEST']['type_recept'] == 'send')echo ' checked';?>>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="step-wrap<?if( empty($arResult['PODBOR_REQUEST']['type_recept']) || $arResult['PODBOR_REQUEST']['type_recept'] == 'enter' )echo ' active';?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="note"><span>!</span>
                                            <p> <b>Предупреждение: </b>Если в вашем рецепте есть значение оси AXIS, также должно быть выбрано значение цилиндра (CYL).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row recipe-panel-header">
                                        <div class="col"></div>
                                        <div class="col">
                                            <h4>Сфера (SPH)</h4>
                                        </div>
                                        <div class="col">
                                            <h4>Цилиндр (CYL)</h4>
                                        </div>
                                        <div class="col">
                                            <h4>Ось</h4>
                                        </div>
                                        <div class="col">
                                            <h4>Дополнение (ADD)</h4>
                                        </div>
                                    </div>
                                    <div class="row recipe-panel-row">
                                        <div class="col">
                                            <p>OD - Правый Глаз</p>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="sph_right">
                                                <?
                                                foreach ( $arResult['SPH'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['sph_right'])) || ( $arResult['PODBOR_REQUEST']['sph_right'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="cyl_right">
                                                <?
                                                foreach ( $arResult['CYL'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['cyl_right'])) || ( $arResult['PODBOR_REQUEST']['cyl_right'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="ocy_right">
                                                <?
                                                foreach ( $arResult['OSY'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['ocy_right'])) || ( $arResult['PODBOR_REQUEST']['ocy_right'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="add_right">
                                                <?
                                                foreach ( $arResult['ADD'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['add_right'])) || ( $arResult['PODBOR_REQUEST']['add_right'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row recipe-panel-row">
                                        <div class="col">
                                            <p>OS - Левый Глаз</p>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="sph_left">
                                                <?
                                                foreach ( $arResult['SPH'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['sph_left'])) || ( $arResult['PODBOR_REQUEST']['sph_left'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="cyl_left">
                                                <?
                                                foreach ( $arResult['CYL'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['cyl_left'])) || ( $arResult['PODBOR_REQUEST']['cyl_left'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="ocy_left">
                                                <?
                                                foreach ( $arResult['OSY'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['ocy_left'])) || ( $arResult['PODBOR_REQUEST']['ocy_left'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="nice-select" name="add_left">
                                                <?
                                                foreach ( $arResult['ADD'] as $id => $elem){
                                                    $sel = '';
                                                    if ( ($elem['NAME'] == 'NONE' && empty($arResult['PODBOR_REQUEST']['add_left'])) || ( $arResult['PODBOR_REQUEST']['add_left'] == $elem['ID']) )
                                                        $sel = ' selected';
                                                    ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row recipe-panel-footer">
                                        <p>Убедитесь, что в рецепте правильно указаны значения<b>'+'</b><b>'-'</b><b>SPH </b>и<b>CYL</b>.<a href="#modal_sph_cyl" class="popup-link">Подробнее</a></p>
                                    </div>
                                </div>
                                <label class="checkbox">Добавить призму
                                    <input type="checkbox" name="prizma"<?if ( !empty($arResult['PODBOR_REQUEST']['prizma']) )echo ' checked';?> value="y">
                                    <div class="control__indicator"></div>
                                </label>
                                <div class="prizm"<?if ( empty($arResult['PODBOR_REQUEST']['prizma']) )echo ' style="display: none"';?>>
                                    <div class="border-divider"></div>
                                    <h3 class="categories-horizontal-title">Значение вашей призмы</h3>
                                    <p>Убедитесь, что в рецепте правильно указаны значения</p>
                                    <div class="row mb15">
                                        <div class="col-6">
                                            <p class="additional-text">OD - Правый Глаз:</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="additional-select nice-select" name="prizma_direction_right">
                                                        <option value="">Направление</option>
                                                        <?
                                                        foreach ( $arResult['PRIZMA_DIRECTION'] as $id => $elem){
                                                            $sel = '';
                                                            if ( $arResult['PODBOR_REQUEST']['prizma_direction_right'] == $elem['ID'] )
                                                                $sel = ' selected';
                                                            ?>
                                                            <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select class="additional-select nice-select" name="prizma_power_right">
                                                        <option value="">Сила</option>
                                                        <?
                                                        foreach ( $arResult['PRIZMA_POWER'] as $id => $elem){
                                                            $sel = '';
                                                            if ( $arResult['PODBOR_REQUEST']['prizma_power_right'] == $elem['ID'] )
                                                                $sel = ' selected';
                                                            ?>
                                                            <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb15">
                                        <div class="col-6">
                                            <p class="additional-text"> OS - Левый Глаз: </p>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="additional-select nice-select" name="prizma_direction_left">
                                                        <option value="">Направление</option>
                                                        <?
                                                        foreach ( $arResult['PRIZMA_DIRECTION'] as $id => $elem){
                                                            $sel = '';
                                                            if ( $arResult['PODBOR_REQUEST']['prizma_direction_left'] == $elem['ID'] )
                                                                $sel = ' selected';
                                                            ?>
                                                            <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select class="additional-select nice-select" name="prizma_power_left">
                                                        <option value="">Сила</option>
                                                        <?
                                                        foreach ( $arResult['PRIZMA_POWER'] as $id => $elem){
                                                            $sel = '';
                                                            if ( $arResult['PODBOR_REQUEST']['prizma_power_left'] == $elem['ID'] )
                                                                $sel = ' selected';
                                                            ?>
                                                            <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-divider"></div>
                                <h3 class="categories-horizontal-title">Дополнительная информация</h3>
                                <div class="row mb15">
                                    <div class="col-6">
                                        <p class="additional-text">Межзрачковое расстояние / PD</p>
                                    </div>
                                    <div class="col-6">
                                        <?if ( empty($arResult['PODBOR_REQUEST']['type_pd_current']) || $arResult['PODBOR_REQUEST']['type_pd_current'] == 'pd_63' ) {?>
                                            <select class="additional-select nice-select" name="pd_63">
                                                <option value="">выберите значение</option>
                                                <?
                                                foreach ( $arResult['PD_63'] as $id => $elem){
                                                    $sel = '';
                                                    if (  $arResult['PODBOR_REQUEST']['pd_63'] == $elem['ID'] )
                                                        $sel = ' selected';
                                                ?>
                                                    <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                <?}?>
                                            </select>
                                            <a href="#modal_pd" class="additional-link popup-link">Что это?</a>
                                            <label class="additional-sublink">
                                                <input type="radio" name="type_pd" value="pd_32">
                                                У меня есть два значения (PD) (те 32/32)
                                            </label>
                                        <? } elseif ( $arResult['PODBOR_REQUEST']['type_pd_current'] == 'pd_32' ) {?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="additional-select nice-select" name="pd_32_right">
                                                        <option value="">Правый</option>
                                                        <?
                                                        foreach ( $arResult['PD_32'] as $id => $elem){
                                                            $sel = '';
                                                            if (  $arResult['PODBOR_REQUEST']['pd_32_right'] == $elem['ID'] )
                                                                $sel = ' selected';
                                                            ?>
                                                            <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                        <?}?>
                                                    </select>
                                                    <a href="#" class="additional-link">Что это?</a>
                                                </div>
                                                <div class="col-6">
                                                    <select class="additional-select nice-select" name="pd_32_left">
                                                        <option value="">Левый</option>
                                                        <?
                                                        foreach ( $arResult['PD_32'] as $id => $elem){
                                                            $sel = '';
                                                            if (  $arResult['PODBOR_REQUEST']['pd_32_left'] == $elem['ID'] )
                                                                $sel = ' selected';
                                                            ?>
                                                            <option value="<?=$elem['ID']?>"<?=$sel?>><?=$elem['NAME']?></option>
                                                        <?}?>
                                                    </select>
                                                    <label class="additional-sublink">
                                                        <input type="radio" name="type_pd" value="pd_63">
                                                        У меня одно значение PD (тe, 63)
                                                    </label>
                                                </div>
                                            </div>
                                        <? } ?>
                                        <input type="hidden" name="type_pd_current" value="<?=$arResult['PODBOR_REQUEST']['type_pd_current']?>">
                                    </div>
                                </div>
                                <div class="row mb15">
                                    <div class="col-6">
                                        <p class="additional-text">Название вашего рецепта</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="additional-select" name="recept" value="<?=$arResult['PODBOR_REQUEST']['recept']?>">
                                    </div>
                                </div>
                                <div class="row mb15">
                                    <div class="col-6">
                                        <p class="additional-text">Желаете добавить информацию о вашем рецепте?</p>
                                    </div>
                                    <div class="col-6">
                                        <textarea placeholder="Введите дополнительную информацию" class="additional-textarea" name="text"><?=$arResult['PODBOR_REQUEST']['text']?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="checkbox">Я подтверждаю, что в рецепте правильно указаны значения '+' '-' SPH и CYL, моему рецепту не более 2 лет, и я принимаю условия <a href="/privacy-policy/" target="_blank">Пользовательского соглашения</a>
                                            <input type="checkbox" name="agree"<?if($arResult['PODBOR_REQUEST']['agree'] == 'y')echo ' checked';?> value="y">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><a href="#" class="next-step-btn js-set_recept_enter"">Следующий шаг - выберите линзы</a></div>
                                </div>
                            </div>
                            <div class="step-wrap<?if($arResult['PODBOR_REQUEST']['type_recept'] == 'use')echo ' active';?>">
                                <?if ( !$USER->IsAuthorized() ):?>
                                    <a href="#login-modal" class="next-step-btn mr-a js-profile">Войти</a>
                                <?else:?>
                                    <div class="row">
                                        <div class="col-12">
                                            <?if ( !empty($arResult['USER']['UF_RECIPE']) ) {?>
                                                <p>Ваш рецепт</p>
                                                <a href="<?=CFile::GetPath($arResult['USER']['UF_RECIPE'])?>" style="text-decoration: underline" target="_blank">посмотреть</a>
                                            <?} elseif ( !empty($arResult['USER']['UF_RECIPE_TEXT']) ) {?>
                                                <p>Ваш рецепт</p>
                                                <textarea name="recept_text" readonly><?=$arResult['USER']['UF_RECIPE_TEXT']?></textarea>
                                            <? } else {?>
                                                Сохраненный рецепт не был найден
                                            <? } ?>
                                        </div>
                                    </div>
                                    <?if ( !empty($arResult['USER']['UF_RECIPE']) || !empty($arResult['USER']['UF_RECIPE_TEXT']) ) {?>
                                        <div class="row">
                                            <div class="col-12"><a href="#" class="next-step-btn js-set_step" data-id="3">Следующий шаг - выберите линзы</a></div>
                                        </div>
                                    <? } ?>
                                <?endif;?>
                            </div>
                            <div class="step-wrap<?if($arResult['PODBOR_REQUEST']['type_recept'] == 'send')echo ' active';?>">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="info-paragraph">Если Вы не уверены в правильности заполнения рецепта, можете обратиться к нам: <a href="mailto:info@chernika.ru">info@chernika.ru</a></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><a href="#" class="next-step-btn mr-a js-set_step" data-id="3">Я отправлю рецепт позже</a></div>
                                </div>
                            </div>
                        </div>
                    <?endif;?>
                    <?if ( $arResult['STEP'] >= 3 ):?>
                        <div class="step-wrap<?if( $arResult['STEP'] == 3 )echo ' active';?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="horizontal-menu">
                                        <?foreach ( $arResult['TYPES_SECTION_LINSES'] as $sect){?>
                                            <label <?if($sect['CHECKED'])echo ' class="active"';?>>
                                                <span><?=$sect['NAME']?></span>
                                                <input type="radio" name="type_sect_linses" value="<?=$sect['ID']?>"<?if($sect['CHECKED'])echo ' checked';?>>
                                            </label>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                            <?if ( !empty($arResult['TYPES_ELEMENT_LINSES']) ):?>
                                <div class="row">
                                    <?foreach ( $arResult['TYPES_ELEMENT_LINSES'] as $item ){?>
                                        <div class="col-3">
                                            <div class="categories-horizontal-item<?if($item['CHECKED'])echo ' active';?>">
                                                <h3 class="categories-horizontal-item-title"><?=$item['NAME']?></h3>
                                                <?if ( !empty($item['PREVIEW_PICTURE']) ){?>
                                                    <div class="categories-horizontal-item-img"><img src="<?=CFile::GetPath($item['PREVIEW_PICTURE'])?>" alt="<?=$item['NAME']?>"></div>
                                                <? } ?>
                                                <p class="categories-horizontal-item-price text"><?=($item['PRICE']==0)?'Бесплатно':number_format(round($item['PRICE']),0,'',' ').'<span>₽</span>'?></p>
                                                <?if ( !empty($item['PREVIEW_TEXT']) ){?>
                                                    <p class="categories-horizontal-item-bonus"><?=$item['PREVIEW_TEXT']?></p>
                                                <? } ?>
                                                <label class="categories-horizontal-item-btn js-type_elem_linses">
                                                    Выбрать
                                                    <input type="radio" name="type_elem_linses" value="<?=$item['ID']?>"<?if($item['CHECKED'])echo ' checked';?>>
                                                </label>
                                                <?=$item['DETAIL_TEXT']?>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            <?endif;?>
                        </div>
                    <?endif;?>
                    <?if ( $arResult['STEP'] >= 4 ):?>
                        <div class="step-wrap<?if( $arResult['STEP'] == 4 )echo ' active';?>">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="categories-horizontal-title">Выберите цветовые опции для ваших линз</h3>
                                    <p class="categories-horizontal-text"><?=$arResult['LINSES_COLORS']['DESCRIPTION']?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="horizontal-menu">
                                        <?foreach ( $arResult['TYPES_SECTION_LINSES_COLORS'] as $sect){?>
                                            <label <?if($sect['CHECKED'])echo ' class="active"';?>>
                                                <span><?=$sect['NAME']?></span>
                                                <input type="radio" name="type_sect_linses_colors" value="<?=$sect['ID']?>"<?if($sect['CHECKED'])echo ' checked';?>>
                                            </label>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>

                            <?if ( !empty($arResult['TYPES_ELEMENT_LINSES_COLORS']) ):?>
                                <div class="row">
                                    <?if ( stripos($arResult['SELECT_TYPE_LINSES_COLORS'], 'Без цветовых опций') !== false ):
                                        $current = current($arResult['TYPES_ELEMENT_LINSES_COLORS']);
                                    ?>
                                        <div class="col-12">
                                            <div class="no-options-item">
                                                <?if ( !empty($current['PREVIEW_PICTURE']) ):?>
                                                    <div class="no-options-item-img"><img src="<?=CFile::GetPath($current['PREVIEW_PICTURE'])?>" alt="<?=$current['NAME']?>"></div>
                                                <?endif;?>
                                                <div class="no-options-content">
                                                    <h4 class="no-options-content-title"><?=$current['NAME']?></h4>
                                                    <p class="no-options-content-subtitle"><?=$current['PREVIEW_TEXT']?></p>
                                                    <label class="next-step-btn mr-a js-type_elem_linses_colors">
                                                        <span>Без цветовых опций</span>
                                                        <input type="radio" name="type_elem_linses_colors" value="<?=$current['ID']?>"<?if($current['CHECKED'])echo ' checked';?>>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?else:?>
                                        <?foreach ( $arResult['TYPES_ELEMENT_LINSES_COLORS'] as $item ){?>
                                            <div class="col-3">
                                                <div class="categories-horizontal-item<?if($item['CHECKED'])echo ' active';?>">
                                                    <h3 class="categories-horizontal-item-title"><?=$item['NAME']?></h3>
                                                    <?if ( !empty($item['PREVIEW_PICTURE']) ){?>
                                                        <div class="categories-horizontal-item-img"><img src="<?=CFile::GetPath($item['PREVIEW_PICTURE'])?>" alt="<?=$item['NAME']?>"></div>
                                                    <? } ?>
                                                    <p class="categories-horizontal-item-price text"><?=($item['PRICE']==0)?'Бесплатно':number_format(round($item['PRICE']),0,'',' ').'<span>₽</span>'?></p>
                                                    <?if ( !empty($item['PREVIEW_TEXT']) ){?>
                                                        <p class="categories-horizontal-item-bonus"><?=$item['PREVIEW_TEXT']?></p>
                                                    <? } ?>
                                                    <label class="categories-horizontal-item-btn js-type_elem_linses_colors">
                                                        Выбрать
                                                        <input type="radio" name="type_elem_linses_colors" value="<?=$item['ID']?>"<?if($item['CHECKED'])echo ' checked';?>>
                                                    </label>
                                                    <?=$item['DETAIL_TEXT']?>
                                                </div>
                                            </div>
                                        <? } ?>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                            <div class="row">
                                <div class="col-12">
                                    <h3 class="config-text-title">Обратите внимание</h3>
                                    <p class="config-text-list">- Больше информации о дополнительных опциях линз Вы можете найти <a href="#" target="_blank">здесь</a> (открывается в новом окне).</p>
                                </div>
                            </div>
                        </div>
                    <?endif;?>

            <?if ( $arResult['STEP'] < 5 ):?>
                    </div>
                    <div class="col">
                        <div class="config-sidebar">
                            <?if( !empty($arResult['PRODUCT']) ):?>
                                <div class="config-sidebar-header">
                                    <?if (!empty($arResult['PRODUCT']['PICTURE']) ){?>
                                        <img src="<?=$arResult['PRODUCT']['PICTURE']?>" alt="<?=$arResult['PRODUCT']['NAME']?>" class="config-sidebar-header-img">
                                    <? } ?>
                                    <?if (!empty($arResult['PRODUCT']['ARTICLE']) ){?>
                                        <p class="config-sidebar-header-subinfo">Артикул: <?=$arResult['PRODUCT']['ARTICLE']?></p>
                                    <? } ?>
                                    <p class="config-sidebar-header-title"><?=$arResult['PRODUCT']['NAME']?></p>
                                    <?if (!empty($arResult['PRODUCT']['SIZE']) ){?>
                                        <p class="config-sidebar-header-subinfo">Размер: <?=$arResult['PRODUCT']['SIZE']?></p>
                                    <? } ?>
                                    <?if (!empty($arResult['PRODUCT']['COLOR']) ){?>
                                        <p class="config-sidebar-header-subinfo">Цвет: <?=$arResult['PRODUCT']['COLOR']?></p>
                                    <? } ?>
                                    <p class="config-sidebar-header-price"><?=number_format(round($arResult['PRODUCT']['PRICE']),0,'',' ')?><span>₽</span></p>
                                </div>
                            <?endif;?>

                            <div class="config-sidebar-body">
                                <p class="config-sidebar-body-label">Тип очков: <?=($arResult['STEP']>1)?' <a href="#" class="link_change js-set_step" data-id="1">изменить</a>':'';?></p>
                                <p class="config-sidebar-body-value"><?=(!empty($arResult['SELECT_TYPE']))?$arResult['SELECT_TYPE']:'не выбрано';?></p>
                                <p class="config-sidebar-body-label">Рецепт: <?=($arResult['STEP']>2)?' <a href="#" class="link_change js-set_step" data-id="2">изменить</a>':'';?></p>
                                <p class="config-sidebar-body-value"><?=($arResult['STEP']>2)?$arResult['SELECT_RECEPT_TYPE']:'не выбрано';?></p>
                                <p class="config-sidebar-body-label">Линзы и покрытия: <?=($arResult['STEP']>3)?' <a href="#" class="link_change js-set_step" data-id="3">изменить</a>':'';?></p>
                                <p class="config-sidebar-body-value"><?=(!empty($arResult['SELECT_TYPE_LINSES']))?$arResult['SELECT_TYPE_LINSES']:'не выбрано';?></p>
                            </div>
                            <div class="config-sidebar-footer">
                                <p class="config-sidebar-footer-total-price">
                                    Итого: <span> <?=number_format(round($arResult['PRODUCT']['PRICE']+$arResult['PRICE_LINSES']),0,'',' ')?> <span class="currency">₽</span></span>
                                </p>
                            </div>
                        </div>

                        <p class="config-sidebar-info-text">Если у вас возникли проблемы с выбором линз вы можете получить консультацию.</p>
                        <a href="tel:88124081532" class="config-sidebar-info-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="15" viewbox="0 0 15 15">
                                <defs>
                                    <path id="rjaia" d="M1343.02 891c-.39 0-.78-.06-1.15-.2a15.8 15.8 0 0 1-9.7-9.96 3.45 3.45 0 0 1 1.18-3.8l.74-.57a2.35 2.35 0 0 1 3.5.8l1.25 2.43c.32.6.22 1.35-.25 1.86l-.25.28a.91.91 0 0 0-.14 1.03c.42.83 1.1 1.5 1.92 1.92.34.17.75.12 1.03-.14l.29-.26a1.67 1.67 0 0 1 1.85-.25l2.44 1.25a2.34 2.34 0 0 1 .6 3.73l-.85.86a3.47 3.47 0 0 1-2.46 1.02z"></path>
                                </defs>
                                <g>
                                    <g transform="translate(-1332 -876)">
                                        <use fill="#f44747" xlink:href="#rjaia"></use>
                                    </g>
                                </g>
                            </svg>Получить консультацию
                        </a>
                    </div>
                </div>
            <?endif;?>

            <?if ( $arResult['STEP'] >= 5 ):?>
                <div class="row">
                    <div class="col-9">
                        <h2 class="page-title">Подтвердите, что Вы выбрали правильно</h2>
                        <?if( !empty($arResult['PRODUCT']) ):?>
                            <div class="product-confirm">
                                <?if (!empty($arResult['PRODUCT']['PICTURE']) ){?>
                                    <div class="product-confirm-img"><img src="<?=$arResult['PRODUCT']['PICTURE']?>" alt="<?=$arResult['PRODUCT']['NAME']?>"></div>
                                <? } ?>
                                <div class="product-confirm-content">
                                    <?if (!empty($arResult['PRODUCT']['ARTICLE']) ){?>
                                        <p class="product-confirm-content-text">Артикул: <?=$arResult['PRODUCT']['ARTICLE']?></p>
                                    <? } ?>
                                    <h3 class="product-confirm-content-title"><?=$arResult['PRODUCT']['NAME']?></h3>
                                    <?if (!empty($arResult['PRODUCT']['SIZE']) ){?>
                                        <p class="product-confirm-content-text">Размер: <?=$arResult['PRODUCT']['SIZE']?></p>
                                    <? } ?>
                                    <?if (!empty($arResult['PRODUCT']['COLOR']) ){?>
                                        <p class="product-confirm-content-text">Цвет: <?=$arResult['PRODUCT']['COLOR']?></p>
                                    <? } ?>
                                    <p class="product-confirm-content-price"><?=number_format(round($arResult['PRODUCT']['PRICE']),0,'',' ')?><span>₽</span></p>
                                </div>
                            </div>
                        <?endif;?>

                        <h3 class="categories-horizontal-title">Ваш рецепт</h3>
                        <p class="clear">
                            <?=$arResult['SELECT_TYPE']?>
                            <a href="#" class="clear-btn js-set_step" data-id="1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="10" viewbox="0 0 15 10">
                            <defs>
                                <path id="26x4a" d="M922 473h13.5"></path>
                                <path id="26x4b" d="M926 477l-4-4 4-4"></path>
                            </defs>
                            <g>
                                <g transform="translate(-921 -468)">
                                    <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#26x4a"></use>
                                </g>
                                <g transform="translate(-921 -468)">
                                    <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#26x4b"></use>
                                </g>
                            </g>
                        </svg>Изменить тип линз</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <?if($arResult['PODBOR_REQUEST']['type_recept'] == 'enter'):?>
                            <div class="row recipe-panel-header">
                                <div class="col"><h4>Глаз</h4></div>
                                <div class="col"><h4>SPH</h4></div>
                                <div class="col"><h4>CYL</h4></div>
                                <div class="col"><h4>Ось</h4></div>
                                <div class="col"><h4>ADD</h4></div>
                            </div>
                            <div class="row recipe-panel-row">
                                <div class="col">
                                    <p>Правый</p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['sph_right']?></p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['cyl_right']?></p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['ocy_right']?></p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['add_right']?></p>
                                </div>
                            </div>
                            <div class="row recipe-panel-row">
                                <div class="col">
                                    <p>Левый</p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['sph_left']?></p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['cyl_right']?></p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['ocy_left']?></p>
                                </div>
                                <div class="col">
                                    <p><?=$arResult['PODBOR_VALUES']['add_left']?></p>
                                </div>
                            </div>
                            <div class="row recipe-panel-footer">
                                <p>Пожалуйста, проверьте правильность всех данных вашего рецепта</p>
                            </div>

                            <?if ( $arResult['PODBOR_REQUEST']['prizma'] == 'y'):?>
                                <div class="row recipe-panel-header">
                                    <div class="col"><h4>Глаз</h4></div>
                                    <div class="col"><h4>Направление</h4></div>
                                    <div class="col"><h4>Сила</h4></div>
                                </div>
                                <div class="row recipe-panel-row">
                                    <div class="col">
                                        <p>Правый</p>
                                    </div>
                                    <div class="col">
                                        <p><?=$arResult['PODBOR_VALUES']['prizma_direction_right']?></p>
                                    </div>
                                    <div class="col">
                                        <p><?=$arResult['PODBOR_VALUES']['prizma_power_right']?></p>
                                    </div>
                                </div>
                                <div class="row recipe-panel-row">
                                    <div class="col">
                                        <p>Левый</p>
                                    </div>
                                    <div class="col">
                                        <p><?=$arResult['PODBOR_VALUES']['prizma_direction_left']?></p>
                                    </div>
                                    <div class="col">
                                        <p><?=$arResult['PODBOR_VALUES']['prizma_power_left']?></p>
                                    </div>
                                </div>
                            <?endif;?>
                        <?else:?>
                            <?=$arResult['SELECT_RECEPT_TYPE']?>
                        <?endif;?>

                        <p class="clear">
                            <a href="#" class="clear-btn js-set_step" data-id="2" style="margin-left: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="10" viewbox="0 0 15 10">
                                    <defs>
                                        <path id="26x4a" d="M922 473h13.5"></path>
                                        <path id="26x4b" d="M926 477l-4-4 4-4"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-921 -468)">
                                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#26x4a"></use>
                                        </g>
                                        <g transform="translate(-921 -468)">
                                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-linecap="round" stroke-miterlimit="50" xlink:href="#26x4b"></use>
                                        </g>
                                    </g>
                                </svg>Изменить ваш рецепт
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <h3 class="categories-horizontal-title">Опции линз и Рецепт</h3>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Линзы</th>
                                <td><?=$arResult['SELECT_TYPE_LINSES']?></td>
                                <td>
                                    <p class="price"><?=($arResult['PRICE_LINSES']>0)?number_format(round($arResult['PRICE_LINSES']),0,'',' ').'<span>₽</span>':'Бесплатно'?></p>
                                </td>
                                <td><a href="#" class="js-set_step" data-id="3">изменить</a></td>
                            </tr>
                            <tr>
                                <th>Цветовые опции</th>
                                <td><?=$arResult['SELECT_TYPE_LINSES_COLORS']?></td>
                                <td>
                                    <p class="price"><?=($arResult['PRICE_LINSES_COLORS']>0)?number_format(round($arResult['PRICE_LINSES_COLORS']),0,'',' ').'<span>₽</span>':'Бесплатно'?></p>
                                </td>
                                <td>
                                <a href="#" class="js-set_step" data-id="4">изменить</a></td>
                            </tr>
                            <tr>
                                <th>Покрытие</th>
                                <td>
                                    <?foreach ( $arResult['POKRYTIE'] as $item ){?>
                                        <label class="checkbox"><?=$item['NAME']?>
                                            <input type="checkbox" name="pokrytie[]" value="<?=$item['ID']?>"<?if( in_array($item['ID'], $arResult['PODBOR_REQUEST']['pokrytie']) ) echo ' checked';?>>
                                            <div class="control__indicator"></div>
                                        </label>
                                        <div class="divider-10"></div>
                                    <? } ?>
                                </td>
                                <td>
                                    <p class="price">Бесплатно</p>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <h3 class="categories-horizontal-title price">Итого: <?=number_format(round($arResult['PRODUCT']['PRICE']+$arResult['PRICE_LINSES']+$arResult['PRICE_LINSES_COLORS']),0,'',' ')?><span>₽</span></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9"><a href="#" class="add-to-cart-btn js-set_step" data-id="6">Добавить в корзину</a></div>
                </div>
            <?endif;?>

            <input type="hidden" name="STEP" value="<?=$arResult['STEP']?>">
            <input type="hidden" name="ajax_mode" value="y">
        </form>
    </div>
    <?foreach ( $arResult['MODALS'] as $item ){?>
    <div id="modal_<?=$item['CODE']?>" class="mfp-hide city-container">
        <div style="max-width: 90%;">
            <div class="modal-header">
                <?if ( !empty(trim($item['NAME'])) ){?>
                    <h4><?=$item['NAME']?></h4>
                <? } ?>
                <button class="mfp-close">
                    <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
                </button>
            </div>
            <div class="feedbacks-modal-body"><?=$item['PREVIEW_TEXT']?></div>
        </div>
    </div>
<? } ?>
<?else:?>
    <?
    $APPLICATION->RestartBuffer();
    echo 'finish';
    die();
    ?>
<?endif;?>
