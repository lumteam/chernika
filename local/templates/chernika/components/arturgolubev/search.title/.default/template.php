<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

/* hints */
$arResult["HINTS"] = array();
if(is_array($arParams["ANIMATE_HINTS"])){
	foreach($arParams["ANIMATE_HINTS"] as $k=>$v){
		$v = trim($v);
		if($v){
			$arResult["HINTS"][] = $v;
		}
	}
}

if(count($arResult["HINTS"])){
	CJSCore::Init(array("ag_smartsearch_type"));
	$arParams["INPUT_PLACEHOLDER"] = '';
	$arParams["ANIMATE_HINTS_SPEED"] = (intval($arParams["ANIMATE_HINTS_SPEED"]) ? intval($arParams["ANIMATE_HINTS_SPEED"]) : 1);
}
/* end hints */

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "smart-title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "smart-title-search";

$PRELOADER_ID = CUtil::JSEscape($CONTAINER_ID."_preloader_item");
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
<div id="<?echo $CONTAINER_ID?>" class="bx-searchtitle <?=$arResult["VISUAL_PARAMS"]["THEME_CLASS"]?>">
	<form action="<?echo $arResult["FORM_ACTION"]?>">
		
			<input id="<?echo $INPUT_ID?>" placeholder="<?=$arParams["INPUT_PLACEHOLDER"]?>" type="text" name="q" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" autocomplete="off" >
			
				<span class="bx-searchtitle-preloader <?if($arParams["SHOW_LOADING_ANIMATE"] == 'Y') echo 'view';?>" id="<?echo $PRELOADER_ID?>"></span>
				<button class="" type="submit" name="s"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewbox="0 0 18 18">
                                    <defs>
                                        <path id="_6oh2a" d="M736.75 33.8a5.07 5.07 0 1 0 0-10.12 5.07 5.07 0 0 0 0 10.12zm0-11.8a6.74 6.74 0 0 1 5.33 10.88l5.67 5.67a.84.84 0 1 1-1.19 1.2l-5.67-5.68A6.75 6.75 0 1 1 736.75 22z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-730 -22)">
                                            <use fill="#202020" xlink:href="#_6oh2a"></use>
                                        </g>
                                    </g>
                                </svg></button>
			
		
	</form>
	
	<?if(is_array($arResult["SEARCH_HISTORY"]) && count($arResult["SEARCH_HISTORY"]) > 0):?>
		<div class="bx-searchtitle-history">
			<?=GetMessage("CT_BST_SEARCH_HISTORY")?>
			<?foreach($arResult["SEARCH_HISTORY"] as $k=>$v):
				if($k > 0) echo ', ';?><a href="<?=$arParams["PAGE"]?>?q=<?=$v?>"><?=$v?></a><?
			endforeach?>
		</div>
	<?endif;?>
</div>
<?endif?>

<?if($arParams["NUM_CATEGORIES"] > 1):?>
	<?global $USER; if($USER->IsAdmin()):?>
		<div style="color: red; font-size: 13px;">
			<?=GetMessage("AG_SMARTIK_CATEGORY_WARRING", array("#NUM_VAL#" => $arParams["NUM_CATEGORIES"]));?>
		</div>
	<?endif;?>
<?endif;?>

<?if($arResult["VISUAL_PARAMS"]["THEME_COLOR"]):?>
	<style>
		.bx-searchtitle .bx-input-group .bx-form-control, .bx_smart_searche .bx_item_block.all_result .all_result_button, .bx-searchtitle .bx-input-group-btn button, .bx_smart_searche .bx_item_block_hrline {
			border-color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?> !important;
		}
		.bx_smart_searche .bx_item_block.all_result .all_result_button, .bx-searchtitle .bx-input-group-btn button {
			background-color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?>  !important;
		}
		.bx_smart_searche .bx_item_block_href_category_name, .bx_smart_searche .bx_item_block_item_name b, .bx_smart_searche .bx_item_block_item_simple_name b {
			color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?>  !important;
		}
	</style>
<?endif;?>

<script>
//	BX.ready(function(){
    $(document).ready(function() {
		new JCTitleSearchAG({
			// 'AJAX_PAGE' : '/your-path/fast_search.php',
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'PRELODER_ID': '<?echo $PRELOADER_ID?>',
			'MIN_QUERY_LEN': 2
		});
		
		<?if(count($arResult["HINTS"])):?>
			new Typed('#<?echo $INPUT_ID?>', {
				strings: <?=CUtil::PhpToJSObject($arResult["HINTS"]);?>,
				typeSpeed: <?=$arParams["ANIMATE_HINTS_SPEED"]*20?>,
				backSpeed: <?=$arParams["ANIMATE_HINTS_SPEED"]*10?>,
				backDelay: 500,
				startDelay: 1000,
				// smartBackspace: true,
				bindInputFocusEvents: true,
				attr: 'placeholder',
				loop: true
			});
		<?endif;?>
	});
</script>