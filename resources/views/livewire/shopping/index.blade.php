<div class="mx-2 mt-2 grid lg:grid-cols-6 sm:grid-cols-4 gap-3">
    @for ($i = 0; $i <= 20; $i++)
        <livewire:shopping.item-list :wire:key="'list-itme' . $i"/>
    @endfor
</div>
