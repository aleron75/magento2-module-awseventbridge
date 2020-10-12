<?php

namespace Bitbull\AWSEventBridge\Observer\Cart;

use Bitbull\AWSEventBridgeApi\Api\Service\ConfigInterface;
use Bitbull\AWSEventBridgeApi\Api\Service\LoggerInterface;
use Bitbull\AWSEventBridge\Model\Service\EventEmitter;
use Bitbull\AWSEventBridge\Observer\BaseObserver as ParentBaseObserver;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;

abstract class BaseObserver extends ParentBaseObserver
{

}
