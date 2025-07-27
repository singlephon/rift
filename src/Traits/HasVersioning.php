<?php

namespace Singlephon\Rift\Traits;

use Livewire\Attributes\Locked;

trait HasVersioning
{
    #[Locked]
    public string $_version_ = '0.2.1';

    public function mountHasVersioning()
    {
        $this->rift->_version_($this->_version_);
    }
}
