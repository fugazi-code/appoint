<template>
    <div class="container px-md-5">
        <div class="d-flex flex-column justify-content-center">
            <div class="mt-5 text-center">
                <h1 class="fw-bolder text-center lime-light"> {{ overview.business.name }}<br>{{ overview.customer.service_has_one.name }}</h1>
            </div>
            <div class="mt-2 mt-sm-5">
                <div class="d-flex justify-content-center">
                    <div class="card flex-shrink-1">
                        <div class="card-body shadow">
                            <div class="d-flex flex-row border-bottom">
                                <div class="me-2">
                                    <a v-bind:href="'/services/' + overview.customer.service_id" class="mt-1 btn btn-sm btn-primary text-white mb-2">
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
                                    <h3><i class="fas fa-check-circle text-success"></i> Congratulations {{ overview.customer.name }}!</h3>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="fw-bolder">Save the date and the CODE for verification of our booking.</p>
                                </div>
                                <div class="col-12 text-center fs-1">
                                    CODE: {{ overview.customer.is_verified }}
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
            };
        },
        methods: {

        },
        mounted() {
        },
    }
</script>
