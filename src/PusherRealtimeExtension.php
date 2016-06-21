<?php

namespace Bolt\Extension\Ohlandt\PusherRealtime;

use Bolt\Extension\SimpleExtension;

/**
 * PusherRealtime extension class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class PusherRealtimeExtension extends SimpleExtension
{
    /**
     * Such name, much pretty
     *
     * @return string
     */
    public function getDisplayName()
    {
        return 'Pusher Realtime';
    }
}
