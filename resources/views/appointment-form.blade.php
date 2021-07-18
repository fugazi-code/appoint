@extends('layouts.app')

@section('headers')
    <!-- Full Calendar -->
    <link href="{{ asset('vendor/fullcalendar/lib/main.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/fullcalendar/lib/main.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
@endsection

@section('title')
    Manage Service and Appointments
@endsection

@section('content')
    <div id="app" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-1">
                    <h3>Service</h3>
                </div>
                <div class="col-9 mb-3">
                    <label class="form-label">Name</label>
                    <input type="email" class="form-control" v-model="service.name">
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Ordering</label>
                    <input type="number" class="form-control" v-model="service.ordering">
                </div>
                <div class="col-12 mb-3">
                    <textarea rows="8" id="editor">@{{ service.desc }}</textarea>
                </div>
                <div class="col-12 mb-2 gap-2">
                    <a class="btn btn-outline-dark" href="{{ route('appointment') }}">Back</a>
                    <button class="btn btn-primary" @click="save">Save</button>
                    @isset($service)
                        <button class="btn btn-danger" @click="destroy">Delete</button>
                    @endisset
                </div>
            </div>
            @isset($service)
                <div class="row">
                    <div class="col-12 mb-1 mt-3">
                        <h3>Appointments</h3>
                    </div>
                    <div class="col-12 mb-3">
                        <div id='calendar'></div>
                    </div>
                </div>
            @endisset
        </div>

        <!-- Schedule -->
        <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label>Date</label>
                                <input v-model="schedule.sched_date" type="date" class="form-control" readonly>
                            </div>
                            <div class="mb-1">
                                <label class="fw-bold">Choose Time</label>
                                <div class="d-flex flex-column flex-md-row">
                                    <div class="p-2 flex-shrink-1">
                                        <div class="input-group mb-1 mb-md-3">
                                            <span class="input-group-text">Time</span>
                                            <input type="time" name="appt-time"
                                                   min="12:00" max="18:00" required
                                                   pattern="[0-9]{2}:[0-9]{2}"
                                                   class="form-control" v-model="time_temp">
                                        </div>
                                    </div>
                                    <div class="p-2 flex-shrink-1">
                                        <div class="input-group mb-1 mb-md-3">
                                            <span class="input-group-text">Slot</span>
                                            <input type="number" v-model="timeslot_count" class="form-control">
                                        </div>
                                    </div>
                                    <div class="p-2 flex-shrink-1">
                                        <div class="input-group mb-1 mb-md-3">
                                            <span class="input-group-text">Interval</span>
                                            <input type="number" v-model="time_interval" class="form-control">
                                        </div>
                                        <div class="form-text">Interval is in minutes...</div>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn btn-sm btn-primary mx-2"
                                                @click="addTimeSlot">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto mt-2" v-for="(item, idx) in schedule.sched_time">
                                <div class="d-flex flex-row" v-if="!item.customer_id">
                                    <input type="time" v-model="item.time_appoint" class="form-control me-1" readonly>
                                    <button @click="removeSchedule(schedule.sched_time, idx)"
                                            class="btn btn-sm btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                                <div class="d-flex flex-row" v-else>
                                    <input type="time" v-model="item.time_appoint" class="form-control" readonly>
                                    &nbsp;<i class="fs-2 fas fa-check-circle text-success mt-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{--                        <button type="button" class="btn btn-primary" @click="saveSchedule">Save changes</button>--}}
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
                editor: null,
                scheduleModal: null,
                calendar: null,
                schedule: {
                    sched_date: '',
                    sched_time: []
                },
                time_temp: '00:00',
                timeslot_count: 1,
                time_interval: 0,
                calendarEl: null,
                service: @isset($service) {!! $service  !!} @else
                {
                    name: '',
                    desc: '',
                }
                @endisset
            },
            methods: {
                addTimeSlot() {
                    var temp = new Date("1970-01-01 " + this.time_temp);
                    var interval = 0
                    for (x = 0; x < this.timeslot_count; x++) {
                        var timer = temp;
                        this.schedule.sched_time.push({
                            'time_appoint': timer.toTimeString().slice(0, 5),
                        });
                        interval = parseFloat(interval) + parseFloat(this.time_interval);
                        temp = new Date("1970-01-01 " + this.time_temp);
                        temp.setMinutes(temp.getMinutes() + interval);
                    }
                    this.saveSchedule();
                },
                removeSchedule(sched_time, idx) {
                    var $this = this;
                    axios.post('{{ route('schedule.delete') }}', sched_time[idx]).then(function () {
                        $this.$delete(sched_time, idx);
                        $this.getAllScheduled();
                    });
                },
                getSchedule(cal_date) {
                    var $this = this;
                    axios.post('{{ route('schedule.get') }}', {
                        cal_date: cal_date,
                        service: this.service.id
                    }).then(function (value) {
                        $this.schedule.sched_time = value.data;
                    })
                },
                saveSchedule() {
                    var $this = this;
                    axios.post('{{ route('schedule.store') }}', {
                        'service': this.service,
                        'schedule': this.schedule
                    }).then(function (value) {
                        // Swal.fire(
                        //     'Success!',
                        //     'Operation saved.',
                        //     'success'
                        // );
                        // $this.scheduleModal.hide();
                        $this.getAllScheduled();
                    }).catch(excp => {
                        catchError(excp)
                    });
                },
                save() {
                    this.service.desc = this.editor.getData();
                    axios.post('{{ route('appointment.store') }}', {'service': this.service}).then(function (value) {
                        Swal.fire(
                            'Success!',
                            'Operation saved.',
                            'success'
                        );
                        window.location = "{{ route('appointment') }}"
                    }).catch(excp => {
                        catchError(excp)
                    }).then(function (value) {
                    });
                },
                destroy() {
                    var $this = this;
                    axios.post('{{ route('appointment.delete') }}', $this.service)
                        .then(function (value) {
                            Swal.fire(
                                'Success!',
                                value.data.success,
                                'success'
                            );
                            window.location = "{{ route('appointment') }}"
                        });
                },
                getAllScheduled() {
                    var $this = this;

                    this.calendar = new FullCalendar.Calendar($this.calendarEl, {
                        initialView: 'dayGridMonth',
                        dateClick: function (value) {
                            $this.schedule.sched_date = value.dateStr;
                            $this.schedule.sched_time = [];
                            $this.getSchedule(value.dateStr);
                            $this.scheduleModal.show();
                        }
                    });

                    $this.calendar.batchRendering(function () {
                        $this.calendar.changeView('dayGridMonth');
                        axios.post('{{ route('schedule.list') }}', $this.service).then(function (value) {
                            value.data.open_slot.forEach(function (item) {
                                $this.calendar.addEvent({title: 'Open Slots ' + item.slot, start: item.date_appoint});
                            });

                            value.data.close_slot.forEach(function (item) {
                                $this.calendar.addEvent({title: 'Booked Slots ' + item.slot, start: item.date_appoint});
                            });
                        });
                    });

                    $this.calendar.render();
                }
            },
            mounted() {
                var $this = this;
                $this.scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'), {
                    keyboard: false
                });
                $this.calendarEl = document.getElementById('calendar');
                ClassicEditor.create(document.querySelector('#editor')).then(newEditor => {
                    $this.editor = newEditor;
                });

                $this.getAllScheduled();
            }
        });
    </script>
    <style>
        .ck-editor__editable {
            min-height: 150px !important;
            max-height: 400px !important;
        }
    </style>
@endsection

