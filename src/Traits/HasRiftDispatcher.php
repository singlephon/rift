<?php

namespace Singlephon\Rift\Traits;

use Livewire\Attributes\Locked;
use Singlephon\Rift\RiftDispatcher;

trait HasRiftDispatcher
{
    #[Locked]
    public array $_component_members_;

    protected RiftDispatcher $rift;

    public function bootHasRiftDispatcher()
    {
        $this->rift = new RiftDispatcher($this);
    }

    public function mountHasRiftDispatcher()
    {
        $this->initComponentMembers();
    }

    private function initComponentMembers(): void
    {
        if (!empty($this->_component_members_)) {
            return;
        }

        $reflection = new \ReflectionClass($this);

        $methods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))
            ->reject(fn($method) => $method->class !== $reflection->getName())
            ->pluck('name')
            ->values()
            ->all();

        $properties = collect($reflection->getProperties(\ReflectionProperty::IS_PUBLIC))
            ->reject(fn($prop) => $prop->class !== $reflection->getName())
            ->pluck('name')
            ->values()
            ->all();

        $this->_component_members_ = [
            'methods' => $methods,
            'properties' => $properties,
        ];
    }
}
