<div>
    <div class="mt-5">
        <div class="row">
            <div class="col-12 mb-2">
                <div wire:loading.remove>
                    <a href="#" class="btn btn-success" wire:click="reSync">Re-sync my Leads</a>
                </div>
                <div wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="col-auto overflow-auto">
                <livewire:direct-leads-table/>
            </div>
        </div>
    </div>
</div>
