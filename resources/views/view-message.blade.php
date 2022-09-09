@extends('layout2')
@section('title', 'User:: '.Auth::user()->name)
@section('content')

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
    @if(Auth::user()->admin == true)
    (Admin)
    @else
    (User)
    @endif
    <a href="{{url('logout')}}" class="button tiny red log-button">
        Logout
    </a>
    <div>
        <a href="{{ url()->previous() }}">Back</a> |
        @if(Auth::user()->admin == true)
        <a href="{{url('admin')}}">Dashboard</a> |
        <a href="{{url('admin/users')}}">All Users</a> |
        <a href="{{url('admin/task-categories')}}">Task Categories</a>
        @else
        <a href="{{url('user')}}">Dashboard</a>
        @endif
    </div>
    @if($message->status == True)

    @php $status = 'Read' @endphp
    @else

    @php $status = 'Unread' @endphp
    @endif

    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">{{$message->message}}</h2>
            @if($tag == 'inbox')
            <strong>From:</strong> {{$message->sender}}<br />
            @else
            <strong>Sent To:</strong> {{$message->recepient}}<br />
            @endif

            <strong>Time:</strong> {{ $message->created_at->diffForHumans()}}<br />
            <strong>Status:</strong> {{ $status}}<br />
        </div>


    </div>



</div>

@stop