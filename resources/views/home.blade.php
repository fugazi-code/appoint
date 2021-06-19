@extends('layouts.app')

@section('headers')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection

@section('title')
    Overview
@endsection

@section('content')
    <div id="app" class="card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
        <div class="inner">
            <div class="card-body p-3 p-lg-4">
                <div class="row mt-2">
                    <div class="col-12 col-sm-3">
                        <label>Search Date</label>
                        <input type="text" class="date-range form-control">
                    </div>
                    <div class="col-12 col-sm-3">
                        <label>Code</label>
                        <input type="text" class="form-control" v-model="code">
                    </div>
                    <div class="col-12 col-sm-3">
                        <label>Name of Appointee</label>
                        <input type="text" class="form-control" v-model="appointee">
                    </div>
                    <div class="col-12 ps-2 mt-3">
                        <div class="d-grid">
                            <button class="btn btn-primary shadow" @click="searchAppoint"><i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                        <div class="d-grid mt-1">
                            <button class="btn btn-info shadow" @click="exportMdl.show()">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12" v-for="item in listing">
                        <div class="card border rounded-0 m-1">
                            <div class="d-flex flex-column flex-sm-row p-2">
                                <div class="d-flex flex-column flex-shrink ms-2 pe-3 border-end">
                                    <div class="text-left text-sm-center fs-1 text-info">@{{ item.day }}</div>
                                    <div class="text-left text-sm-center fs-3">@{{ item.day_name }}</div>
                                </div>
                                <div class="flex-shrink fw-bolder ms-3 mt-2 pe-3 border-end">
                                    <div class="text-center">@{{ item.has_one_service.name }}</div>
                                    <div class="text-muted text-center text-sm-start">@{{ item.time_format }}</div>
                                </div>
                                <div class="flex-shrink fw-bolder ms-3 mt-2 pe-3 border-end" v-if="item.customer_id">
                                    <div class="">
                                        <button @click="showDetails(item)" class="btn btn-link fw-bolder p-0">@{{
                                            item.has_one_customer.name }}
                                        </button>
                                    </div>
                                    <div class="">Verified: @{{ item.has_one_customer.is_verified }}</div>
                                    <div class="text-muted"><span class="badge rounded-pill bg-success">Booked</span>
                                    </div>
                                    <button class="btn btn-sm btn-danger" @click="cancelBooking(item)">
                                        <i class="fas fa-ban"></i>
                                        Cancel this Booking
                                    </button>
                                </div>
                                <div
                                    class="d-flex flex-sm-column flex-row flex-shrink fw-bolder ms-3 mt-2 pe-3 border-end"
                                    v-else>
                                    <div class="">Open Slot</div>
                                    <div class="text-muted ms-3 ms-sm-0">
                                        <span class="badge rounded-pill bg-warning">Not Booked</span>
                                    </div>
                                </div>
                                <div class="flex-shrink fw-bolder ms-3 mt-2" v-if="item.customer_id">

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--//row-->
            </div><!--//app-card-body-->

        </div><!--//inner-->

        {{--      Cancel Booking Modal--}}
        <div id="cancelBookingMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Other Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label>Message</label>
                                <textarea class="form-control" rows="6" v-model="message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" @click="cancelBookConf">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>

        {{--      Show Details Modal--}}
        <div id="showDetailsMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Other Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-if="item != null">
                            <div class="col">
                                <div class="row border-bottom">
                                    <div class="col">
                                        <label class="fw-bolder">Name</label>
                                    </div>
                                    <div class="col">
                                        <label class="">@{{ item.has_one_customer.name }}</label>
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col">
                                        <label class="fw-bolder">Phone</label>
                                    </div>
                                    <div class="col">
                                        <label class="">@{{ item.has_one_customer.phone }}</label>
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col">
                                        <label class="fw-bolder">E-mail</label>
                                    </div>
                                    <div class="col">
                                        <label class="">@{{ item.has_one_customer.email }}</label>
                                    </div>
                                </div>
                                <div class="row border-bottom"
                                     v-for="(value, idx) in JSON.parse(item.has_one_customer.other_details)">
                                    <div class="col">
                                        <label class="fw-bolder">@{{ value.field }}</label>
                                    </div>
                                    <div class="col">
                                        <label class="">@{{ value.value }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" @click="cancelBookConf">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>

        {{--      Export Modal--}}
        <div id="exportMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filtered By</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="fw-bolder">Date</label>
                                <input type="date" class="form-control" v-model="date_export">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="fw-bolder">Service</label>
                                <select class="form-control" v-model="service_selected">
                                    <option v-for="(item, idx) in services" v-bind:value="item.id">@{{ item.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="exportFile">Export</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!--//app-card-->
@endsection

@section('scripts')
    <script>
        const e = new Vue({
            el: '#app',
            data() {
                return {
                    services: [],
                    listing: [],
                    service_selected: '',
                    start_date: '',
                    end_date: '',
                    code: '',
                    appointee: '',
                    message: '',
                    date_export: '',
                    cancelBookingMdl: null,
                    showDetailsMdl: null,
                    exportMdl: null,
                    item: null
                }
            },
            methods: {
                exportFile() {
                    window.location = '/export/scheduled/'+ this.date_export + '/' + this.service_selected
                },
                showDetails(item) {
                    var $this = this;
                    $this.item = item;
                    $this.showDetailsMdl.show()
                },
                cancelBooking(item) {
                    var $this = this;
                    $this.item = item;
                    $this.cancelBookingMdl.show();
                },
                cancelBookConf() {
                    var $this = this;
                    axios.post('{{ route('cancel.booking') }}', {item: $this.item, message: $this.message})
                        .then(function () {
                            $this.cancelBookingMdl.hide();
                            $this.searchAppoint();
                        })
                },
                getServices() {
                    var $this = this;
                    axios.post('{{ route('home.services') }}')
                        .then(function (value) {
                            $this.services = value.data;
                            $this.service_selected = value.data[0]['id'];
                        });
                },
                searchAppoint() {
                    var $this = this;
                    axios.post('{{ route('home.search') }}', {
                        start_date: this.start_date,
                        end_date: this.end_date,
                        code: this.code,
                        appointee: this.appointee,
                    }).then(function (value) {
                        $this.listing = value.data.data;
                    });
                }
            },
            mounted() {
                var $this = this;
                var date = new Date();

                $this.start_date = date.toISOString().slice(0, 10);
                date.setDate(date.getDate() + 7);
                $this.end_date = date.toISOString().slice(0, 10);
                $this.searchAppoint();
                $this.getServices();

                $('.date-range').daterangepicker({
                    opens: 'left',
                    endDate: date,
                }, function (start, end, label) {
                    $this.start_date = start.format('YYYY-MM-DD');
                    $this.end_date = end.format('YYYY-MM-DD');
                });

                $this.cancelBookingMdl = new bootstrap.Modal(document.getElementById('cancelBookingMdl'), {
                    keyboard: false
                });

                $this.showDetailsMdl = new bootstrap.Modal(document.getElementById('showDetailsMdl'), {
                    keyboard: false
                });

                $this.exportMdl = new bootstrap.Modal(document.getElementById('exportMdl'), {
                    keyboard: false
                });
            }
        })
    </script>
@endsection
