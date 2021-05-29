@extends('layouts.app')

@section('title')
    Accounts
@endsection

@section('content')
    <div id="app" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-auto mb-3">
                    <a href="{{ route('users.create') }}" class="btn text-white btn-success">
                        <i class="fa fa-plus"></i> Add New User
                    </a>
                </div>
                <div class="col-12 overflow-scroll">
                    <table id="user-table" class="table"></table>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Set Role</h5>
                        <button @click="myModal.hide()" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Roles</label>
                                    <select class="form-control" v-model="overview.role_name">
                                        <option value="">-- Not Set --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="saveRole()">Save</button>
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
                dt: null,
                myModal: null,
                overview: {
                    role_name: null
                },
            },
            methods: {
                saveRole() {
                    var $this = this;
                    axios.post('{{ route('assign.role') }}', this.overview).then(function(params) {
                        $this.dt.draw()();
                    });
                    $this.myModal.hide();
                }
            },
            mounted() {
                var $this = this;

                $this.dt = $('#user-table').DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('users.table') }}',
                        type: 'POST'
                    },
                    order: [0, 'desc'],
                    columns: [{
                            data: 'id',
                            title: 'ID'
                        },
                        {
                            data: function(value) {
                                return '<a href="users/' + value.id +
                                    '" class="btn btn-sm btn-link">' + value.name + '</button>'
                            },
                            title: 'Name'
                        },
                        {
                            data: 'email',
                            title: 'E-mail'
                        },
                        {
                            data: function(value) {
                                if (value.role_title != true) {
                                    return '<span class="roleModal badge bg-primary">' +
                                        value.role_title +
                                        '</span>'
                                }
                                return '<span class="roleModal badge bg-danger">Not Set</span>'
                            },
                            title: 'Role Title'
                        },
                        {
                            data: 'created_at',
                            title: 'Date Created'
                        },
                    ],
                    "drawCallback": function(settings) {
                        $('tbody').on('click', 'tr', function() {
                            $this.overview = $this.dt.row(this).data();
                        });

                        $this.myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                            keyboard: false
                        });

                        $('.roleModal').click(function() {
                            $this.myModal.show()
                        });
                    }
                });
            }
        });

    </script>
@endsection
