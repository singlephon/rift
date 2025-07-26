<?php

namespace Singlephon\Rift;

use Livewire\Component;
use Singlephon\Rift\Traits\HasRiftDispatcher;
use Singlephon\Rift\Traits\HasSynchronizer;

class RiftComponent extends Component
{
    use HasSynchronizer;
    use HasRiftDispatcher;
}
