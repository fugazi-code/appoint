<div>
    <div class="row mt-5">
        <div class="col-md-4">
            <label for="exampleInputEmail1">Services</label>
            <select class="form-control" wire:model="serviceId">
                    <option value=""> -- Select Services -- </option>
                @foreach($services as $key => $service)
                    <option value="{{$service['id']}}">{{ $service['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="exampleInputEmail1">
                Open Slots <span class="badge badge-pill badge-warning">{{ count($openSlots) }}</span>
                <div class="spinner-border" role="status" wire:loading>
                    <span class="sr-only">Loading...</span>
                </div>
            </label>
            <select class="form-control" wire:model="appointId">
                <option value=""> -- Select Slots -- </option>
                @foreach($openSlots as $key => $slot)
                    <option value="{{$slot['id']}}">{{ \Carbon\Carbon::make($slot['date_appoint'])->format('l - F j, Y') }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <div class="row mt-3">
                <div class="col-6 mt-1">
                    <label>Full Name</label>
                    <input class="form-control" wire:model="name">
                </div>
                <div class="col-6 mt-1">
                    <label>E-mail</label>
                    <input class="form-control" wire:model="email">
                </div>
                <div class="col-6 mt-1">
                    <label>Contact Number</label>
                    <input class="form-control" wire:model="phone">
                </div>
                <div class="col-6 mt-1">
                    <label>CR Number</label>
                    <input class="form-control" wire:model="cr_no">
                </div>
                <div class="col-6 mt-1">
                    <label>Iqama</label>
                    <input class="form-control" wire:model="iqama">
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary" wire:click="reserve">Submit</button>
            <button type="submit" class="btn btn-warning" wire:click="refreshAppointment">Refresh Appointments</button>
        </div>
    </div>
    <div class="row mt-5">
        <livewire:reservation-table/>
    </div>
    <div class="row mt-5">
        <livewire:reservation-form/>
    </div>
</div>
