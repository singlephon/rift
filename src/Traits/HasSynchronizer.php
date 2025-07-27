<?php

namespace Singlephon\Rift\Traits;

use Livewire\Attributes\Locked;

trait HasSynchronizer
{
    #[Locked]
    public array $_synchronizer_ = [];

    public function mountHasSynchronizer()
    {
        $this->_synchronizer_ = $this->synchronizer();
    }

    public function synchronizer (): array
    {
        return [
            // ...
        ];
    }
}
