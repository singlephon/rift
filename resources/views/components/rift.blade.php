<div rift="{{ $component }}" x-data="{ rift: {} }" x-init="$nextTick(() => { rift = $el.rift })">
    {{ $slot }}
</div>
