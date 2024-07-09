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

<?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>
<div class="brands--wrapper">
	<div class="brands--col1">
<?endif;?>
		<h1 class="brands--page-title "><?=$APPLICATION->ShowTitle(false)?></h1>
		<?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>
			<?if($arResult["PROPERTIES"]["TOP_TEXT"]["VALUE"]["TEXT"] != ""):?>
				<div class="brands-preview">
					<?=$arResult["PREVIEW_TEXT"];?>
					<div div id="collapse1" style="display:none" class="brands-preview-text"><?=$arResult["PROPERTIES"]["TOP_TEXT"]["~VALUE"]["TEXT"];?></div>
					<a href="javascript:void(0);" data-href="#collapse1" class="nav-toggle-more1">Подробнее</a>
					
					
				</div>
<script>
            $(document).ready(function () {
                $('.nav-toggle-more1').click(function () {
                    var collapse_content_selector = $(this).data('href');
                    var toggle_switch = $(this);
                    $(collapse_content_selector).toggle(function () {
                        if ($(this).css('display') != 'none') {
                            toggle_switch.html('');
                        }
                    });
                });
            });
		</script>				
			<?else:?>
				<div class="brands-preview"><?=$arResult["PREVIEW_TEXT"];?></div>
			<?endif;?>
		<?endif;?>
<?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>
	</div>
<?endif;?>
	<?if($arResult["DETAIL_PICTURE"]["SRC"] != ""):?>
	<div class="brands--col2"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$APPLICATION->ShowTitle(false)?>">
	</div>
	<?endif;?>
<?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>
</div>
<?endif;?>
<?if(count($arResult["PROPERTIES"]["LINK_SECTION"]["VALUE"]) > 0):?>
	<div class="brand-list-url">
		<?foreach($arResult["PROPERTIES"]["LINK_SECTION"]["VALUE"] as $k=>$v):?>
			<a class="brand-item-url" href="<?=$v?>"><?=$arResult["PROPERTIES"]["LINK_SECTION"]["DESCRIPTION"][$k]?></a>
		<?endforeach;?>
	</div>
<?endif;?>
<?if($arResult["PROPERTIES"]["H2"]["VALUE"] != ""):?>
	<h2 class="brands--h2"><?=$arResult["PROPERTIES"]["H2"]["VALUE"]?></h2>
<?else:?>
	<h2 class="brands--h2">Оригинальные очки <?=$arResult["NAME"]?></h2>
<?endif;?>




