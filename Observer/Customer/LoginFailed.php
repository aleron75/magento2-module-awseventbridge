<?php

namespace Bitbull\AWSEventBridge\Observer\Customer;

use Bitbull\AWSEventBridgeApi\Api\Service\ConfigInterface;
use Bitbull\AWSEventBridgeApi\Api\Service\LoggerInterface;
use Bitbull\AWSEventBridge\Model\Service\EventEmitter;
use Bitbull\AWSEventBridge\Observer\BaseObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class LoginFailed extends BaseObserver
{
    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @param LoggerInterface $logger
     * @param ConfigInterface $config
     * @param EventEmitter $eventEmitter
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        LoggerInterface $logger,
        ConfigInterface $config,
        EventEmitter $eventEmitter,
        MessageManagerInterface $messageManager
    )
    {
        parent::__construct($logger, $config, $eventEmitter);
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $postData = $observer->getRequest()->getPost();
        $errorMessages = $this->messageManager->getMessages()->getErrors();

        if (count($errorMessages) === 0) {
            $this->logger->warn('No errors found, skipping ' . $this->getEventName());
            return;
        }

        $this->eventEmitter->send($this->getFullEventName(), [
            'messages' => array_map(static function ($errorMessage) {
                $msg = $errorMessage->getText();
                if ($msg === null || $msg === '') {
                    return $errorMessage->getIdentifier();
                }
                return $msg;
            }, $errorMessages),
            'username' => isset($postData['login']) ? $postData['login']['username'] : null
        ]);
    }
}
