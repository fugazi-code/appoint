@extends('layouts.app')

@section('title')
    Users Form
@endsection

@section('content')
    <div id="app" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger" role="alert" v-if="errors">
                        <span v-for="item, key in errors">
                            <strong>@{{ key }}</strong>
                            <p v-for="message in item">
                                @{{ message }}
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label>{{ __('Name') }}</label>
                        <input type="text" class="form-control" class="form-control" v-model="overview.name" required
                            autocomplete="name" autofocus>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('E-mail') }}</label>
                        <input type="text" class="form-control" class="form-control" v-model="overview.email" required
                            autocomplete="email" autofocus>
                    </div>
                    @if (!isset($overview))
                        <div class="mb-3">
                            <label>{{ __('Password') }}</label>
                            <input type="password" class="form-control" class="form-control" v-model="overview.password"
                                required autofocus>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('Password Confirmation') }}</label>
                            <input type="password" class="form-control" class="form-control"
                                v-model="overview.password_confirmation" required autofocus>
                        </div>
                        <div class="text-center">
                            <button type="button" @click="register()"
                                class="btn app-btn-primary btn-block theme-btn mx-auto shadow-sm">
                                Submit
                            </button>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="btn-group btn-block" role="group" aria-label="Basic example">
                                <button type="button" @click="update()" class="btn btn-primary btn-block mx-auto shadow-sm">
                                    Update
                                </button>
                                <button type="button" @click="resetPass()"
                                    class="btn btn-warning btn-block mx-auto shadow-sm m-0">
                                    Reset Pass
                                </button>
                                <button type="button" @click="destroy()"
                                    class="btn btn-danger btn-block mx-auto shadow-sm m-0">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endisset
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
            @isset($overview)
                overview: {!! $overview[0] !!},
            @else
                overview: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
                },
            @endisset
            errors: null,
        },
        methods: {
            @isset($overview)
                update() {
                var $this = this;
                axios.put('{{ route('users.update', ['user' => $id]) }}', this.overview).then(function(
                response) {
                $this.errors = null;
                Swal.fire(
                'Success!',
                'Operation saved.',
                'success'
                );
                }).catch(function(reponse) {
                $this.errors = reponse.response.data.errors
                console.log($this.errors)
                });
                },
                destroy() {
                var $this = this;

                Swal.fire({
                title: 'Do you want to DELETE?',
                showDenyButton: true,
                showConfirmButton: false,
                showCancelButton: true,
                denyButtonText: `Delete`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isDenied) {
                axios.delete('{{ route('users.destroy', ['user' => $id]) }}', {})
                .then(function(response) {
                window.location = "{{ route('users.index') }}"
                }).catch(function(reponse) {
                $this.errors = reponse.response.data.errors
                console.log($this.errors)
                });
                }
                });
                },
                resetPass() {
                var $this = this;
                axios.post('{{ route('users.reset.pass') }}', this.overview).then(function(
                response) {
                $this.errors = null;
                Swal.fire(
                'Success!',
                'Operation saved.',
                'success'
                );
                }).catch(function(reponse) {
                $this.errors = reponse.response.data.errors
                console.log($this.errors)
                });
                }
            @else
                register() {
                var $this = this;
                axios.post('{{ route('users.store') }}', this.overview).then(function(response) {
                $this.overview = {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
                };
                $this.errors = null;
                Swal.fire(
                'Success!',
                'Operation saved.',
                'success'
                );
                }).catch(function(reponse) {
                $this.errors = reponse.response.data.errors
                console.log($this.errors)
                });
                },
            @endisset
        },
        mounted() {
            var $this = this;
        }
    });

</script>
@endsection
