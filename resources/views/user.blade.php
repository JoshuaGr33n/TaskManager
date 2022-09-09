@extends('layout2')
@section('title', 'User Dashboard:: '.Auth::user()->name)
@section('content')
@php use App\Http\Controllers\AppController; @endphp
<style>
    .main {
        width: 80%;
        margin: auto;
    }

    .table {
        margin-top: 30px;
    }

    #wrapper {
        width: 700px;
        margin: auto;
    }

    #wrapper2 {
        width: 1000px;
        margin: auto;
    }

    .todoListContainer {
        width: 350px;
        /* margin: auto; */
        float: left;
    }

    .todoListContainer2 {
        width: 345px;
        /* margin: auto; */
        float: right;
    }

    .space {
        width: 345px;
        margin: auto;

    }

    .heading {
        background: #e6e6e6;
        padding: 10px;
    }

    .heading2 {
        background: #e6e6e6;
        padding: 1px;
    }

    #title {
        text-align: center;
        display: block;
    }

    .green {
        color: green
    }

    .red {
        color: red
    }
</style>


<div class="main">

    {{Auth::user()->name}}
    (User Dashboard)
    <a href="{{url('logout')}}" class="button tiny red log-button">
        Logout
    </a>

    <div>
        <a href="user/inbox">Inbox</a> |
        <a href="user/tasks">Tasks</a>
    </div>

</div>
<div id="wrapper">
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">My Profile</h2>
            <strong>Name:</strong> {{Auth::user()->name}} <br />
            <strong>Email:</strong> {{ Auth::user()->email}}<br />
            <strong>Phone:</strong> {{ Auth::user()->phone}}<br />
            <strong>User Since:</strong> {{ Auth::user()->created_at->diffForHumans() }}<br />
        </div>
    </div>
    <div class="todoListContainer2">
        <div class="heading">
            <h2 id="title">My Tasks</h2>
            <span class="text-primary"><strong>All Tasks:</strong> {{ $all_tasks_count }}</span><br />
            <span class="text-success"><strong>Completed:</strong> {{ $completed_tasks_count }}</span><br />
            <span class="text-warning"><strong>Pending:</strong> {{ $pending_tasks_count }}</span><br />
            <span class="text-danger"><strong>Overdue:</strong> {{ $overdue_tasks_count }}</span>
        </div>
    </div>


</div>

<div id="wrapper2">
    <div style="height:150px; margin-top:80px"> </div>
    <div class="space" style="margin-bottom:5px">
        <div class="heading2">
            <h3 id="title">Recent Tasks</h3>
        </div>
    </div>
   @if($most_recent_tasks_count > 0)
    <table class="table table-striped" style="margin:auto">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Category</th>
                <th scope="col">Deadline</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($most_recent_tasks as $task)
    

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
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ucwords($task->title)}}</td>
                <td>{{ ucwords(AppController::call_category($task->category_id)) }} <span class="{{ AppController::check_category_status_class_tag($task->category_id) }}">{{ AppController::check_category_status($task->category_id) }}</span></td>
                <td>{{date("jS M Y", strtotime($task->deadline))}}</td>
                <td><span class="{{$class_tag}}"> {{ $status}}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h4 id="title">You have no task</h4>
    @endif
</div>
@stop