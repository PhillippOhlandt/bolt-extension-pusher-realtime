<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

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
        $this->registerPusherAuthConfigIsset($app);
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
        $app['pusher.config.auth'] = $app->share(
            function () {
                return $this->config['auth'];
            }
        );
    }

    private function registerPusherAuthConfigIsset(Application $app)
    {
        $app['pusher.config.auth.isset'] = $app->share(
            function ($app) {
                return !is_null($app['pusher.config.auth']['app_id']) &&
                !is_null($app['pusher.config.auth']['key']) &&
                !is_null($app['pusher.config.auth']['secret']);
            }
        );
    }

    private function registerPusher(Application $app)
    {
        $app['pusher'] = $app->share(
            function ($app) {
                return new \Pusher(
                    $app['pusher.config.auth']['key'],
                    $app['pusher.config.auth']['secret'],
                    $app['pusher.config.auth']['app_id']
                );
            }
        );
    }
}
