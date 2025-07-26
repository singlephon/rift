<?php

namespace Singlephon\Rift\Traits;

use Singlephon\Rift\RiftDispatcher;

trait HasRiftDispatcher
{
    protected RiftDispatcher $rift;

    public function bootHasRiftDispatcher()
    {
        $this->rift = new RiftDispatcher($this);
    }
}
