@extends('layouts.app')

@section('title')
    Settings
@endsection

@section('content')
    <div id="app" class="row">
        <div class="col-12 col-md-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold fs-4">Profile Settings</h5>
                </div>
                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account"
                       role="tab">
                        Account
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
                        Password
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#delete" role="tab">
                        Delete account
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title fw-bold fs-4">Public info</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.update', ['setting' => auth()->id()]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="inputUsername">E-mail</label>
                                                    <input type="text" class="form-control"
                                                           value="{{ auth()->user()->email }}" name="email" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label" for="inputUsername">Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                           value="{{ auth()->user()->name }}">
                                                </div>
                                            </div>
                                            {{-- <div class="mb-3">
                                                <label class="form-label" for="inputUsername">Biography</label>
                                                <textarea rows="2" class="form-control" name="biography"></textarea>
                                            </div> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="text-center">
                                            <img alt="{{ auth()->user()->name }}" src="https://i.pravatar.cc/128"
                                                class="rounded-circle img-responsive mt-2 shadow" width="128"
                                                height="128" />
                                            <div class="mt-2">
                                                <div class="mb-3">
                                                    <input class="form-control form-control-sm" id="formFileSm" type="file">
                                                </div>
                                                <button class="btn btn-primary">Upload</button>
                                            </div>
                                            <small>For best results, use an image at least 128px by 128px in .jpg
                                                format</small>
                                        </div>
                                    </div> --}}
                                </div>

                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Private info</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="inputFirstName">First name</label>
                                        <input type="text" class="form-control" id="inputFirstName"
                                            placeholder="First name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="inputLastName">Last name</label>
                                        <input type="text" class="form-control" id="inputLastName" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputAddress">Address</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputAddress2">Address 2</label>
                                    <input type="text" class="form-control" id="inputAddress2"
                                        placeholder="Apartment, studio, or floor">
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="inputCity">City</label>
                                        <input type="text" class="form-control" id="inputCity">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="inputState">State</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label class="form-label" for="inputZip">Zip</label>
                                        <input type="text" class="form-control" id="inputZip">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>

                        </div>
                    </div> --}}

                </div>
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title fw-bold fs-4">Password</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="inputPasswordCurrent">Current password</label>
                                <input type="password" class="form-control" name="password"
                                       v-model="password_form.password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputPasswordNew">New password</label>
                                <input type="password" class="form-control" name="new_password"
                                       v-model="password_form.new_password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputPasswordNew2">Verify password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       v-model="password_form.password_confirmation">
                            </div>
                            <button type="button" class="btn btn-primary shadow" @click="changePass">Save changes
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="delete" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-4">Delete Account</h5>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-auto">
                                        <label class="form-label" for="inputPasswordCurrent">Password</label>
                                        <input type="password" class="form-control" name="password"
                                               v-model="password_form.password">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger shadow" @click="deletaAccount">Delete Account
                            </button>
                        </div>
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
                password_form: {
                    password: '',
                    new_password: '',
                    password_confirmation: ''
                }
            },
            methods: {
                changePass() {
                    var $this = this;
                    axios.post('{{ route('settings.change.pass') }}', $this.password_form)
                        .then(params => {
                            Swal.fire(
                                'Success!',
                                'Operation saved.',
                                'success'
                            );
                        }).catch(excp => {
                        catchError(excp)
                    }).then(params => {
                        $this.password_form = {
                            password: '',
                            new_password: '',
                            password_confirmation: ''
                        };
                    });
                },
                deletaAccount() {
                    var $this = this;
                    axios.post('{{ route('settings.delete.account') }}', $this.password_form)
                        .then(params => {
                            Swal.fire(
                                'Success!',
                                'Operation saved.',
                                'success'
                            );
                        }).catch(excp => {
                        catchError(excp)
                    }).then(params => {
                        $this.password_form = {
                            password: '',
                            new_password: '',
                            password_confirmation: ''
                        };
                    });

                }
            },
            mounted() {

            }
        });

    </script>
@endsection
