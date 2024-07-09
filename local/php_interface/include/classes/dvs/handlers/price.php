<?php

namespace DVS\Handlers;

use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Sale\BasketItem;

class Price
{

    public static function setPriceProvider(Event $event)
    {
        $entity = $event->getParameter('ENTITY');

        if (false === $entity instanceof BasketItem) {
            return new EventResult(EventResult::ERROR, null, 'sale');
        }

        $entity->setField('PRODUCT_PROVIDER_CLASS', '\DVS\Provider\Custom');

        return new EventResult(EventResult::SUCCESS);
    }

}