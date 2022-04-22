<h3 class="box-title">Add State</h3>
            
<form role="form" action="{{ route('state.store') }}" method="POST" enctype="multipart/form-data">
@csrf
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
	<input type="text" name="statename" id="statename" placeholder="Enter State Name Here" value="{{ old('statename') }}">
	@if ($errors->has('statename'))
		<strong style="color:red;">{{ $errors->first('statename') }}</strong>
	@endif

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
