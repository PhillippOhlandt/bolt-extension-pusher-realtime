<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Event;

use Symfony\Component\EventDispatcher\Event;

class PusherStorageEvent extends Event
{
    private $id;
    private $contenttype;
    private $record;

    protected $channelName;
    protected $createdEventName;
    protected $updatedEventName;
    protected $deletedEventName;

    public function __construct($id, $contenttype, $record)
    {
        $this->id = $id;
        $this->contenttype = $contenttype;
        $this->record = $record;

        $this->channelName = $contenttype;
        $this->createdEventName = 'created';
        $this->updatedEventName = 'updated';
        $this->deletedEventName = 'deleted';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContentType()
    {
        return $this->contenttype;
    }

    public function getRecord()
    {
        return $this->record;
    }


    public function getChannelName()
    {
        return $this->channelName;
    }

    public function getCreatedEventName()
    {
        return $this->createdEventName;
    }

    public function getUpdatedEventName()
    {
        return $this->updatedEventName;
    }

    public function getDeletedEventName()
    {
        return $this->deletedEventName;
    }


    public function setChannelName($value)
    {
        $this->channelName = $value;
    }

    public function setCreatedEventName($value)
    {
        $this->createdEventName = $value;
    }

    public function setUpdatedEventName($value)
    {
        $this->updatedEventName = $value;
    }

    public function setDeletedEventName($value)
    {
        $this->deletedEventName = $value;
    }
}