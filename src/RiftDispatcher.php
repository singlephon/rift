<?php

namespace Singlephon\Rift;

use Livewire\Component;

class RiftDispatcher
{
    protected Component $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function __call($method, $arguments)
    {
        $this->dispatchToRift($method, $arguments);
    }

    protected function dispatchToRift(string $method, array $arguments = [])
    {
        $this->component->dispatch(
            "rift:call:{$this->component->getId()}",
            method: $method,
            arguments: $arguments
        );
    }
}
