<?
namespace PDV\Handlers;

use \Bitrix\Main\Loader,
    \Bitrix\Main\Event,
    \Bitrix\Main\Mail\Event as MailEvent,
    \Bitrix\Sale\Internals\OrderPropsTable,
    \Bitrix\Sale\Internals\OrderPropsValueTable,
    \Bitrix\Sale\Internals\BasketPropertyTable;

class Sale {
    public function orderCancel( Event $event ) {
        $order = $event->getParameter("ENTITY");
        $orderId = $order->GetId();

        $phone = '';
        $rsPropsValue = OrderPropsValueTable::getList(
            array(
                'filter' => array('ORDER_ID' => $orderId, 'CODE' => 'PHONE'),
                'select' => array('CODE', 'VALUE')
            )
        );
        if ( $arPropsValue = $rsPropsValue->fetch() )
            $phone = trim($arPropsValue['VALUE']);


    }

    public function orderPaid( Event $event ) {
        $order = $event->getParameter("ENTITY");
        $orderId = $order->GetId();

        $phone = '';
        $rsPropsValue = OrderPropsValueTable::getList(
            array(
                'filter' => array('ORDER_ID' => $orderId, 'CODE' => 'PHONE'),
                'select' => array('CODE', 'VALUE')
            )
        );
        if ( $arPropsValue = $rsPropsValue->fetch() )
            $phone = trim($arPropsValue['VALUE']);


    }

    public static function orderSaved( Event $event ){
        $order = $event->getParameter('ENTITY');
        $isNew = $event->getParameter('IS_NEW');

        if ( $isNew )
        {
            Loader::includeModule('iblock');
            Loader::includeModule('catalog');
            Loader::includeModule('sale');

            $orderId = $order->GetId();

            $arrProps = array();
            $dbProperties = OrderPropsValueTable::getList(
                array(
                    'filter' => array('ORDER_ID' => $orderId, '!CODE' => 'CITY'),
                    'select' => array('NAME', 'CODE', 'VALUE')
                )
            );
            while ( $arProperty = $dbProperties->fetch() ) {
                $arrProps[ $arProperty['CODE'] ] = $arProperty;
            }

            $strOrderProperty = '';
            $ORDER_USER = '';
            $email = '';
            $dbProperties = OrderPropsTable::getList(
                array(
                    'order' => array('SORT' => 'ASC'),
                    'filter' => array('ACTIVE' => 'Y', '!CODE' => 'CITY', 'PERSON_TYPE_ID' => $order->getField('PERSON_TYPE_ID') ),
                    'select' => array('NAME', 'CODE', 'IS_LOCATION', 'IS_PAYER', 'IS_EMAIL')
                )
            );
            while ( $arProperty = $dbProperties->fetch() ) {
                if ( empty($arrProps[ $arProperty['CODE'] ]['VALUE']) )
                    continue;

                if ( $arProperty['IS_PAYER'] == 'Y' )
                    $ORDER_USER = $arrProps[ $arProperty['CODE'] ]['VALUE'];
                elseif ( $arProperty['IS_EMAIL'] == 'Y' )
                    $email = $arrProps[ $arProperty['CODE'] ]['VALUE'];

                if ( $arProperty['IS_LOCATION'] == 'Y' ) {
                    $values = array();
                    if ($arrProps[$arProperty['CODE']]['VALUE'] > 0) {
                        $resLoc = \Bitrix\Sale\Location\LocationTable::getPathToNodeByCode(
                            $arrProps[$arProperty['CODE']]['VALUE'],
                            array(
                                'select' => array('LNAME' => 'NAME.NAME', 'ID'),
                                'filter' => array('NAME.LANGUAGE_ID' => LANGUAGE_ID)
                            )
                        );
                        while ($arLoc = $resLoc->fetch()) {
                            $values[] = $arLoc['LNAME'];
                        }
                    }
                    $strOrderProperty .= $arProperty['NAME'] . ': ' . implode(', ', $values) . '<br/>';
                }
                else
                    $strOrderProperty .= $arProperty['NAME'].': '.$arrProps[ $arProperty['CODE'] ]['VALUE'].'<br/>';
            }

            $orderDescr = $order->getField('USER_DESCRIPTION');
            if ( !empty($orderDescr) )
                $strOrderProperty .= '<br/>Комментарий к заказу: '.$orderDescr.'<br/>';

            $DELIVERY_NAME = '';
            $deliveryCollection = $order->loadShipmentCollection();
            foreach ($deliveryCollection as $delivery)
            {
                $DELIVERY_NAME = $delivery->getField('DELIVERY_NAME');
            }

            $DELIVERY_PRICE = $order->getDeliveryPrice();
            if ( $DELIVERY_PRICE > 0 )
                $DELIVERY_PRICE .= ' руб.';
            elseif ( $DELIVERY_PRICE == 0 )
                $DELIVERY_PRICE = 'Бесплатно';

            $PAYMENT_NAME = '';
            $paymentCollection = $order->getPaymentCollection();
            foreach ($paymentCollection as $payment)
            {
                $PAYMENT_NAME = $payment->getField('PAY_SYSTEM_NAME');
            }

            $strOrderList = '';
            $basket = \Bitrix\Sale\Order::load($orderId)->getBasket()->getBasketItems();
            foreach ( $basket as $arBasket ) {
                $basketValue = $arBasket->getFieldValues();

                if ( $basketValue['PRODUCT_ID'] > 0 ) {
                    $basketprops = [];
                    $rsBasketProp = BasketPropertyTable::getList([
                        'order' => [
                            'SORT' => 'ASC',
                            'ID' => 'ASC'
                        ],
                        'filter' => [
                            'BASKET_ID' => $basketValue['ID'],
                        ],
                    ]);
                    while ( $arBasketProp = $rsBasketProp->fetch() )
                    {
                        if ( !in_array($arBasketProp['CODE'], ['CATALOG.XML_ID','PRODUCT.XML_ID']) )
                            $basketprops[] = $arBasketProp['NAME'].': '.$arBasketProp['VALUE'];
                    }

                    $strOrderList .= $basketValue['NAME'].' ';
                    if ( !empty($basketprops) )
                        $strOrderList .= '['.implode(';', $basketprops).'] ';

                    $strOrderList .= round($basketValue['QUANTITY']).' шт x '.SaleFormatCurrency($basketValue['PRICE'], $basketValue['CURRENCY']).'<br/>';
                }
            }

            $arFields = array(
                'ORDER_USER' => $ORDER_USER,
                'EMAIL' => $email,
                'ORDER_ID' => $orderId,
                'ORDER_DATE' => trim($order->getDateInsert()),
                'PRICE' => SaleFormatCurrency($order->getPrice(), $order->getCurrency()),
                'ORDER_LIST' => $strOrderList,
                'ORDER_PROPS' => $strOrderProperty,
                'DELIVERY_NAME' => $DELIVERY_NAME,
                'DELIVERY_PRICE' => $DELIVERY_PRICE,
                'PAYMENT_NAME' => $PAYMENT_NAME,
                'SALE_EMAIL' => 'order@chernika-optika.ru'
            );

            MailEvent::send(array(
                'EVENT_NAME' => 'SALE_NEW_ORDER_CUSTOM',
                'LID' => SITE_ID,
                'C_FIELDS' => $arFields,
            ));
        }
    }
}