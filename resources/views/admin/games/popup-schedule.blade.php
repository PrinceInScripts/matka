<form action="{{ route('admin.schedule.update', $market_id) }}" method="POST" onsubmit="submitForm(event,this)">
@csrf
<h4>Market Off Day</h4>

@php $days = ['mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday']; @endphp

@foreach($schedule as $i => $row)
<div class="form-group">
    <input type="checkbox" name="is_open[{{$i}}]" {{ $row->is_open ? 'checked':'' }}>
    <input type="hidden" name="weekday[{{$i}}]" value="{{ $row->weekday }}">
    <label>{{ $days[$row->weekday] }}</label>

    <div class="row mt-1">
        <div class="col-6">
            <input type="time" class="form-control" name="open_time[{{$i}}]" value="{{ $row->open_time }}">
        </div>
        <div class="col-6">
            <input type="time" class="form-control" name="close_time[{{$i}}]" value="{{ $row->close_time }}">
        </div>
    </div>
</div>
@endforeach

<button class="btn btn-primary btn-block mt-3">Submit</button>
</form>
