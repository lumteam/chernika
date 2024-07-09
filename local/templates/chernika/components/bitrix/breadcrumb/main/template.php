<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

$strReturn .= '<div class="breadcrumbs d-none d-xl-block"  itemscope itemtype="http://schema.org/BreadcrumbList"><div class="container"><ul>';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="13" viewbox="0 0 14 13">
        <defs>
            <path id="i6sba" d="M346.67 222.12v6.11c0 .43-.36.77-.78.77h-7.78a.77.77 0 0 1-.78-.77v-6.11H335l7-6.12 7 6.12h-2.33z"></path>
        </defs>
        <g>
            <g transform="translate(-335 -216)">
                <use fill="#bbb" xlink:href="#i6sba"></use>
            </g>
        </g>
    </svg>';

    $name = $title;
	//if ( $index == 0 ) $name = $arrow;

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<li class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$name.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" >
			</li>';
	}
	else
	{
		$strReturn .= '
			<li class="bx-breadcrumb-item">
                <span>'.$name.'</span>
			</li>';
	}
}

$strReturn .= '</ul></div></div>';

return $strReturn;
