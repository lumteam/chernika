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
<?if($arResult["PROPERTIES"]["H3"]["VALUE"] != ""):?>
	<h3 class="brands--h3"><?=$arResult["PROPERTIES"]["H3"]["VALUE"]?></h3>
<?endif;?>

<?if(strlen($arResult["DETAIL_TEXT"]) > 0):?>
	<?if($arResult["PROPERTIES"]["BOTTOM_TEXT"]["VALUE"]["TEXT"] != ""):?>
		<div class="brands-details">
			<div><?=$arResult["DETAIL_TEXT"];?></div>
<div id="collapse" style="display:none"><?=$arResult["PROPERTIES"]["BOTTOM_TEXT"]["~VALUE"]["TEXT"];?></div>
			
			<a href="javascript:void(0);" data-href="#collapse" class="nav-toggle-more">Читать далее</a>
		</div>
		<script>
            $(document).ready(function () {
                $('.nav-toggle-more').click(function () {
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
		<div class="brands-details"><?=$arResult["DETAIL_TEXT"];?></div>
	<?endif;?>
<?endif;?>

