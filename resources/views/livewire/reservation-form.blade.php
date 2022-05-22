<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" wire:click="resetValues">
        Add Reservation
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reservation Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label for="exampleInputEmail1">Services</label>
                            <select class="form-control" wire:model="serviceId">
                                <option value=""> -- Select Services --</option>
                                @foreach($services as $key => $service)
                                    <option value="{{$service['id']}}">{{ $service['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="exampleInputEmail1">Date for Reserve</label>
                            <input type="date" class="form-control" wire:model="dateAppoint">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="exampleInputEmail1">Slots</label>
                            <input type="number" class="form-control" wire:model="slot">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="storeReserve">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
