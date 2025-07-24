<?php

namespace Singlephon\Rift\Traits;

use Livewire\Attributes\Locked;

trait HasSynchronizer
{
    #[Locked]
    public array $_synchronizer = [];

    public function mountHasSynchronizer()
    {
        $this->_synchronizer = $this->synchronizer();
    }

    public function synchronizer (): array
    {
        return [
            // ...
        ];
    }
}
