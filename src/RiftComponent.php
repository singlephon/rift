<?php

namespace Singlephon\Rift;

use Livewire\Component;
use Singlephon\Rift\Traits\HasRiftDispatcher;
use Singlephon\Rift\Traits\HasSynchronizer;
use Singlephon\Rift\Traits\HasVersioning;

class RiftComponent extends Component
{
    use HasSynchronizer;
    use HasRiftDispatcher;
    use HasVersioning;
}
