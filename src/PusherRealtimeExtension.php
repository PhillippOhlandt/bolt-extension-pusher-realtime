<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime;

use Bolt\Extension\SimpleExtension;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * PusherRealtime extension class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class PusherRealtimeExtension extends SimpleExtension
{
    public function getServiceProviders()
    {
        return [
            $this,
            new Provider\PusherServiceProvider($this->getConfig()),
        ];
    }

    protected function subscribe(EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addSubscriber(new Listener\StorageEventListener($this->getContainer(), $this->getConfig()));
    }

    /**
     * Such name, much pretty
     *
     * @return string
     */
    public function getDisplayName()
    {
        return 'Pusher Realtime';
    }

    protected function getDefaultConfig()
    {
        return [
            'auth'   => [
                'app_id' => null,
                'key'    => null,
                'secret' => null,
            ],
            'events' => [],
        ];
    }
}
