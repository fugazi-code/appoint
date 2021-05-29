@extends('layouts.app')

@section('title')
    Abilities
@endsection


@section('content')
    <div class="row g-4 settings-section">
        <div id="app" class="row">
            <div class="col-12 col-md-4">
                <h3 class="section-title">{{ $name }}</h3>
                <div class="section-intro">Please select abilities for this role.</div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card shadow-sm p-4">
                    <div class="card-body">
                        <form class="settings-form">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" value="accounts" v-model="roles">
                                <label class="form-check-label">Accounts</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" value="roles" v-model="roles">
                                <label class="form-check-label">Roles</label>
                            </div>
                            <div class="mt-3">
                                <button @click="saveAbilities" type="button" class="btn btn-primary">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
            </div>
        </div>
        <!--//row-->
    </div>
@endsection


@section('scripts')
    <script>
        const e = new Vue({
            el: '#app',
            data: {
                roles: {!! $abilities !!}
            },
            methods: {
                saveAbilities() {
                    axios.post('{{ route('abilities.save') }}', {
                        name: '{{ $name }}',
                        roles: this.roles
                    }).then(function(value) {
                        Swal.fire(
                            'Success!',
                            'Operation saved.',
                            'success'
                        );
                    });
                }
            }
        });

    </script>
@endsection
