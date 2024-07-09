<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul>

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["TEXT"]=='О компании'){?>
		<li class="topDropdown"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
			<ul class="topDropdown-inner">
				<li><a href="<?=$arItem["LINK"]?>#best-price">Гарантия лучших цен</a></li>
				<li><a href="<?=$arItem["LINK"]?>#world-standart">Оптика мирового стандарта</a></li>
				<li><a href="<?=$arItem["LINK"]?>#11-years">Работаем 11 лет</a></li>
			</ul>
		</li>
	<?} else {?>
    	<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
    <?}?>
<?endforeach?>

</ul>
<?endif?>
