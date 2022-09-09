@extends('layout2')
@section('title', 'Admin:: '.Auth::user()->name)
@section('content')
<!-- <script src="{{ asset('public/js/app.js') }}" defer></script>
<link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> -->
<!-- <div id="app">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <datatable-component></datatable-component>
            </div>
        </div>
    </div>
</div> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css" integrity="sha512-XWTTruHZEYJsxV3W/lSXG1n3Q39YIWOstqvmFsdNEEQfHoZ6vm6E9GK2OrF6DSJSpIbRbi+Nn0WDPID9O7xB2Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>







<style>
    .main {
        width: 80%;
        margin: auto;
    }

    .table {
        margin-top: 30px;
    }

    .todoListContainer {
        width: 350px;
        margin: auto;
    }

    .heading {
        background: #e6e6e6;
        padding: 10px;
    }

    #title {
        text-align: center
    }

    .green {
        color: green
    }

    .red {
        color: red
    }
</style>

<div class="main" id="app">

    {{Auth::user()->name}}
    (Admin)
    <a href="{{url('logout')}}" class="button tiny red log-button">
        Logout
    </a>

    <div>
        <a href="{{url('admin')}}">Dashboard</a> |
        <a href="inbox">Inbox</a> |
        <a href="task-categories">Task Categories</a>
    </div>

    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">List of Users</h2>

        </div>

    </div>

    <div class="table">
        <table id="datatable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Member Since</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)

                @if($user->status == True)

                @php $status = 'Active' @endphp
                @php $class_tag = 'label label-success' @endphp
                @else

                @php $status = 'Pending' @endphp
                @php $class_tag = 'label label-warning' @endphp
                @endif

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->created_at->diffForHumans()}}</td>
                    <td id="title">
                        <span v-if="feedback === {{$user->id}}">
                            <span v-if="label === 'Active'" :class="['label label-success']">@{{label}}</span>
                            <span v-else :class="['label label-warning']">@{{label}}</span>
                        </span>
                        <span v-else class="{{$class_tag}}">{{ $status }}</span>
                    </td>
                    <td id="title">
                        @if($user->status == True)
                        <span v-if="feedback === {{$user->id}}">
                            <button class="btn btn-xs btn-danger" class="" @click="deactivateUser({{$user->id}})">Activate
                            </button>
                        </span>
                        <span v-else>

                            <button class="btn btn-xs btn-success" class="" @click="deactivateUser({{$user->id}})">Deactivate
                            </button>
                        </span>
                        @else
                        <span v-if="feedback === {{$user->id}}">
                            <button class="btn btn-xs btn-success" class="" @click="activateUser({{$user->id}})">Deactivate
                            </button>
                        </span>
                        <span v-else>

                            <button class="btn btn-xs btn-danger" class="" @click="activateUser({{$user->id}})">Activate
                            </button>
                        </span>
                        @endif

                        <button class="btn btn-danger btn-xs delete{{$user->id}}" @click="deleteUser({{$user->id}})">
                            <span class="fas fa-trash-alt mr-2" style='cursor:pointer;'></span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    
</div>

<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            responsive: true
        });

        new $.fn.dataTable.FixedHeader(table);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script type="text/javascript">
   
    new Vue({
        el: '#app',
        data() {
            return {
                isActive: false,
                users: [],
                feedback: 0,
                label: '',
            }


        },
        mounted() {
            window.axios.get('users').then(res => {
                this.users = res.data
            })
        },
        methods: {
            activateUser(id) {
                console.log(id);
                axios.put('{{url("update_user_status")}}/' + id, {

                    })
                    .then(response => {
                        if (response.data.res == id) {
                            this.feedback = id;
                            this.label = response.data.label;
                            console.log(this.label);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            deactivateUser(id) {
                console.log(id);
                axios.put('{{url("update_user_status")}}/' + id, {

                    })
                    .then(response => {
                        if (response.data.res == id) {
                            console.log(id);
                            this.feedback = id;
                            this.label = response.data.label;
                            console.log(this.label);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            deleteUser(id) {
                $.confirm({
                    title: 'Delete',
                    content: 'Are you sure you want to delete this user?',
                    buttons: {
                        Yes: {
                            text: 'Yes',
                            btnClass: 'btn-danger',
                            action: function() {
                                axios.delete('{{url("deleteUser")}}/' + id)
                                .then(response => {
                                        if (response.data.res == 1) {
                                            $('.delete'+id).closest('tr').css('background', 'red');
                                            $('.delete'+id).closest('tr').fadeOut(800, function() {
                                                $(this).remove();
                                            });
                                        } else {
                                            alert('Invalid Selection.');
                                        }
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    })
                                    setInterval('location.reload()', 1000);
                            }
                        },
                        cancel: function() {

                        }
                    }
                });
            }
        },
        

    });
</script>
@endsection