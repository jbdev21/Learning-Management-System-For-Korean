@extends("back-end.includes.layouts.main")  

@section('page-title', 'Notification')

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Notifications</h3>
                </div>
                <div class="box-body">
                    <div class="text-right">
                        <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-danger" id="delete-notification"><i class="fa fa-trash-o"></i> Delete</button>
                            <button type="button" class="btn btn-default" id="mark-notification"><i class="fa fa-envelope-o"></i> Mark Read</button>
                            <a href="{{ route('back-end.notification.mark-all-as-read') }}" class="btn btn-success" id="mark-notification"><i class="fa fa-envelope-o"></i> Mark All Read</a>
                        </div>
                    </div>
                
                    <div class='p-4'>
                        <form action="{{ route('back-end.notification.update', 0) }}" id="notification-form" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" id="notification-submit-type" name="type" value="delete">
                            <ul class="products-list product-list-in-box">
                                @foreach($notifications as $notification)
                                    <li class="item" for="notif-{{ $notification->id }}">
                                            <input type="checkbox" name="items[]" value="{{ $notification->id }}" id="notif-{{ $notification->id }}">
                                            <div class="product-img">
                                                <img src="{{ $notification->data['avatar'] }}" alt="Product Image">
                                            </div>
                                        {{-- <div class="product-info"> --}}
                                            <span class=" pull-right text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                            <a href="{{ notification_url($notification->data['link'], $notification->id)}}" class="product-title @if($notification->read_at != '') text-muted @endif">
                                                {{ $notification->data['title'] }}
                                            </a>
                                            <span class="product-description">
                                                {!! $notification->data['message'] !!}
                                            </span>

                                        {{-- </div> --}}
                                    </li>
                                @endforeach
                            </ul>
                        </form>
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


