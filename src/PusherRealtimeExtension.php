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
     * @inheritdoc
     *
     * @return array
     */
    protected function registerTwigFunctions()
    {
        return [
            'enable_pusher' => 'enablePusherTwig',
            'pusher_key' => 'pusherKeyTwig',
        ];
    }

    public function enablePusherTwig()
    {
        $config = $this->getContainer()['pusher.config'];

        $html = '';

        if ($config->isValid()) {
            $html .= '<script src="//js.pusher.com/3.1/pusher.min.js"></script>' . PHP_EOL;
            $html .= '<script>' . PHP_EOL;
            $html .= 'var pusherKey = "' . $config->getAuth()->get('key') . '";' . PHP_EOL;
            $html .= 'var pusher = new Pusher(pusherKey, {encrypted: true});' . PHP_EOL;
            $html .= '</script>' . PHP_EOL;
        }

        return new \Twig_Markup($html, 'UTF-8');
    }

    public function pusherKeyTwig()
    {
        $config = $this->getContainer()['pusher.config'];

        return $config->getAuth()->get('key');
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
