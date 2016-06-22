<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Listener;

use Bolt\Events\StorageEvent;
use Bolt\Events\StorageEvents;
use Pimple as Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StorageEventListener implements EventSubscriberInterface
{
    /** @var Container */
    private $container;

    /** @var array */
    private $config;

    /**
     * Initiate the listener with Bolt Application instance and extension config.
     *
     * @param Container $container
     * @param $config
     */
    public function __construct(Container $container, array $config)
    {
        $this->container = $container;
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
