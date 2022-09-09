@extends('layout2')
@section('title', 'Admin:: '.Auth::user()->name)
@section('content')


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




<!-- modal -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
        <a href="users">All Users</a>
    </div>

    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Task Categories</h2>

        </div>

    </div>

    <a class="btn btn-sm btn-warning" href="tasks">
        Submitted Tasks
    </a>

    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newCategoryModal">
        Create New Category
    </button>

    <div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCategoryModalLabel">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span v-if="success" :class="['label label-success']">Category Created!</span>
                    <form method="POST" action="{{url('create_category')}}" @submit.prevent="onSubmit">
                        {{ csrf_field() }}
                        <div class="form-group" :class="['form-group', allerros.title ? 'has-error' : '']">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="title" v-model="form.title">
                            <span v-if="allerros.title" :class="['label label-danger']">@{{ allerros.title[0] }}</span>
                        </div>
                        <div :class="['form-group', allerros.status ? 'has-error' : '']">
                            <input type="checkbox" name="status" id="status" class="status" v-model="form.status" />
                            <label for="status" class="label-status"><span><span></span></span>Status (Status is deactivated on default)</label>
                            <span v-if="allerros.status" :class="['label label-danger']">@{{ allerros.status[0] }}</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="table">
        <table id="datatable" class="table table-striped table-bordered nowrap" style="width:80%;margin:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th></th>
                    <th></th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>

                @foreach($categories as $category)

                @if($category->status == True)

                @php $status = 'Active' @endphp
                @php $class_tag = 'label label-success' @endphp
                @else

                @php $status = 'Deactivated' @endphp
                @php $class_tag = 'label label-danger' @endphp
                @endif

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ucwords($category->title)}}</td>
                    <td id="title"> <span v-if="feedback === {{$category->id}}">
                            <span v-if="label === 'Active'" :class="['label label-success']">@{{label}}</span>
                            <span v-else :class="['label label-danger']">@{{label}}</span>
                        </span>
                        <span v-else class="{{$class_tag}}"> {{ $status}}</span>
                    </td>
                    <td id="title">
                        @if($category->status == True)
                        <span v-if="feedback === {{$category->id}}">
                            <a class="btn btn-xs btn-danger" @click="deactivate({{$category->id}})">
                               Deactivate
                            </a>
                        </span>
                        <span v-else>
                            <a class="btn btn-xs btn-success" @click="deactivate({{$category->id}})">
                               Deactivate
                            </a>
                        </span>
                        @else
                        <span v-if="feedback === {{$category->id}}">
                            <a class="btn btn-xs btn-success" @click="activate({{$category->id}})">
                                Activate
                            </a>
                        </span>
                        <span v-else>
                            <a class="btn btn-xs btn-danger" @click="activate({{$category->id}})">
                                Activate
                            </a>
                        </span>
                        @endif

                        <button class="btn btn-danger btn-xs delete{{$category->id}}" @click="deleteCategory({{$category->id}})">
                            <span class="fas fa-trash-alt mr-2" style='cursor:pointer;'></span>
                        </button>
                    </td>
                    <td>{{ $category->created_at->diffForHumans()}}</td>
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
    const app = new Vue({
        el: '#app',

        data: {
            form: {
                title: '',
                status: '',
            },
            allerros: [],
            success: false,
            // users: [],
            feedback: 0,
            label: '',
        },
        // mounted() {
        //     window.axios.get('{{url("users")}}').then(res => {
        //         this.users = res.data
        //         console.log(this.users)
        //     })
        // },
        methods: {
            onSubmit() {
                dataform = new FormData();
                dataform.append('title', this.form.title);
                dataform.append('status', this.form.status);
                console.log(this.form.title);

                axios.post('{{url("create_category")}}', dataform).then(response => {
                    console.log(response);
                    this.allerros = [];
                    this.form.title = '';
                    this.form.status = '';
                    this.success = true;
                    if (response.data.success === 1) {
                        this.success = true;
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
                });
            },
            activate(id) {
                console.log(id);
                axios.put('{{url("update_category_status")}}/' + id, {

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
            deactivate(id) {
                console.log(id);
                axios.put('{{url("update_category_status")}}/' + id, {

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
            deleteCategory(id) {
                $.confirm({
                    title: 'Delete',
                    content: 'Warning! Taking off this Category erases all tasks within. Are you sure you wish to proceed?',
                    buttons: {
                        Yes: {
                            text: 'Yes',
                            btnClass: 'btn-danger',
                            action: function() {
                                axios.delete('{{url("deleteCategory")}}/' + id)
                                    .then(response => {
                                        if (response.data.res == 1) {
                                            $('.delete' + id).closest('tr').css('background', 'red');
                                            $('.delete' + id).closest('tr').fadeOut(800, function() {
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
        }
    });
</script>



@endsection