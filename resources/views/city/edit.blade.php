<li><a href="{{ route('city.index') }}">City</a></li>

<h3 class="box-title">Edit City</h3>
        
<form role="form" action="{{ route('city.update',$city->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<label>Country <span class="text-red">*</span></label>
	<select class="form-control" name="countryid" id="countryid" data-id="{{ old('countryid') }}" required>
		<option value="">- Select Country -</option>
			@foreach($get_country as $country)
				<option value="{{ $country->id }}" @if($country->id == $city->countryid ) selected="selected" @endif>{{ $country->country_name }}</option>
			@endforeach
	</select>
	<label>State <span class="text-red">*</span></label>
	<select class="form-control" name="stateid" id="stateid" data-id="{{ old('stateid') }}" required>
	</select>
	<label for="">City Name</label>
	<input type="text" name="cityname" id="cityname" value="{{ $city->cityname	}}">
	@if ($errors->has('cityname'))
	<strong style="color:red;">{{ $errors->first('cityname') }}</strong>
	@endif
	<button type="submit" class="btn btn-primary">Update</button>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
	});

	$(document).ready(function() {
	$('#countryid').on('change', function() {
		var countryid = this.value;
		$("#stateid").html('');
		$.ajax({
			url:"{{url('get-states-by-country')}}",
			type: "POST",
			data: {
				countryid: countryid,
				"_token": "{{ csrf_token() }}",
			},
			dataType : 'json',
			success: function(result){
				$('#stateid').html('<option value="">Select State</option>'); 
				$.each(result,function(key,value){
				$("#stateid").append('<option value="'+value.id+'">'+value.statename+'</option>');
				}); 
			}
		});
	});    
});
</script>
