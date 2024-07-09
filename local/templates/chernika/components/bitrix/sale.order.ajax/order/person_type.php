<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if( count($arResult["PERSON_TYPE"]) > 1 )
{
    ?>
    <div class="ordering__tabs">
        <nav class="p-filter tabs">
            <ul class="p-filter__list">
                <?foreach($arResult["PERSON_TYPE"] as $v):?>
                    <li class="p-filter__item">
                        <input type="radio" id="PERSON_TYPE_<?=$v["ID"]?>" name="PERSON_TYPE" value="<?=$v["ID"]?>"<?if ($v["CHECKED"]=="Y") echo " checked=\"checked\"";?> onClick="submitForm()" style="display: none">
                        <label for="PERSON_TYPE_<?=$v["ID"]?>" class="p-filter__link<?if ($v["CHECKED"]=="Y") echo " active";?>"><?=$v["NAME"]?></label>
                    </li>
                <?endforeach;?>
            </ul>
        </nav>
    </div>
    <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
    <?
}
else
{
    if ( IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0 )
    {
        ?>
        <input type="hidden" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
        <input type="hidden" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
        <?
    }
    else
    {
        foreach($arResult["PERSON_TYPE"] as $v)
        {
            ?>
            <input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
            <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
            <?
        }
    }
}
?>