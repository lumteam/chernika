<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $APPLICATION;
?>

<div class="bx-ag-search-page search-page ">
  <div class="theme-brands">
	<form class="search-page-form" action="" method="get">
		<input class="smart-title-search-input3" placeholder="<?=$arParams["INPUT_PLACEHOLDER"]?>" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="50" />

		<?if($arParams["SHOW_WHERE"]):?>
			<select name="where">
				<option value=""><?=GetMessage("SEARCH_ALL")?></option>
				<?foreach($arResult["DROPDOWN"] as $key=>$value):?>
					<option value="<?=$key?>"<?if($arResult["REQUEST"]["WHERE"]==$key) echo " selected"?>><?=$value?></option>
				<?endforeach?>
			</select>
		<?endif;?>
		
		<button type="submit" value="<?=GetMessage("SEARCH_GO")?>" /><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 18 18">
                                    <defs>
                                        <path id="_6oh2a" d="M736.75 33.8a5.07 5.07 0 1 0 0-10.12 5.07 5.07 0 0 0 0 10.12zm0-11.8a6.74 6.74 0 0 1 5.33 10.88l5.67 5.67a.84.84 0 1 1-1.19 1.2l-5.67-5.68A6.75 6.75 0 1 1 736.75 22z"></path>
                                    </defs>
                                    <g>
                                        <g transform="translate(-730 -22)">
                                            <use fill="#202020" xlink:href="#_6oh2a"></use>
                                        </g>
                                    </g>
                                </svg></button>
		<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
		
		<?if($arParams["SHOW_WHEN"]):?>
			<script>
			var switch_search_params = function()
			{
				var sp = document.getElementById('search_params');
				var flag;
				var i;

				if(sp.style.display == 'none')
				{
					flag = false;
					sp.style.display = 'block'
				}
				else
				{
					flag = true;
					sp.style.display = 'none';
				}

				var from = document.getElementsByName('from');
				for(i = 0; i < from.length; i++)
					if(from[i].type.toLowerCase() == 'text')
						from[i].disabled = flag;

				var to = document.getElementsByName('to');
				for(i = 0; i < to.length; i++)
					if(to[i].type.toLowerCase() == 'text')
						to[i].disabled = flag;

				return false;
			}
			</script>
			<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
			<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
				<?$APPLICATION->IncludeComponent(
					'bitrix:main.calendar',
					'',
					array(
						'SHOW_INPUT' => 'Y',
						'INPUT_NAME' => 'from',
						'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
						'INPUT_NAME_FINISH' => 'to',
						'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
						'INPUT_ADDITIONAL_ATTR' => 'size="10"',
					),
					null,
					array('HIDE_ICONS' => 'Y')
				);?>
			</div>
		<?endif?>
	</form>
  </div>
	<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
		?>
		<div class="search-language-guess">
			<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
		</div><br /><?
	endif;?>
	
	<?if(is_array($arResult["SEARCH_HISTORY"]) && count($arResult["SEARCH_HISTORY"]) > 0):?>
		<div class="ag-spage-history">
			<?=GetMessage("SEARCH_HISTORY_TITLE")?>
			<?foreach($arResult["SEARCH_HISTORY"] as $k=>$v):
				if($k > 0) echo ', ';?><a href="?q=<?=$v?>"><?=$v?></a><?
			endforeach?>
		</div>
	<?endif;?>
	
	<?/* if($arResult["VISUAL_PARAMS"]["CLARIFY"] && count($arResult["CLARIFY_WORDS"]) > 1):?>
		<div class="ag-spage-clarify-list">
			<div class="ag-spage-clarify-title"><?=GetMessage("AG_SPAGE_CLARIFY_TITLE");?></div>
			<?foreach($arResult["CLARIFY_WORDS"] as $word):
			$word = strtolower($word);
			?>
				<a class="ag-spage-clarify-item" href="<?=$APPLICATION->GetCurPageParam('q='.$word, array("q"))?>"><?=$word?></a>
			<?endforeach;?>
		</div>
	<?endif; */?>
	
	<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
		<?// clear //?>
	<?elseif($arResult["ERROR_CODE"]!=0):?>
		<p><?=GetMessage("SEARCH_ERROR")?></p>
		<?ShowError($arResult["ERROR_TEXT"]);?>
		<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
		<br /><br />
	<?elseif(count($arResult["SEARCH"])>0):?>
		<div class="row">
			<?if($arParams["DISPLAY_TOP_PAGER"] != "N"):?>
				<?echo $arResult["NAV_STRING"]?><br />
			<?endif;?>
			
			<?foreach($arResult["SEARCH"] as $k=>$arItem):
				$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
				// echo '<pre>'; print_r($arElement); echo '</pre>';
			?>
				<div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 text-center">
					<?if(is_array($arItem["PICTURE"])):?>
						<a class="brands-item" href="<?echo $arItem["URL"]?>"><img src="<?=$arItem["PICTURE"]["src"]?>"></a><div class="brands-title"><?echo $arItem["TITLE_FORMATED"]?></div>
					<?endif;?>
					
					
				</div>
			<?endforeach;?>
			
			<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N"):?>
				<?echo $arResult["NAV_STRING"]?><br />
			<?endif;?>
		</div>
	<?else:?>
		<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
	<?endif;?>
</div>

<?if($arResult["VISUAL_PARAMS"]["THEME_COLOR"]):?>
	<style>
		.search-page .search-item, .search-page input[type=text], .search-page input[type=submit], .ag-spage-clarify-item, .ag-spage-clarify-item:hover {
			border-color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?> !important;
		}
		.search-page input[type=submit] {
			background-color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?> !important;
		}
	</style>
<?endif;?>