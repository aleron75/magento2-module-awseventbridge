<?php

namespace Bitbull\AWSEventBridge\Observer\Cart;

use Bitbull\AWSEventBridgeApi\Api\Service\ConfigInterface;
use Bitbull\AWSEventBridge\Model\Service\EventEmitter;
use Bitbull\AWSEventBridge\Observer\BaseObserver as ParentBaseObserver;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

abstract class BaseObserver extends ParentBaseObserver
{

}
