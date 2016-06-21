<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Listener;

use Bolt\Events\StorageEvent;
use Bolt\Events\StorageEvents;
use Pimple;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StorageEventListener implements EventSubscriberInterface
{
    /** @var Pimple */
    private $app;

    /** @var array */
    private $config;

    /**
     * Initiate the listener with Bolt Application instance and extension config.
     *
     * @param $app
     * @param $config
     */
    public function __construct(Pimple $app, array $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

     /**
      * Handles POST_SAVE storage event
      *
      * @param StorageEvent $event
      */
     public function onPostSave(StorageEvent $event)
     {
         $id = $event->getId();
         $contenttype = $event->getContentType();
         $record = $event->getContent();
         $created = $event->isCreate();
     }

    /**
     * Handles POST_DELETE storage event
     *
     * @param StorageEvent $event
     */
    public function onPostDelete(StorageEvent $event)
    {
        $id = $event->getId();
        $contenttype = $event->getContentType();
        $record = $event->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StorageEvents::POST_SAVE => 'onPostSave',
            StorageEvents::POST_DELETE => 'onPostDelete'
        ];
    }
}
