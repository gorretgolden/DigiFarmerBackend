@extends('layouts.app')

@section('content')
<div class="mt-5 ">



    <div class="card" >
        <div class="card-header">
            <h4>Recent Notifications</h4>
        </div>
        <div class="card-body">
            @forelse($notifications as $notification)
            <div class="alert alert-success" role="alert">
                [{{ $notification->created_at }}] User {{ $notification->data['fullname'] }}
                ({{ $notification->data['email'] }}) has just registered.
                <a href="#" class="float-right mark-as-read btn btn-warning nav-link " data-id="{{ $notification->id }}">
                    Mark as read
                </a>
            </div>

            @if ($loop->last)
                <a href="#" id="mark-all">
                    Mark all as read
                </a>
            @endif
        @empty
            There are no new notifications
        @endforelse
        </div>
    </div>

</div>
@endsection

