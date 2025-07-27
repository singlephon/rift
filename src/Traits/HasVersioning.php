<?php

namespace Singlephon\Rift\Traits;

use Livewire\Attributes\Locked;
use Singlephon\Rift\Rift;

trait HasVersioning
{
    public function mountHasVersioning()
    {
        $this->rift->_version_(Rift::version());
    }
}
