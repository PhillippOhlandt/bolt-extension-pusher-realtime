<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime;

use Symfony\Component\HttpFoundation\ParameterBag;

class Config extends ParameterBag
{
    /** @var ParameterBag */
    protected $auth;
    /** @var ParameterBag[] */
    protected $contentTypes;
    /** @var string */
    protected $cluster;

    /**
     * Constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct();

        $this->auth = new ParameterBag($config['auth']);

        $this->cluster = $config['cluster'];

        foreach ($config['events'] as $key => $values) {
            $this->contentTypes[$key] = new ParameterBag($values);
        }
    }

    /**
     * Check if configured settings are valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->auth->get('app_id') && $this->auth->get('key') && $this->auth->get('secret');
    }

    /**
     * @return ParameterBag
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return string
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     * @param string $contentType
     *
     * @return ParameterBag
     */
    public function getContentType($contentType)
    {
        return $this->contentTypes[$contentType];
    }

    /**
     * @return ParameterBag[]
     */
    public function getContentTypes()
    {
        return $this->contentTypes;
    }
}
