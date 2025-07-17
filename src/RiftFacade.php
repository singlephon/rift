<?php

namespace Singlephon\Rift;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Singlephon\Rift\Skeleton\SkeletonClass
 */
class RiftFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rift';
    }
}
