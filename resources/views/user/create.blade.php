<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<h2 class="box-title">User Form</h2>
            
<form role="form" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
@csrf
	<label for="">Title</label>
	<select name="title" id="title"value="{{ old('title') }}">
	<option>-Select-</option>
	<option value="mr.">Mr.</option>
	<option value="ms.">Ms.</option>
	<option value="dr.">Dr.</option>
	</select>
	@if ($errors->has('title'))
		<strong style="color:red;">{{ $errors->first('title') }}</strong>
	@endif
	<br>
	<label for="">First Name</label>
	<input type="text" name="name" id="name" placeholder="First Name Here" value="{{ old('name') }}">
	@if ($errors->has('name'))
		<strong style="color:red;">{{ $errors->first('name') }}</strong>
	@endif
	<br>
	<label for="">Last Name</label>
	<input type="text" name="lastname" id="lastname" placeholder="Last Name Here" value="{{ old('lastname') }}">
	@if ($errors->has('lastname'))
		<strong style="color:red;">{{ $errors->first('lastname') }}</strong>
	@endif
	<br>
	<label for="gender">Gender:</label>
	<input type="radio" name="gender"  value="male">Male
	<input type="radio" name="gender"  value="female">Female
	<input type="radio" name="gender"  value="other">Other
	@if ($errors->has('gender'))
		<strong style="color:red;">{{ $errors->first('gender') }}</strong>
	@endif
	<br>
	<label for="checkbox">Education:</label>
	<input type="checkbox" id="education" name="education[]" value="10th">10th
	<input type="checkbox" id="education" name="education[]" value="12th">12th
	<input type="checkbox" id="education" name="education[]" value="BCA">BCA
	<input type="checkbox" id="education" name="education[]" value="BE">BE
	<input type="checkbox" id="education" name="education[]" value="BSC">BSC
	<input type="checkbox" id="education" name="education[]" value="MCA">MCA
	<input type="checkbox" id="education" name="education[]" value="ME">ME
	<input type="checkbox" id="education" name="education[]" value="MSC">MSC
	<input type="checkbox" id="education" name="education[]" value="Phd">Phd
	@if ($errors->has('education'))
		<strong style="color:red;">{{ $errors->first('education') }}</strong>
	@endif
	<br>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" class="user">
	@if ($errors->has('username'))
		<strong style="color:red;">{{ $errors->first('username') }}</strong>
	@endif
	<br>
			
		<label for="number">Mobile Number:</label>
		<input type="text" id="mobile_number" name="mobile_number"  class="mobile_num" >
	@if ($errors->has('mobile_number'))
		<strong style="color:red;">{{ $errors->first('mobile_number') }}</strong>
	@endif
	<br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" class="e_mail" >
	@if ($errors->has('email'))
		<strong style="color:red;">{{ $errors->first('email') }}</strong>
	@endif
	<br>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" class="pass_word" >
	@if ($errors->has('password'))
		<strong style="color:red;">{{ $errors->first('password') }}</strong>
	@endif
	<br>

		<label for="Conform_Password">Conform Password:</label>
		<input type="password" id="conform_password" name="conform_password" class="conf_password" >
	@if ($errors->has('conform_password'))
		<strong style="color:red;">{{ $errors->first('conform_password') }}</strong>
	@endif
	<br>
		   
		<label for="image">Image:</label>
		<input type="file" id="image" name="image[]" multiple ><br>
	<!-- country state city -->	
		<label for="">Country Name</label>
		<select class="form-control" name="country_id" id="country_id" data-id="{{ old('country_id') }}">
		<option value="">- Select Country -</option>
	@foreach($get_country as $country)
		<option value="{{ $country->id }}" @if(old('country_id') == $country->id ) selected="selected" @endif>{{ $country->country_name }}</option>
	@endforeach
		</select><br>
	@if ($errors->has('country_id'))
		<span class="validation">
		<strong style="color:red;">{{ $errors->first('country_id') }}</strong>
		</span>
	@endif
		<label for="">State Name</label>
		<select class="form-control" name="state_id" id="state_id" data-id="">
		<option value="">- Select Country -</option>
		
		</select><br>
	@if ($errors->has('statename'))
		<span class="validation">
		<strong style="color:red;">{{ $errors->first('statename') }}</strong>
		</span>
	@endif
		<label for="">City Name</label>
		<select class="form-control" name="city_id" id="city_id" data-id="">
		<option value="">- Select city -</option>
		
		</select><br>
	@if ($errors->has('cityname'))
		<span class="validation">
		<strong style="color:red;">{{ $errors->first('cityname') }}</strong>
		</span>
	@endif
	<button type="submit" class="btn btn-primary">Submit</button>
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