@extends('layouts.app')

@section('title')
    Roles
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
                <div class="col-auto">
                    <input id="floatingRoleName" class="form-control" placeholder="Type name of role..."
                        v-model="role_name">
                </div>
                <div class="col-auto">
                    <button @click="newRoleName" type="button" class="btn btn-success text-white">
                        <i class="fa fa-plus"></i> Add New Role
                    </button>
                </div>
                <div class="col-12 overflow-scroll mt-3">
                    <table id="roles-table" class="table"></table>
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
                dt: null,
                role_name: '',
                errors: null
            },
            methods: {
                newRoleName() {
                    var $this = this
                    axios.post('{{ route('roles.store') }}', {
                        role_name: $this.role_name
                    }).then(function(response) {
                        $this.role_name = '';
                        $this.dt.draw();
                        $this.errors = null;
                    }).catch(function(reponse) {
                        $this.errors = reponse.response.data.errors
                        console.log($this.errors)
                    });
                }
            },
            mounted() {
                this.dt = $('#roles-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('roles.table') }}',
                        type: 'POST'
                    },
                    columns: [{
                            data: 'id',
                            title: 'ID'
                        },
                        {
                            data: function(value) {
                                return '<a href="/roles/abilities/' + value.name +
                                    '" class="btn btn-sm btn-link">' + value.name + '</a>'
                            },
                            title: 'Name'
                        },
                        {
                            data: 'title',
                            title: 'Title'
                        },
                        {
                            data: 'created_at',
                            title: 'Date Created'
                        },
                    ]
                });
            }
        });

    </script>
@endsection
