<?php

namespace Yansongda\Pay\Service;

use Pimple\Container;
use Yansongda\Pay\Contract\ServiceInterface;
use Yansongda\Pay\Contract\ServiceProviderInterface;
use Yansongda\Supports\Config;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * baseConfig.
     *
     * @var array
     */
    private $baseConfig = [
        'log' => [
            'enable' => true,
            'file' => null,
            'level' => 'debug',
            'type' => 'daily',
            'max_files' => 30,
        ],
        'http' => [
            'timeout' => 5.0,
            'connect_timeout' => 3.0,
        ],
        'mode' => 'normal',
    ];

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = function ($container) {
            /* @var \Yansongda\Pay\Pay $container */
            $config = array_replace_recursive($this->baseConfig, $container->getUserConfig());
            $config['log']['identify'] = 'yansongda.pay';

            return new class($config) extends Config implements ServiceInterface {
            };
        };
    }
}
