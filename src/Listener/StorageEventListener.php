<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Listener;

use Bolt\Events\StorageEvent;
use Bolt\Events\StorageEvents;
use Bolt\Extension\Ohlandt\PusherRealtime\Event\PusherEvents;
use Bolt\Extension\Ohlandt\PusherRealtime\Event\PusherStorageEvent;
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

        $storageEvent = new PusherStorageEvent($id, $contenttype, $record);
        $this->container['dispatcher']->dispatch(PusherEvents::SET_STORAGE_EVENT_NAMES, $storageEvent);

        $config = $this->container['pusher.config'];
        $data = [
            'id' => $id,
            'contenttype' => $contenttype,
            'record' => $record
        ];

        if ($config->isValid() && $contenttype = $config->getContentType($contenttype)) {
            if ($created) {
                if ($contenttype->get('created')) {
                    $this->container['pusher']->trigger($storageEvent->getChannelName(), $storageEvent->getCreatedEventName(), $data);
                }
            } else {
                if ($contenttype->get('updated')) {
                    $this->container['pusher']->trigger($storageEvent->getChannelName(), $storageEvent->getUpdatedEventName(), $data);
                }
            }
        }
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

        $storageEvent = new PusherStorageEvent($id, $contenttype, $record);
        $this->container['dispatcher']->dispatch(PusherEvents::SET_STORAGE_EVENT_NAMES, $storageEvent);

        $config = $this->container['pusher.config'];
        $data = [
            'id' => $id,
            'contenttype' => $contenttype,
            'record' => $record
        ];

        if ($config->isValid() && $contenttype = $config->getContentType($contenttype)) {
            if ($contenttype->get('deleted')) {
                $this->container['pusher']->trigger($storageEvent->getChannelName(), $storageEvent->getDeletedEventName(), $data);
            }
        }
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
