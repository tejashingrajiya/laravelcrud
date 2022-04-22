<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<h2 class="box-title">User Form</h2>
            
<form role="form" action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

	<label for="">Title</label>
	<select name="title" id="title"value="{{ $user->title }}">
	<option value="mr."{{ $user->title == 'mr' ? 'checked' : '' }} >Mr.</option>
	<option value="ms."{{ $user->title == 'ms' ? 'checked' : '' }} >Ms.</option>
	<option value="dr."{{ $user->title == 'dr' ? 'checked' : '' }} >Dr.</option>
	</select>
	@if ($errors->has('title'))
		<strong style="color:red;">{{ $errors->first('title') }}</strong>
	@endif
	<br>
	<label for="">First Name</label>
	<input type="text" name="name" id="name" placeholder="First Name Here" value="{{ $user->name }}">
	@if ($errors->has('name'))
		<strong style="color:red;">{{ $errors->first('name') }}</strong>
	@endif
	<br>
	<label for="">Last Name</label>
	<input type="text" name="lastname" id="lastname" placeholder="Last Name Here" value="{{ $user->lastname }}">
	@if ($errors->has('lastname'))
		<strong style="color:red;">{{ $errors->first('lastname') }}</strong>
	@endif
	<br>
	<label for="gender">Gender:</label>
	<input type="radio" name="gender"  value="male"{{ $user->gender == 'male' ? 'checked' : '' }} >Male
	<input type="radio" name="gender"  value="female"{{ $user->gender == 'female' ? 'checked' : '' }} >Female
	<input type="radio" name="gender"  value="other"{{ $user->gender == 'other' ? 'checked' : '' }} >Other
	@if ($errors->has('gender'))
		<strong style="color:red;">{{ $errors->first('gender') }}</strong>
	@endif
	<br>
	<label for="checkbox">Education:</label>
	<input type="checkbox" id="education" name="education[]" value="10th" {{ in_array('10th', $education) ? 'checked' : '' }}>10th
	<input type="checkbox" id="education" name="education[]" value="12th" {{ in_array('12th', $education) ? 'checked' : '' }}>12th
	<input type="checkbox" id="education" name="education[]" value="BCA" {{ in_array('BCA', $education) ? 'checked' : '' }}>BCA
	<input type="checkbox" id="education" name="education[]" value="BE" {{ in_array('BE', $education) ? 'checked' : '' }}>BE
	<input type="checkbox" id="education" name="education[]" value="BSC" {{ in_array('BSC', $education) ? 'checked' : '' }}>BSC
	<input type="checkbox" id="education" name="education[]" value="MCA" {{ in_array('MCA', $education) ? 'checked' : '' }}>MCA
	<input type="checkbox" id="education" name="education[]" value="ME" {{ in_array('ME', $education) ? 'checked' : '' }}>ME
	<input type="checkbox" id="education" name="education[]" value="MSC" {{ in_array('MSC', $education) ? 'checked' : '' }}>MSC
	<input type="checkbox" id="education" name="education[]" value="Phd" {{ in_array('Phd', $education) ? 'checked' : '' }}>Phd
	@if ($errors->has('education'))
		<strong style="color:red;">{{ $errors->first('education') }}</strong>
	@endif
	<br>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" class="user" value="{{ $user->username }}">
	@if ($errors->has('username'))
		<strong style="color:red;">{{ $errors->first('username') }}</strong>
	@endif
	<br>
			
		<label for="number">Mobile Number:</label>
		<input type="text" id="mobile_number" name="mobile_number"  class="mobile_num" value="{{ $user->mobile_number }}">
	@if ($errors->has('mobile_number'))
		<strong style="color:red;">{{ $errors->first('mobile_number') }}</strong>
	@endif
	<br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" class="e_mail" value="{{ $user->email }}">
	@if ($errors->has('email'))
		<strong style="color:red;">{{ $errors->first('email') }}</strong>
	@endif
	<br>
		   
		<label for="image">Image:</label>
		<input type="file" id="image" name="image[]" multiple value="{{ $user->image }}">
		<img src="{{ asset('public/images/' . $user->image) }}" width=100 height=100 />
		<br>
<!-- country state city -->	
	<label>Country <span class="text-red">*</span></label>
	<select class="form-control" name="country_id" id="country_id" data-id="{{ old('country_id') }}" required>
		<option value="">- Select Country -</option>
			@foreach($get_country as $country)
				<option value="{{ $country->id }}" @if($country->id == $user->country_id ) selected="selected" @endif>{{ $country->country_name }}</option>
			@endforeach
	</select>
	<label>State <span class="text-red">*</span></label>
	<select class="form-control" name="state_id" id="state_id" data-id="{{ old('state_id') }}" required>
		<option value="">- Select Country -</option>
			@foreach($get_state as $state)
				<option value="{{ $state->id }}" @if($state->id == $user->state_id ) selected="selected" @endif>{{ $state->statename }}</option>
			@endforeach
	</select>
	
	<label>City <span class="text-red">*</span></label>
	<select class="form-control" name="city_id" id="city_id" data-id="{{ old('city_id') }}" required>
		<option value="">- Select Country -</option>
			@foreach($get_city as $city)
				<option value="{{ $city->id }}" @if($city->id == $user->city_id ) selected="selected" @endif>{{ $city->cityname }}</option>
			@endforeach
	</select>
	<button type="submit" class="btn btn-primary">Upadte</button>
	<br>
	
</form>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
	});

	$(document).ready(function() {
	$('#country_id').on('change', function() {
		var countryid = this.value;
		$("#state_id").html('');
		$.ajax({
			url:"{{url('get-states-by-country')}}",
			type: "POST",
			data: {
				countryid: countryid,
				"_token": "{{ csrf_token() }}",
			},
			dataType : 'json',
			success: function(result){
				$('#state_id').html('<option value="">Select State</option>'); 
				$.each(result,function(key,value){
				$("#state_id").append('<option value="'+value.id+'">'+value.statename+'</option>');
				}); 
			}
		});
	});
	$('#state_id').on('change', function() {
		var state_id = this.value;
		$("#city_id").html('');
		$.ajax({
			url:"{{url('get-cities-by-state')}}",
			type: "POST",
			data: {
				sst_id: state_id,
				"_token": "{{ csrf_token() }}",
			},
			dataType : 'json',
			success: function(result){
				$('#city_id').html('<option value="">Select State</option>'); 
				$.each(result,function(key,value){
				$("#city_id").append('<option value="'+value.id+'">'+value.cityname+'</option>');
				}); 
			}
		});
	});    
});
</script>
<a href="{{ route('user.list') }}">
	<h3>user table<h3/>
</a>
