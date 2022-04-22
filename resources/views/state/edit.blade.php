<li><a href="{{ route('state.index') }}">State</a></li>

<h3 class="box-title">Edit State</h3>
        
<form role="form" action="{{ route('state.update',$state->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<label>Country <span class="text-red">*</span></label>
	<select class="form-control" name="country_id" id="country_id" data-id="{{ old('country_id') }}" required>
		<option value="">- Select Country -</option>
			@foreach($get_country as $country)
				<option value="{{ $country->id }}" @if($country->id == $state->country_id ) selected="selected" @endif>{{ $country->country_name }}</option>
			@endforeach
	</select>
	<label for="">State Name</label>
	<input type="text" name="statename" id="statename" value="{{ $state->statename }}">
	@if ($errors->has('statename'))
	<strong style="color:red;">{{ $errors->first('statename') }}</strong>
	@endif
	<button type="submit" class="btn btn-primary">Update</button>
</form>
