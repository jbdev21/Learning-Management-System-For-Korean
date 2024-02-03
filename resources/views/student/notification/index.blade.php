@extends("student.includes.layouts.main")  
@section('content')
<div class="container">
    <div class="col-sm-8 col-sm-offset-2">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Notifications</h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-4 col-lg-push-8 col-md-4 col-md-push-8 col-sm-4 col-sm-push-8 col-xs-4 col-xs-push-8">
                        <div class="btn-group" role="group" aria-label="...">
                            {{-- <button type="button" class="btn btn-danger" id="delete-notification"><i class="fa fa-trash-o"></i> Delete</button> --}}
                            <button type="button" class="btn btn-success" id="mark-notification"><i class="fa fa-envelope-o"></i> Mark Read</button>
                        </div>
                    </div>
                    <br>
                    <br>
                
                    <div class='p-4'>
                        <form action="{{ route('student.notification.update', 0) }}" id="notification-form" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" id="notification-submit-type" name="type" value="delete">
                            <ul class="notification-list">
                                @foreach($notifications as $notification)
                                    <li class="item" for="notif-{{ $notification->id }}">
                                        <div class="checkbox-input">
                                            <input type="checkbox" name="items[]" value="{{ $notification->id }}" id="notif-{{ $notification->id }}">
                                        </div>
                                        <div class="img"  style="margin-right:5px;">
                                            <img src="{{ $notification->data['avatar'] }}" class="img-responsive img-circle" alt="Product Image">
                                        </div>
                                        <div class="info">
                                            <span class=" pull-right text-muted">{{ $notification->created_at->diffForHumans() }}</span></a>
                                            <a href="{{ notification_url($notification->data['link'], $notification->id)}}" class="product-title @if($notification->read_at != '') text-muted @endif">
                                                <h4>{{ $notification->data['title'] }}</h4>
                                                {{ $notification->data['message'] }}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                </div>
            {{ $notifications->links() }}
            </div>
        </div>
</div>
@endsection
