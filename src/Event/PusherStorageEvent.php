<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime\Event;

use Symfony\Component\EventDispatcher\Event;

class PusherStorageEvent extends Event
{
    private $id;
    private $contenttype;
    private $record;
    private $data;

    protected $channelName;
    protected $createdEventName;
    protected $updatedEventName;
    protected $deletedEventName;
    protected $extraData;

    public function __construct($id, $contenttype, $record)
    {
        $this->id = $id;
        $this->contenttype = $contenttype;
        $this->record = $record;

        $this->data = [
            'id' => $id,
            'contenttype' => $contenttype,
            'record' => $record
        ];

        $this->channelName = $contenttype;
        $this->createdEventName = 'created';
        $this->updatedEventName = 'updated';
        $this->deletedEventName = 'deleted';
        $this->extraData = [];
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

    public function getData()
    {
        /** @noinspection AdditionOperationOnArraysInspection */
        return $this->data + $this->getExtraData();
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

    public function getExtraData()
    {
        return $this->extraData;
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

    public function setExtraData($data)
    {
        $this->extraData = $data;
    }

    public function addExtraData($key, $value)
    {
        $this->extraData[$key] = $value;
    }
}