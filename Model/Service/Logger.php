<?php declare(strict_types=1);

namespace Bitbull\AWSEventBridge\Model\Service;

use Bitbull\AWSEventBridgeApi\Api\Service\LoggerInterface;
use Bitbull\AWSEventBridgeApi\Api\Service\ConfigInterface;
use Magento\Framework\Logger\Monolog;

class Logger implements LoggerInterface
{
    /**
     * @var Monolog|null
     */
    protected $logger = null;

    /**
     * @var boolean
     */
    protected $debugMode;

    /**
     * @param Monolog $logger
     * @param ConfigInterface $config
     */
    public function __construct(Monolog $logger, ConfigInterface $config)
    {
        $this->logger = $logger;
        $this->debugMode = $config->isDebugModeEnabled();
    }

    /**
     * @inheritdoc
     */
    public function logException($exception)
    {
        $this->logger->critical($exception->getMessage(), $exception->getTrace());
    }

    /**
     * @inheritdoc
     */
    public function debug($message, $context = [])
    {
        if ($this->debugMode) {
            $this->logger->debug($message, $context);
        }
    }

    /**
     * @inheritdoc
     */
    public function error($message, $context = [])
    {
        $this->logger->error($message, $context);
    }

    /**
     * @inheritdoc
     */
    public function warn($message, $context = [])
    {
        $this->logger->warn($message, $context);
    }

    /**
     * @inheritdoc
     */
    public function info($message, $context = [])
    {
        $this->logger->info($message, $context);
    }
}
