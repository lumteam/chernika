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
<div class="feedbacks-page-add-btn"><a href="#feedbacks-modal">Оставить отзыв</a></div>

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>

<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

    $arLink = array();
    $linkId = intval($arItem["PROPERTIES"]["SALON"]["VALUE"]);
    if($linkId > 0)
    {
        $arLink = CIBlockElement::GetList(array("ID"=>"ASC"), array("IBLOCK_ID"=>$arItem["PROPERTIES"]["SALON"]["LINK_IBLOCK_ID"],"ACTIVE"=>"Y","ID"=>$linkId), false, false, array("NAME","PROPERTY_TEL1","PROPERTY_TEL2","PROPERTY_CITY","PROPERTY_ADRESS"))->Fetch();
    }
    ?>
    <div class="row" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="col">
            <div class="feedback" itemscope itemtype="https://schema.org/Review">
		<?if(count($arLink) > 0):?>
			<div style="display: none" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Organization">
		             <meta itemprop="name" content="<?=htmlspecialchars($arLink["NAME"])?>">
			     <img itemprop="image" style="display: none;" src="/local/templates/chernika/img/favicon.png" alt="Черника Оптика">
		             <meta itemprop="telephone" content="<?=htmlspecialchars($arLink["PROPERTY_TEL1_VALUE"])?>">
		             <meta itemprop="telephone" content="<?=htmlspecialchars($arLink["PROPERTY_TEL2_VALUE"])?>">
		             <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
		                 <meta itemprop="addressLocality" content="<?=htmlspecialchars($arLink["PROPERTY_CITY_VALUE"])?>">
		                 <meta itemprop="streetAddress" content="<?=htmlspecialchars($arLink["PROPERTY_ADRESS_VALUE"])?>">
		             </div>
        		</div>
		<?else:?>
			<div style="display: none" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Organization">
		             <meta itemprop="name" content="Черника Оптика">
		             <meta itemprop="telephone" content="+7 (812) 409-48-72">
		             <meta itemprop="telephone" content="+7 (800) 302-32-89">
		             <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
		                 <meta itemprop="addressLocality" content="Санкт-Петербург">
		                 <meta itemprop="streetAddress" content="улица 1-я Красноармейская, дом 8-10">
		             </div>
        		</div>
		<?endif;?>
		<meta itemprop="datePublished" content="<?echo $arItem["DISPLAY_ACTIVE_FROM"]?>">
                <div class="feedback-header" itemprop="author" itemscope itemtype="https://schema.org/Person">
                    <h3 class="feedback-name" itemprop="name"><?=$arItem['NAME']?></h3><span class="feedback-date" >(<?=FormatDate('Q', MakeTimeStamp($arItem['ACTIVE_FROM']))?> назад)</span>
                </div>
                <div class="feedback-body" itemprop="reviewBody">
                    <p><?=$arItem['PREVIEW_TEXT']?></p>
                </div>
                <div class="feedback-footer">
                    <?if(intval($arItem['PROPERTIES']['MODEL']['VALUE']) > 0):?>
                        <div class="feedback-rating"><span class="label">Модель:</span>
                            <div class="value">
                                <?for ($i=1;$i<=$arItem['PROPERTIES']['MODEL']['VALUE'];$i++){?>
                                    <div class="star active"></div>
                                <? } ?>
                                <?for ($i=$arItem['PROPERTIES']['MODEL']['VALUE'];$i<5;$i++){?>
                                    <div class="star"></div>
                                <? } ?>
                            </div>
                        </div>
                    <?endif;?>
                    <?if(intval($arItem['PROPERTIES']['QUALITY']['VALUE']) > 0):?>
                        <div class="feedback-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><span class="label">Качество:</span>
			<span style="display: none" itemprop="ratingValue"><?echo $arItem['PROPERTIES']['QUALITY']['VALUE'];?></span>
				<div class="value">
                                <?for ($i=1;$i<=$arItem['PROPERTIES']['QUALITY']['VALUE'];$i++){?>
                                    <div class="star active"></div>
                                <? } ?>
                                <?for ($i=$arItem['PROPERTIES']['QUALITY']['VALUE'];$i<5;$i++){?>
                                    <div class="star"></div>
                                <? } ?>
                            </div>
                        </div>
		    <?else:?>
			<div style="display: none" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><span style="display: none" itemprop="ratingValue">5</span></div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
<?endforeach;?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>

<?
$arSalons = array();
$rsSalons = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>2,"ACTIVE"=>"Y"), false, false, array("ID","NAME","PROPERTY_ADRESS"));
while($arSalon = $rsSalons->Fetch()) $arSalons[] = $arSalon;
?>
<div id="feedbacks-modal" class="mfp-hide city-container">
    <div class="modal-header">
        <h4>Оставить отзыв</h4>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <form action="#" class="feedbacks-modal-body" id="form-review">
        <div class="feedback-rating"><span class="label">Модель:</span>
            <div class="value">
                <div class="star choose"></div>
                <div class="star choose"></div>
                <div class="star choose"></div>
                <div class="star choose"></div>
                <div class="star choose"></div>
            </div>
            <input type="hidden" name="model" value="0">
        </div>
        <div class="feedback-rating"><span class="label">Качество:</span>
            <div class="value">
                <div class="star choose"></div>
                <div class="star choose"></div>
                <div class="star choose"></div>
                <div class="star choose"></div>
                <div class="star choose"></div>
            </div>
            <input type="hidden" name="quality" value="0">
        </div>
        <div class="form-items">
            <div class="form-item">
                <input type="text" placeholder="Представьтесь пожалуйста:" class="input" name="name">
            </div>
            <div class="form-item">
                <input type="email" placeholder="Введите ваш e-mail:" class="input" name="email" required>
            </div>
            <div class="form-item">
                <select name="salon" required>
			<option value="">Выберите салон:</option>
			<?foreach($arSalons as $arSalon):?>
				<option value="<?=$arSalon["ID"]?>"><?=htmlspecialchars($arSalon["PROPERTY_ADRESS_VALUE"])?></option>
			<?endforeach;?>
                </select>
            </div>
            <div class="form-item">
                <textarea name="text" cols="20" rows="10" placeholder="Ваш отзыв:" class="textarea" required></textarea>
            </div>
            <div class="form-item">
                <button type="submit" class="submit-btn">Отправить</button>
            </div>
            <div class="form-item">
                <label class="checkbox">Согласен на обработку <a href="/data-processing/">персональных данных</a>, а также с условиями оферты.
                    <input type="checkbox" checked="checked" name="agree">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <input type="hidden" name="action" value="addreview">
    </form>
</div>
