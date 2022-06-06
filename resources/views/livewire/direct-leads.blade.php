<div>
    <div class="mt-5">
        <div class="row">
            <div class="col-12 mb-2">
                <a href="#" class="btn btn-success" wire:click="reSync">Re-sync my Leads</a>
            </div>
            <div class="col-auto overflow-auto">
                <div wire:loading.remove>
                    <livewire:direct-leads-table/>
                </div>
                <div wire:loading>
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>
    </div>
</div>
