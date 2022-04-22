<h3 class="box-title">Add city</h3>

<form role="form" action="{{ route('city.store') }}" method="POST" enctype="multipart/form-data">
@csrf
	<label for="">Country Name</label>
	<select class="form-control" name="countryid" id="countryid" data-id="{{ old('country_id') }}">
		<option value="">- Select Country -</option>
		@foreach($get_country as $country)
		<option value="{{ $country->id }}" @if(old('countryid') == $country->id ) selected="selected" @endif>{{ $country->country_name }}</option>
		@endforeach
	</select><br>
	  @if ($errors->has('country_name'))
		<span class="validation">
		<strong style="color:red;">{{ $errors->first('country_name') }}</strong>
		</span>
		@endif
	<label for="">State Name</label>
	<select class="form-control" name="stateid" id="stateid" data-id="">
	<option value="">- Select Country -</option>
	</select><br>
	@if ($errors->has('statename'))
	<span class="validation">
		<strong style="color:red;">{{ $errors->first('statename') }}</strong>
	</span>
	@endif
	
	<label for="">City Name</label>
	<input type="text" name="cityname" id="cityname" placeholder="Enter city Name Here" value="">
	@if ($errors->has('cityname'))
	<strong style="color:red;">{{ $errors->first('cityname') }}</strong>
	@endif
	
	<button type="submit" class="btn btn-primary">Submit</button>
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
