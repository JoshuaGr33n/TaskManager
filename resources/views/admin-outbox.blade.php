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
        <a href="users">All Users</a> |
        <a href="task-categories">Task Categories</a>
    </div>

    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Outbox</h2>

        </div>

    </div>

    <a class="btn btn-sm btn-secondary" href="inbox">
        Inbox
    </a>

    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newMessageModal">
        Compose Message
    </button>

    <div class="modal fade" id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="newMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMessageModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span v-if="success" :class="['label label-success']">Message Sent!</span>
                    <form method="POST" action="{{url('send_message')}}" @submit.prevent="onSubmit">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="from" class="col-form-label">From:</label>
                            <input type="text" class="form-control" id="from" disabled value="Admin (Me)">
                        </div>
                        <div class="form-group" :class="['form-group', allerros.recepient ? 'has-error' : '']">
                            <label for="recepient" class="col-form-label">Recepient:</label>
                            <select class="form-control form-select" aria-label="Recepient" name="recepient" id="recepient" v-model="form.recepient">
                                <option value="">Recepient:</option>
                                <option v-for="(user, index) in users" v-bind:index="index" :value="user.email">@{{ user.email }}</option>
                            </select>
                            <span v-if="allerros.recepient" :class="['label label-danger']">@{{ allerros.recepient[0] }}</span>
                        </div>
                        <div class="form-group" :class="['form-group', allerros.title ? 'has-error' : '']">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="title" v-model="form.title">
                            <span v-if="allerros.title" :class="['label label-danger']">@{{ allerros.title[0] }}</span>
                        </div>
                        <div class="form-group" :class="['form-group', allerros.message ? 'has-error' : '']">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" name="message" id="message-text" v-model="form.message"></textarea>
                            <span v-if="allerros.message" :class="['label label-danger']">@{{ allerros.message[0] }}</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Send message</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="table">
        <table id="datatable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>To</th>
                    <th>Title</th>
                    <th>Sent</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @foreach($messages as $message)

                @if($message->status == True)

                @php $status = 'Read' @endphp
                @php $class_tag = 'label label-success' @endphp
                @else

                @php $status = 'Unread' @endphp
                @php $class_tag = 'label label-danger' @endphp
                @endif

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{$message->recepient}}</td>
                    <td>{{$message->title}}</td>
                    <td>{{ $message->created_at->diffForHumans()}}</td>
                    <td id="title"><span class="{{$class_tag}}"> {{ $status}}</span></td>
                    <td id="title"><a class="btn btn-xs btn-primary" href="outbox/{{$message->id}}">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-danger btn-xs delete{{$message->id}}" @click="deleteMessage({{$message->id}})">
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
    const app = new Vue({
        el: '#app',

        data: {
            form: {
                title: '',
                recepient: '',
                message: '',
            },
            allerros: [],
            success: false,
            users: [],
        },
        mounted() {
            window.axios.get('{{url("users")}}').then(res => {
                this.users = res.data
                console.log(this.users)
            })
        },
        methods: {
            onSubmit() {
                dataform = new FormData();
                dataform.append('title', this.form.title);
                dataform.append('recepient', this.form.recepient);
                dataform.append('message', this.form.message);
                console.log(this.form.message);

                axios.post('{{url("send_message")}}', dataform).then(response => {
                    console.log(response);
                    this.allerros = [];
                    this.form.title = '';
                    this.form.recepient = '';
                    this.form.message = '';
                    this.success = true;
                    if (response.data.success === 1) {
                        this.success = true;
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
                });
            },
            deleteMessage(id) {
                $.confirm({
                    title: 'Delete',
                    content: 'Are you sure you want to delete this message?',
                    buttons: {
                        Yes: {
                            text: 'Yes',
                            btnClass: 'btn-danger',
                            action: function() {
                                axios.delete('{{url("deleteMessage")}}/' + id)
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