<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Provider;

use Bolt\Extension\Ohlandt\PusherRealtime\Config;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Pusher service provider.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class PusherServiceProvider implements ServiceProviderInterface
{
    /** @var array */
    private $config;

    /**
     * Service Provider Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $this->registerPusherAuthConfig($app);
        $this->registerPusher($app);
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }

    private function registerPusherAuthConfig(Application $app)
    {
        $app['pusher.config'] = $app->share(
            function () {
                return new Config($this->config);
            }
        );
    }

    private function registerPusher(Application $app)
    {
        $app['pusher'] = $app->share(
            function ($app) {
                /** @var Config $config */
                $config = $app['pusher.config'];

                return new \Pusher(
                    $config->getAuth()->get('key'),
                    $config->getAuth()->get('secret'),
                    $config->getAuth()->get('app_id')
                );
            }
        );
    }
}
