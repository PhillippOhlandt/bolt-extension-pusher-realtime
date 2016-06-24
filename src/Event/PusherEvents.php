<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Event;

class PusherEvents
{
    /**
     * Will be dispatched before triggering the Pusher event
     * for the created, updated or deleted events.
     * Allows to modify the following data:
     * - channel name
     * - event names (created, updated, deleted)
     * - event data itself (only adding additional data)
     */
    const PREPARE_STORAGE_EVENT = 'pusher.event.storage.prepare';
}
