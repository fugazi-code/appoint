<template>
    <div class="container px-md-5">
        <div class="d-flex flex-column justify-content-center">
            <div class="mt-5">
                <h1 class="fw-bolder text-center lime-light">
                    <img src="/images/logo/mwa.jpg" width="50px" class="me-2">
                    Appointments
                </h1>
            </div>
            <div class="mt-2 mt-sm-5">
                <div class="d-flex justify-content-center">
                    <!-- STEP 1-->
                    <div v-show="step === 1" class="card flex-shrink-1">
                        <div class="card-body shadow">
                            <div class="d-flex flex-row border-bottom">
                                <div class="me-2">
                                    <a v-bind:href="'/services/' + overview.service.created_by"
                                       class="mt-1 btn btn-sm btn-primary text-white mb-2">
                                        <i class="fas fa-arrow-alt-circle-left"></i> Back
                                    </a>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bolder">
                                        Step 1
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Date and Time</h6>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label>Choose your preferred date:</label>
                                    <input id="txtDate" type="date" class="form-control" v-model="input_date"
                                           @change="getSlots">
                                </div>
                                <div class="col mt-3">
                                    <ol class="list-group list-group-numbered">
                                        <li class="list-group-item d-flex fw-bold fs-5">
                                            <i class="fas fa-clock mt-1 me-2"></i> Time Slots
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start"
                                            v-for="(item, key) in time_slots">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">{{ item.time_appoint }}</div>
                                            </div>
                                            <button v-if="!item.customer_id && (key + 1) > rs" class="btn btn-sm btn-outline-success py-0"
                                                    @click="reserve(item.id, item.date_appoint)">Reserve
                                            </button>
                                            <div v-else>
                                                {{ item.time_appoint_booked }}
                                                <div class="fw-bold"><i class="fas fa-ban text-danger"></i> Closed</div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- STEP 2-->
                    <div v-show="step === 2" class="card flex-shrink-1 w-auto">
                        <div class="card-body shadow">
                            <div class="d-flex flex-row border-bottom">
                                <div class="me-2">
                                    <a href="#" @click="step = 1" class="mt-1 btn btn-sm btn-primary text-white mb-2">
                                        <i class="fas fa-arrow-alt-circle-left"></i> Back
                                    </a>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bolder">
                                        Step 2
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Information</h6>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 mt-1">
                                    <label>Full Name</label>
                                    <input class="form-control" v-model="reservation.name"
                                           v-bind:class="{'is-valid':reservation.name, 'is-invalid':!reservation.name, }">
                                </div>
                                <div class="col-6 mt-1">
                                    <label>E-mail</label>
                                    <input class="form-control" v-model="reservation.email"
                                           v-bind:class="{'is-valid':reservation.email, 'is-invalid':!reservation.email, }">
                                </div>
                                <div class="col-6 mt-1">
                                    <label>Contact Number</label>
                                    <input class="form-control" v-model="reservation.phone"
                                           v-bind:class="{'is-valid':reservation.phone, 'is-invalid':!reservation.phone, }">
                                </div>
                                <div class="col-6 mt-1" v-for="item in reservation.other_details">
                                    <label>{{ item.field }}</label>
                                    <input v-bind:type="item.type" class="form-control" v-model="item.value">
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="d-grid">
                                        <button class="btn btn-success text-white" @click="confirmAndSubmit">Confirm &
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- STEP 3-->
                    <div v-show="step >= 3" class="card flex-shrink-1 w-auto">
                        <div class="card-body shadow">
                            <div class="d-flex flex-row border-bottom">
                                <div class="me-2">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bolder">
                                        Step 3
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Verification</h6>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 mt-1 text-center">
                                    <img width="250"
                                         src="https://images.vexels.com/media/users/3/157931/isolated/preview/604a0cadf94914c7ee6c6e552e9b4487-curved-check-mark-circle-icon-by-vexels.png">
                                </div>
                                <div class="col-12 mt-1 text-center">
                                    <h3>We have send verification to your E-mail</h3>
                                    <p>Find the confirmation link on your E-mail to complete your Booking.</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="d-grid">
                                        <button class="btn btn-info text-white" @click="confirmAndSubmit">Resend
                                            Resend E-mail Verification
                                        </button>
                                        <a v-bind:href="'/services/1'"
                                           class="btn btn-outline-dark mt-2">Back
                                            to Services</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            step: 1,
            overview: JSON.parse(this.$props.data),
            input_date: null,
            time_slots: [],
            other_details: [],
            reservation: {
                service_id: null,
                appoint_id: null,
                name: '',
                email: '',
            },
            submitted: 0,
            rs: 0,
        };
    },
    methods: {
        confirmAndSubmit() {
            let $this = this;
            if ($this.reservation.name == '' || $this.reservation.email == '' || $this.reservation.phone == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please fill all required fields.',
                    html: 'Please try again!',
                });
                return false;
            }
            if ($this.submitted === 0) {
                axios.post(this.overview.reserve_checking_link, this.reservation)
                    .then(function (value) {
                        if (value.data === 'none') {
                            $this.submitted = 1;
                            axios.post($this.overview.reserve_link, $this.reservation)
                                .then(function (value) {
                                    if ($this.step === 3) {
                                        $this.step += 4
                                    } else {
                                        $this.step = 3;
                                    }
                                });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Please see your E-mail!',
                                html: '<br>We need you to press the "Click Here" link' +
                                    '<br>inside the E-mail',
                            });
                        }
                    });
            }
        },
        getOtherDetails() {
            var $this = this;
            axios.post(this.overview.other_details_link).then(function (value) {
                $this.other_details = value.data.data;
                $this.reservation['other_details'] = value.data.data;
            });
        },
        reserve(id, appoint_date) {
            this.step = 2;
            this.reservation.appoint_id = id;
            this.reservation.date_appoint = appoint_date;
        },
        getSlots() {
            var $this = this;
            axios.post(this.overview.slots_link, {
                'input_date': this.input_date,
                'service': this.overview.id
            }).then(function (value) {
                $this.time_slots = value.data.scheds.data;
                $this.rs = value.data.rs
            });
        }
    },
    mounted() {
        this.input_date = new Date().toISOString().slice(0, 10);
        this.getSlots();
        this.reservation.service_id = this.overview.id;
        this.getOtherDetails();

        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#txtDate').attr('min', maxDate);
    },
}
</script>
