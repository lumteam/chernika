<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	?>

    <div class="container">
        <div class="row">
        <? foreach ($arResult['ORDERS'] as $key => $order) { ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
                <div class="history-item">
                    <div class="history-item-body">
                        <h3 class="history-item-title"><a href="<?=$arParams['SEF_FOLDER']?><?=$order["ORDER"]['ID']?>/">Заказ №: <?=$order["ORDER"]['ID']?></a></h3>
                        <div class="history-item-block"><span class="label">Дата:</span><span class="value"><?=$order["ORDER"]['DATE_INSERT']?></span></div>
                        <div class="history-item-block"><span class="label">Стоимость:</span><span class="value"><?=number_format($order["ORDER"]['PRICE'],0,'',' ')?> ₽</span></div>
                        <?
                        if ( !empty($order['SHIPMENT']) ){
                            $deliveryName = '';
                            foreach ($order['SHIPMENT'] as $shipment) {
                                if (empty($shipment)) {
                                    continue;
                                }
                                $deliveryName = $shipment['DELIVERY_NAME'];
                            }
                        ?>
                            <div class="history-item-block"><span class="label">Доставка:</span><span class="value"><?=$deliveryName?></span></div>
                        <? } ?>
                        <?
                        $paymentName = '';
                        foreach ($order['PAYMENT'] as $payment)
                        {
                            $paymentName = $payment['PAY_SYSTEM_NAME'];
                        }
                        ?>
                        <div class="history-item-block"><span class="label">Оплата:</span><span class="value"><?=$paymentName?></span></div>
                        <div class="history-item-block"><span class="label">Статус:</span><span class="value"><?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$order["ORDER"]['STATUS_ID']]['NAME'])?></span></div>
                    </div>
                    <div class="history-item-footer">
                        <a href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>" class="repeat-btn">Повторить</a>
                        <a href="#" class="d-none d-xl-inline-flex print-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="19" height="18" viewbox="0 0 19 18">
                                <defs>
                                    <path id="tic5a" d="M492 522c0-1.1.9-2 2-2h15a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-15a2 2 0 0 1-2-2z"></path>
                                    <path id="tic5b" d="M496 530c0-1.1.9-2 2-2h7a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2z"></path>
                                    <path id="tic5c" d="M497 519c0-1.1.9-2 2-2h5a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2z"></path>
                                    <path id="tic5e" d="M505 524a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"></path>
                                    <clippath id="tic5d">
                                        <use fill="#fff" xlink:href="#tic5a"></use>
                                    </clippath>
                                    <clippath id="tic5f">
                                        <use fill="#fff" xlink:href="#tic5b"></use>
                                    </clippath>
                                    <clippath id="tic5g">
                                        <use fill="#fff" xlink:href="#tic5c"></use>
                                    </clippath>
                                </defs>
                                <g>
                                    <g transform="translate(-492 -517)">
                                        <g>
                                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#tic5d&quot;)" xlink:href="#tic5a"></use>
                                        </g>
                                        <g>
                                            <use fill="#979797" xlink:href="#tic5e"></use>
                                        </g>
                                        <g>
                                            <use fill="#fff" xlink:href="#tic5b"></use>
                                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#tic5f&quot;)" xlink:href="#tic5b"></use>
                                        </g>
                                        <g>
                                            <use fill="#fff" xlink:href="#tic5c"></use>
                                            <use fill="#fff" fill-opacity="0" stroke="#979797" stroke-miterlimit="50" stroke-width="4" clip-path="url(&quot;#tic5g&quot;)" xlink:href="#tic5c"></use>
                                        </g>
                                    </g>
                                </g>
                            </svg>Распечатать</a>
                    </div>
                </div>
            </div>
        <? } ?>
        </div>
    </div>
<? } ?>
