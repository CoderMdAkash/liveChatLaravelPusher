@foreach ($messages as $message)
    @if ($message->user_id == $user_id)
        <div class="p-3 bg-info mt-2 text-light" style="border-radius: 8px"><b><u>{{$message->user_name}}</u><br></b>{{$message->message}}</div>
    @else   
        <div class="p-3 bg-success mt-2 text-right text-light" style="border-radius: 8px"><b><u>{{$message->user_name}} </u><br></b>{{$message->message}}</div>
    @endif
@endforeach