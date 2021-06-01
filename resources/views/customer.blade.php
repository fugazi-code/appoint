@extends('layouts.app')

@section('headers')
    <!-- Full Calendar -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('title')
    My Organization
@endsection

@section('content')
    <div id="app" class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-sm-auto">
                    <a href="#" class="btn text-white btn-success mt-2" @click="showOtherDetailMdl">
                        <i data-feather="sliders"></i> Other Booking Details
                    </a>
                </div>
                <div class="col-12 col-sm-auto">
                    <a href="#" class="btn text-white btn-info mt-2" @click="showOrgMdl">
                        <i data-feather="sliders"></i> Organization Details
                    </a>
                </div>
                <div class="col-12 col-sm-auto">
                    <a href="#" class="btn text-white btn-primary mt-2" @click="showPolicyMdl">
                        <i data-feather="sliders"></i> Booking Policy
                    </a>
                </div>
                <div class="col-12 col-sm-auto">
                    <a href="#" class="btn text-white btn-warning mt-2" @click="showCarbonCopiesMdl">
                        <i data-feather="sliders"></i> Persons to Notify
                    </a>
                </div>
            </div>
        </div>
        {{--        CARBON COPY --}}
        <div id="carbonCopyMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">List of Persons to Notify</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col d-flex flex-row">
                                <label class="mt-1">E-mail</label>
                                <div class="flex-shrink mx-3">
                                    <input type="email" class="form-control" v-model="input_email">
                                </div>
                                <button class="btn btn-success"
                                        @click="addEmail({email: input_email, isActive: 'yes'})">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <ul class="list-group">
                                    <li class="list-group-item p-2" v-for="item in email_list">
                                        <div class="d-flex justify-content-between">
                                            <div class="my-auto">
                                                <span v-if="item.isActive === 'yes'"
                                                      class="badge rounded-pill bg-primary me-1">
                                                    ACTIVE
                                                </span>
                                                <span v-else
                                                      class="badge rounded-pill bg-warning me-1">
                                                    NOT ACTIVE
                                                </span>
                                                @{{ item.email }}
                                            </div>
                                            <div>
                                                <div class="btn-group-sm btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <button type="button" class="btn btn-warning"
                                                            v-if="item.isActive === 'yes'"
                                                            @click="setToNotActive(item)">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary"
                                                            v-else
                                                            @click="setToActive(item)">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                            @click="deleteEmail(item)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{--        OTHER DETAILS--}}
        <div id="otherDetailMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Other Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2" v-for="(item, idx) in other_details">
                            <div class="col-md">
                                <label>Field Name</label>
                                <input type="text" class="form-control" v-model="item.field">
                            </div>
                            <div class="col-md">
                                <label>Type</label>
                                <select class="form-select" v-model="item.type">
                                    <option value="">-- Select Type--</option>
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                    <option value="datetime">Date & Time</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <button class="btn btn-sm btn-danger mt-4" @click="$delete(other_details, idx)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <label class="fs-4" v-if="other_details.length === 0">No Other Details Yet.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info"
                                @click="other_details.push({field: '', type: ''})">
                            Add Field
                        </button>
                        <button type="button" class="btn btn-primary" @click="saveOtherDetails">Save</button>
                    </div>
                </div>
            </div>
        </div>
        {{--        BOOKING POLICY --}}
        <div id="policyMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Booking Policy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col">
                                <textarea rows="8" id="editor">@{{ business.booking_policy }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="savePolicy">Save</button>
                    </div>
                </div>
            </div>
        </div>
        {{--        ORGANIZATION MODAL--}}
        <div id="orgMdl" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Booking Policy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-6 col-sm-4">
                                <label>Name</label>
                                <input class="form-control" v-model="business.name">
                            </div>
                            <div class="col-6 col-sm-4">
                                <label>Website</label>
                                <input class="form-control" v-model="business.website">
                            </div>
                            <div class="col-12">
                            </div>
                            <div class="col-4 col-sm-3">
                                <label>Phone</label>
                                <input class="form-control" v-model="business.phone">
                            </div>
                            <div class="col-4 col-sm-3">
                                <label>E-mail</label>
                                <input class="form-control" v-model="business.email">
                            </div>
                            <div class="col-4 col-sm-3">
                                <label>Facebook</label>
                                <input class="form-control" v-model="business.facebook">
                            </div>
                            <div class="col-12">
                                <label>Address</label>
                                <input class="form-control" v-model="business.address">
                            </div>
                            <div class="col-3">
                                <label>Latitude</label>
                                <input class="form-control" v-model="business.lat">
                            </div>
                            <div class="col-3">
                                <label>Longitude</label>
                                <input class="form-control" v-model="business.long">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="savePolicy">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const e = new Vue({
            el: '#app',
            data: {
                business: {!! $business !!},
                other_details: [],
                otherDetailMdl: null,
                policyMdl: null,
                orgMdl: null,
                myModal: null,
                carbonCopiesMdl: null,
                email_list: [],
                input_email: null
            },
            methods: {
                setToActive(item) {
                    var $this = this;
                    item.isActive = 'yes';
                    $this.addEmail(item);
                },
                setToNotActive(item) {
                    var $this = this;
                    item.isActive = 'no';
                    $this.addEmail(item);
                },
                getCC() {
                    var $this = this;
                    axios.post('{{ route('get.notifiable') }}').then(function (value) {
                        $this.email_list = value.data;
                    });
                },
                deleteEmail(item) {
                    var $this = this;
                    axios.post('{{ route('delete.notifiable') }}', item).then(function (value) {
                        $this.getCC();
                    });
                },
                addEmail(item) {
                    var $this = this;
                    axios.post('{{ route('store.notifiable') }}', item).then(function (value) {
                        $this.input_email = '';
                        $this.getCC();
                    });
                },
                showPolicyMdl() {
                    this.policyMdl.show();
                },
                showOrgMdl() {
                    this.orgMdl.show();
                },
                showCarbonCopiesMdl() {
                    this.carbonCopiesMdl.show();
                },
                showOtherDetailMdl() {
                    var $this = this;
                    $this.other_details = [];
                    $this.otherDetailMdl.show();
                    $this.getOtherDetails();
                },
                getOtherDetails() {
                    var $this = this;
                    axios.post('{{ route('get.other.details') }}').then(function (value) {
                        $this.other_details = value.data;
                    });
                },
                savePolicy() {
                    var $this = this;
                    this.business.booking_policy = tinymce.get("editor").getContent();
                    axios.post('{{ route('business.update') }}', this.business).then(function (value) {
                        Swal.fire(
                            'Success!',
                            'Operation saved.',
                            'success'
                        );
                    });
                },
                saveOtherDetails() {
                    var $this = this;
                    axios.post('{{ route('add.other.details') }}', this.other_details).then(function () {
                        $this.otherDetailMdl.hide()
                    });
                }
            },
            mounted() {
                var $this = this;

                $this.getCC();

                $this.otherDetailMdl = new bootstrap.Modal(document.getElementById('otherDetailMdl'));
                $this.policyMdl = new bootstrap.Modal(document.getElementById('policyMdl'));
                $this.orgMdl = new bootstrap.Modal(document.getElementById('orgMdl'));
                $this.carbonCopiesMdl = new bootstrap.Modal(document.getElementById('carbonCopyMdl'));

                tinymce.init({
                    selector: '#editor',
                    height: 300,
                });
            }
        });

    </script>
@endsection


