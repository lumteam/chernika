<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

$APPLICATION->SetTitle('Спасибо за ваш заказ');
\Bitrix\Main\Loader::includeMOdule('sale');
?>

<? if (!empty($arResult["ORDER"])):?>

    <h2 class="section-subtitle">Заказ  <b>№<?=$arResult['ORDER']['ID']?> </b><?=$arResult['ORDER']['DATE_INSERT']?> принят. <span class="visible-widescreen">Ожидайте звонка оператора для подтверждения заказа</span></h2>
    <div class="row">
        <div class="col-lg-8">
            <div class="cart-wrapper">
                <?
                $dbBasketItems = CSaleBasket::GetList(
                    ['ID' => 'ASC'],
                    ['ORDER_ID' => $arResult['ORDER_ID']],
                    false,
                    false,
                    ['ID', 'NAME', 'PRODUCT_ID', 'PRICE', 'QUANTITY']
                );
                while ( $arItem = $dbBasketItems->Fetch() ) {
                    $arItem['PICTURE'] = \PDV\Tools::getPreviewPicture( $arItem['PRODUCT_ID'] );
                    $arItem['ARTICLE'] = \PDV\Tools::getArticleProduct( $arItem['PRODUCT_ID'] );

                    $size = [];
                    $color = '';
                    $db_res = \CSaleBasket::GetPropsList(
                        [ 'sort' => 'asc', 'name' => 'asc' ],
                        [ 'BASKET_ID' => $arItem['ID'] ]
                    );
                    while ( $prop = $db_res->Fetch() )
                    {
                        if ( in_array($prop['CODE'], ['DUZHKA','MOST','LINZA','HEIGHT']) )
                            $size[] = $prop['VALUE'];

                        if ( $prop['CODE'] == 'COLOR' )
                            $color = $prop['VALUE'];
                    }

                    if ( !empty($size) )
                        $arItem['SIZE'] = implode('-',$size);

                    if ( !empty($color) )
                        $arItem['COLOR'] = $color;
                ?>
                    <div class="cart-item">
                        <div class="cart-item-img"><img src="<?=$arItem['PICTURE']?>" alt=""></div>
                        <div class="cart-item-text">
                            <div class="cart-item-info">
                                <?if (!empty($arItem['ARTICLE']) ){?>
                                    <p class="cart-item-info-articul">Артикул: <?=$arItem['ARTICLE']?></p>
                                <? } ?>
                                <p class="cart-item-info-title"><?=$arItem['NAME']?></p>
                                <?if (!empty($arItem['SIZE']) ){?>
                                    <p class="cart-item-info-size">Размер: <?=$arItem['SIZE']?></p>
                                <? } ?>
                                <?if (!empty($arItem['COLOR']) ){?>
                                    <p class="cart-item-info-color">Цвет: <?=$arItem['COLOR']?></p>
                                <? } ?>
                            </div>
                            <div class="cart-item-price">
                                <h3 class="cart-item-price-value"><?=number_format($arItem['PRICE']*$arItem['QUANTITY'],0,'',' ')?><span>₽</span></h3>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="order-info">
                <h3 class="h3 visible-widescreen">Информация о заказе</h3>
                <?
                $db_vals = CSaleOrderPropsValue::GetList(
                    [],
                    [ 'ORDER_ID' => $arResult['ORDER']['ID'] ]
                );
                while ( $arVals = $db_vals->Fetch() ) {
                    if ( in_array($arVals['CODE'], ['RECIPE','CITY','RECIPE_TEXT']) )
                        continue;
                ?>
                    <div class="order-info__item">
                        <p class="label"><?=$arVals['NAME']?>:</p>
                        <p class="value"><?=$arVals['VALUE']?></p>
                    </div>
                <? } ?>
                <br>
                <?
                $deliveryName = '';
                $listShipments = \Bitrix\Sale\Shipment::getList(array(
                    'select' => array(
                        'DELIVERY_NAME'
                    ),
                    'filter' => array('ORDER_ID' => $arResult['ORDER']['ID'])
                ));
                while ( $shipment = $listShipments->fetch() )
                {
                    if (empty($shipment)) {
                        continue;
                    }
                    $deliveryName = $shipment['DELIVERY_NAME'];
                }
                if ( !empty($deliveryName) ):
                ?>
                    <div class="order-info__item">
                        <p class="label">Способ доставки:</p>
                        <p class="value"><?=$deliveryName?></p>
                    </div>
                <?endif;?>
                <?
                $paymentName = '';
                $listPayments = \Bitrix\Sale\Payment::getList(array(
                    'select' => array('PAY_SYSTEM_NAME'),
                    'filter' => array('ORDER_ID' => $arResult['ORDER']['ID'])
                ));
                while ($payment = $listPayments->fetch())
                {
                    $paymentName = $payment['PAY_SYSTEM_NAME'];
                }
                if ( !empty($paymentName) ):
                ?>
                    <div class="order-info__item">
                        <p class="label">Способ оплаты:</p>
                        <p class="value"><?=$paymentName?></p>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>

	<?
	/*if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>
							<br /><br />

							<table class="sale_order_full_table">
								<tr>
									<td class="ps_logo">
										<div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
										<?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
										<div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
										<br/>
									</td>
								</tr>
								<tr>
									<td>
										<? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
										<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
											<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
										<? endif ?>
										<? else: ?>
											<?=$arPaySystem["BUFFERED_OUTPUT"]?>
										<? endif ?>
									</td>
								</tr>
							</table>

							<?
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
					else
					{
						?>
						<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
		<?
	}*/
	?>

    <div class="row">
        <div class="col-12">
            <div class="buy-btn mt-30 mb-30 buy-btn_fullwidth-tablet"><a href="/">Перейти на главную</a></div>
        </div>
    </div>

<? else: ?>

	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
	<br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>

<? endif ?>