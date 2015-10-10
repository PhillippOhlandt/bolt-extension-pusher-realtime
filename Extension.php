<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime;

use Bolt\Application;
use Bolt\BaseExtension;
use Bolt\Events\StorageEvent;
use Bolt\Events\StorageEvents;
use Pusher\Pusher;

class Extension extends BaseExtension
{
    private $pusher;

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Initialize the extension
     *  - Add Twig functions
     *  - Initialize Pusher library
     *  - Add event listeners
     */
    public function initialize()
    {
        $this->addTwigFunction('enablePusher', 'enablePusherTwig');
        $this->addTwigFunction('pusherKey', 'pusherKey');

        if ($this->arePusherKeysSet()) {
            $this->pusher = new Pusher($this->config['pusher_key'], $this->config['pusher_secret'], $this->config['pusher_app_id']);

            $this->app['dispatcher']->addListener(StorageEvents::POST_SAVE, array($this, 'onPostSave'));
            $this->app['dispatcher']->addListener(StorageEvents::POST_DELETE, array($this, 'onPostDelete'));
        }
    }

    /**
     * Check if all Pusher keys are set
     *
     * @return bool
     */
    private function arePusherKeysSet()
    {
        return !is_null($this->config['pusher_app_id']) &&
        !is_null($this->config['pusher_key']) &&
        !is_null($this->config['pusher_secret']);
    }

    /**
     * Handle POST_SAVE storage event
     *
     * @param StorageEvent $event
     */
    public function onPostSave(StorageEvent $event)
    {
        if (!is_null($this->pusher)) {
            $data = [
                'id' => $event->getId(),
                'contenttype' => $event->getContentType(),
                'record' => $event->getContent(),
            ];

            if ($event->isCreate()) {
                if ($this->config['pushed_events']['records']['created']) {
                    $this->pusher->trigger('records', 'created', $data);
                }
            } else {
                if ($this->config['pushed_events']['records']['updated']) {
                    $this->pusher->trigger('records', 'updated', $data);
                }
            }
        }
    }

    /**
     * Handle POST_DELETE storage event
     *
     * @param StorageEvent $event
     */
    public function onPostDelete(StorageEvent $event)
    {
        if (!is_null($this->pusher)) {
            $data = [
                'id' => $event->getContent()['id'], //workaround, getId returns null
                //'contenttype' => $event->getContentType(), //no value
                'record' => $event->getContent(),
            ];

            if ($this->config['pushed_events']['records']['deleted']) {
                $this->pusher->trigger('records', 'deleted', $data);
            }

        }
    }

    /**
     * Twig function to enable Pusher in theme
     *
     * @return \Twig_Markup
     */
    public function enablePusherTwig()
    {
        $html = '';

        if ($this->arePusherKeysSet()) {
            $html .= '<script src="https://js.pusher.com/3.0/pusher.min.js"></script>' . PHP_EOL;
            $html .= '<script>' . PHP_EOL;
            $html .= 'var pusherKey = "' . $this->pusherKey() . '";' . PHP_EOL;
            $html .= 'var pusher = new Pusher(pusherKey, {encrypted: true});' . PHP_EOL;
            $html .= '</script>' . PHP_EOL;
        }

        return new \Twig_Markup($html, 'UTF-8');
    }

    /**
     * Return Pusher public key
     * Also a Twig function
     *
     * @return string
     */
    public function pusherKey()
    {
        return $this->config['pusher_key'];
    }

    /**
     * Extension name
     *
     * @return string
     */
    public function getName()
    {
        return "pusher-realtime";
    }

}






