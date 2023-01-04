<template>
    <div class="container px-md-5">
        <div class="d-flex flex-column justify-content-center">
            <div class="mt-5 text-center">
                <h1 class="fw-bolder text-center lime-light d-flex flex-column">
                    <img src="/images/logo/mwa.jpg" width="50px" class="me-2">
                    <label>{{ overview.business.name }}</label>
                    <label>{{ overview.customer.service_has_one.name }}</label>
                </h1>
            </div>
            <div class="mt-2 mt-sm-5">
                <div class="d-flex justify-content-center">
                    <div class="card flex-shrink-1">
                        <div class="card-body shadow">
                            <div class="d-flex flex-row border-bottom">
                                <div class="me-2">
                                    <a v-bind:href="'/services/' + overview.customer.service_id"
                                       class="mt-1 btn btn-sm btn-primary text-white mb-2">
                                        <i class="fas fa-arrow-alt-circle-left"></i> Back
                                    </a>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bolder">
                                        Final Step
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Appointment Confirmation</h6>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <h3>
                                        <i class="fas fa-check-circle text-success"></i>
                                        Congratulations {{ overview.customer.name }}!
                                    </h3>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="fw-bolder">Save the date and the CODE for verification of our booking.</p>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="d-flex fs-3">
                                        <u>Please see Below Details.</u>
                                    </div>
                                    <div class="d-flex fs-4">
                                        When:&nbsp;<strong>{{ overview.customer.appointment_has_one.date_appoint }}</strong>
                                        &nbsp;on&nbsp;
                                        <strong>{{ overview.customer.appointment_has_one.time_appoint}}</strong>
                                    </div>
                                    <div class="d-flex fs-4">
                                        Secret Code:&nbsp;<strong>{{ overview.customer.is_verified }}</strong>
                                    </div>
                                    <div v-for="item in other_details" class="d-flex fs-4">
                                        {{ item.field }}:&nbsp;<strong>{{ item.value }}</strong>
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
                other_details: null,
            };
        },
        methods: {},
        mounted() {
            this.other_details = JSON.parse(this.overview.customer.other_details);
        },
    }
</script>
