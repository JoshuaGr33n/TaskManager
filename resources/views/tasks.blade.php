@extends('layout2')
@section('title', 'User:: '.Auth::user()->name)
@section('content')
@php use App\Http\Controllers\AppController; @endphp

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
    (User)
    <a href="{{url('logout')}}" class="button tiny red log-button">
        Logout
    </a>

    <div>
        <a href="{{url('user')}}">Dashboard</a> |
        <a href="inbox">Inbox</a>
    </div>

    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">My Tasks</h2>

        </div>

    </div>
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newTaskModal">
        Create New Task
    </button>

    <div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-labelledby="newTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newTaskModalLabel">New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span v-if="success" :class="['label label-success']">Task Created!</span>
                    <form method="POST" action="{{url('create_task')}}" @submit.prevent="onSubmit">
                        {{ csrf_field() }}
                        <div class="form-group" :class="['form-group', allerros.title ? 'has-error' : '']">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="title" v-model="form.title">
                            <span v-if="allerros.title" :class="['label label-danger']">@{{ allerros.title[0] }}</span>
                        </div>
                        <div class="form-group" :class="['form-group', allerros.category ? 'has-error' : '']">
                            <label for="category" class="col-form-label">Category:</label>
                            @if($count_active_categories > 0)
                            <select class="form-control form-select" aria-label="Category" name="category" id="category" v-model="form.category">
                                <option value="">Category:</option>
                                <option v-for="(category, index) in categories" v-bind:index="index" :value="category.id">@{{ category.title.toUpperCase() }}</option>
                            </select>
                            <span v-if="allerros.category" :class="['label label-danger']">@{{ allerros.category[0] }}</span>
                            @else
                            <input type="text" class="form-control" disabled value="No Active Category. Contact Admin">
                            @endif
                        </div>
                        <div class="form-group" :class="['form-group', allerros.deadline ? 'has-error' : '']">
                            <label for="deadline" class="col-form-label">Deadline:</label>
                            <input type="date" class="form-control" name="deadline" id="deadline" v-model="form.deadline">
                            <span v-if="allerros.deadline" :class="['label label-danger']">@{{ allerros.deadline[0] }}</span>
                        </div>
                        <div class="form-group" :class="['form-group', allerros.status ? 'has-error' : '']">
                            <label for="status" class="col-form-label">Status:</label>
                            <select class="form-control form-select" aria-label="Status" name="status" id="status" v-model="form.status">
                                <option value="">Status:</option>
                                <option value="1">Pending</option>
                                <option value="2">Done</option>
                            </select>
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
                    <th>Category</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th></th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>

                @foreach($tasks as $task)

                @if($task->status == 2)

                @php $status = 'Done' @endphp
                @php $class_tag = 'label label-success' @endphp

                @elseif($task->status == 1)

                @php $status = 'Pending' @endphp
                @php $class_tag = 'label label-warning' @endphp

                @else

                @php $status = 'Overdue' @endphp
                @php $class_tag = 'label label-danger' @endphp
                @endif

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ucwords($task->title)}}</td>
                    <td>{{ ucwords(AppController::call_category($task->category_id)) }} <span class="{{ AppController::check_category_status_class_tag($task->category_id) }}">{{ AppController::check_category_status($task->category_id) }}</span></td>
                    <td>{{date("jS M Y", strtotime($task->deadline))}}</td>
                    <td id="title"> <span v-if="feedback === {{$task->id}}">
                            <span v-if="label === 'Done'" :class="['label label-success']">@{{label}}</span>
                            <span v-else :class="['label label-danger']">@{{label}}</span>
                        </span>
                        <span v-else class="{{$class_tag}}"> {{ $status}}</span>
                    </td>
                    <td id="title">
                        <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#updateTaskModal{{$task->id}}">
                            <i class="fa fa-pen" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-danger btn-xs delete{{$task->id}}" @click="deleteTask({{$task->id}})">
                            <span class="fas fa-trash-alt mr-2" style='cursor:pointer;'></span>
                        </button>
                    </td>
                    <td>{{ $task->created_at->diffForHumans()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>




    @foreach($tasks as $task)

    @if($task->status == 2)

    @php $status = 'Done' @endphp

    @elseif($task->status == 1)

    @php $status = 'Pending' @endphp

    @else

    @php $status = 'Overdue' @endphp
    @endif
    <div class="modal fade" id="updateTaskModal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="updateTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span v-if="updateSuccess" :class="['label label-success']">Task Updated!</span>
                    <!-- <form method="POST" action="{{url('update_task')}}" @submit.prevent="updateTask"> -->
                    {{ csrf_field() }}
                    <div class="form-group" :class="['form-group', allerros.edit_title ? 'has-error' : '']">
                        <label for="edit_title" class="col-form-label">Title:</label>
                        <input type="text" class="form-control" name="edit_title" id="edit_title{{$task->id}}" value="{{$task->title}}">
                        <span v-if="uniqueID === {{$task->id}}">
                            <span v-if="allerros.edit_title" :class="['label label-danger']">@{{ allerros.edit_title[0] }}</span>
                        </span>
                    </div>
                    <div class="form-group" :class="['form-group', allerros.category ? 'has-error' : '']">
                        <label for="category" class="col-form-label">Category:</label>
                        @if($count_active_categories > 0)
                        <select class="form-control form-select" aria-label="Category" name="edit_category" id="edit_category{{$task->id}}">
                            @if(AppController::check_category_status($task->category_id) !== 'Category Deactivated')
                            <option value="{{$task->category_id}}">{{ ucwords(AppController::call_category($task->category_id)) }}</option>
                            @else
                            <option value="">{{ AppController::call_category($task->category_id) }} (Category Deactivated. Select Another)</option>
                            @endif
                            <option v-for="(category, index) in categories" v-bind:index="index" :value="category.id">@{{ category.title }}</option>
                        </select>
                        <span v-if="uniqueID === {{$task->id}}">
                            <span v-if="allerros.edit_category" :class="['label label-danger']">@{{ allerros.edit_category[0] }}</span>
                        </span>
                        @else
                        <input type="text" class="form-control" disabled value="No Active Category. Contact Admin">
                        @endif
                    </div>
                    <div class="form-group" :class="['form-group', allerros.edit_deadline ? 'has-error' : '']">
                        <label for="edit_deadline" class="col-form-label">Deadline:</label>
                        <input type="date" class="form-control" name="edit_deadline" id="edit_deadline{{$task->id}}" value="{{$task->deadline->todatestring()}}">
                        <span v-if="uniqueID === {{$task->id}}">
                            <span v-if="allerros.edit_deadline" :class="['label label-danger']">@{{ allerros.edit_deadline[0] }}</span>
                        </span>
                    </div>
                    <div class="form-group" :class="['form-group', allerros.edit_status ? 'has-error' : '']">
                        <label for="edit_status" class="col-form-label">Status:</label>
                        <select class="form-control form-select" aria-label="Status" name="edit_status" id="edit_status{{$task->id}}">
                            <option value="{{$task->status}}">{{$status}}</option>
                            <option value="1">Pending</option>
                            <option value="2">Done</option>
                        </select>
                        <span v-if="uniqueID === {{$task->id}}">
                            <span v-if="allerros.edit_status" :class="['label label-danger']">@{{ allerros.edit_status[0] }}</span>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="updateTask({{$task->id}})">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    <!-- </form>     -->
                </div>

            </div>
        </div>
    </div>
    @endforeach

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
    //    const submitResume = document.getElementById("submitResume").value;
    const app = new Vue({
        el: '#app',

        data: {
            form: {
                title: '',
                category: '',
                deadline: '',
                status: '',
            },
            allerros: [],
            err: [],
            success: false,
            updateSuccess: false,
            categories: [],
            feedback: 0,
            uniqueID: 0,
            label: '',
        },
        mounted() {
            window.axios.get('{{url("categories")}}').then(res => {
                    this.categories = res.data
                    console.log(this.categories)
                }),
                window.axios.get('{{url("getUserTasks")}}').then(res => {
                    this.task_id = res.data.id
                    console.log(this.task_id)
                })
        },
        methods: {
            onSubmit() {
                dataform = new FormData();
                dataform.append('title', this.form.title);
                dataform.append('category', this.form.category);
                dataform.append('deadline', this.form.deadline);
                dataform.append('status', this.form.status);
                console.log(this.form.title);

                axios.post('{{url("create_task")}}', dataform).then(response => {
                    console.log(response);
                    this.allerros = [];
                    this.form.title = '';
                    this.form.category = '';
                    this.form.deadline = '';
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
            updateTask(id) {
                console.log(id);
                const edit_title = document.getElementById('edit_title' + id).value;
                const edit_category = document.getElementById('edit_category' + id).value;
                const edit_deadline = document.getElementById('edit_deadline' + id).value;
                const edit_status = document.getElementById('edit_status' + id).value;

                dataform = new FormData();
                dataform.append('edit_title', edit_title);
                dataform.append('edit_category', edit_category);
                dataform.append('edit_deadline', edit_deadline);
                dataform.append('edit_status', edit_status);
                dataform.append('Uid', id);


                axios.post('{{url("update_task")}}', dataform).then(response => {
                    console.log(response);
                    this.allerros = [];
                    this.updateSuccess = true;
                    if (response.data.success === 1) {
                        this.updateSuccess = true;
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }).catch((error) => {
                    this.uniqueID = id;
                    this.allerros = error.response.data.errors;
                    console.log(this.allerros);
                    this.updateSuccess = false;
                });
            },

            deleteTask(id) {
                console.log(id);
                $.confirm({
                    title: 'Delete',
                    content: 'Warning! Are you sure you want to remove this task?',
                    buttons: {
                        Yes: {
                            text: 'Yes',
                            btnClass: 'btn-danger',
                            action: function() {
                                axios.delete('{{url("deleteTask")}}/' + id)
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