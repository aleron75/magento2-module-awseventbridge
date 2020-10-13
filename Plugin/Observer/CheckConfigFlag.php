<?php

namespace Bitbull\AWSEventBridge\Plugin\Observer;

use Bitbull\AWSEventBridgeApi\Api\ObserverInterface;
use Bitbull\AWSEventBridgeApi\Api\Service\ConfigInterface;
use Psr\Log\LoggerInterface;

class CheckConfigFlag
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @param LoggerInterface $logger
     * @param ConfigInterface $config
     */
    public function __construct(
        LoggerInterface $logger,
        ConfigInterface $config
    )
    {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * Around observer execute
     *
     * @param ObserverInterface $subject
     * @param callable $proceed
     * @param \Magento\Framework\Event\Observer $observer
     * @return mixed
     */
    public function aroundExecute(ObserverInterface $subject, callable $proceed, \Magento\Framework\Event\Observer $observer)
    {
        $start = microtime(true);
        $eventName = $subject->getEventName();
        $scopeName = $subject->getScopeName();
        $identifier = ($scopeName . '/' ?? '') . $eventName;

        if ($this->config->isEventEnabled($eventName, $scopeName) === false) {
            $this->logger->debug("Event '$identifier' disabled, skipping emitter");
            return null;
        }

        $this->logger->debug("Event '$identifier' captured, executing..");
        try {
            $result = $proceed($observer);
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage(), $exception->getTrace());
            return null;
        }
        $timeElapsedSecs = round(microtime(true) - $start, 3);
        $this->logger->debug("Event '$identifier' executed in ${timeElapsedSecs}s");
        return $result;
    }
}
