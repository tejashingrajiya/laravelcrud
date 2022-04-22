<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


<h1>user registeration Form</h1>
      
@if (Session::get('success'))
	<h4>Success!</h4>
	{{ Session::get('success') }}
@endif

<a href="{{ route('user.create') }}">
	Create new user
</a>					
					
<table id="user_list" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>title</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>gender</th>
			<th>education</th>
			<th>username</th>
			<th>mobile_number</th>
			<th>email</th>
			<th>image</th>
			<th>country_id</th>
			<th>state_id</th>
			<th>city_id</th>
			<th>created_at</th>
			<th>Edit</th>
			<th>Delete</th>
			
		</tr>
	</thead>
	<tbody>
		@foreach($get_users as $get_user)
			<tr>
				<td>{{ $get_user->user_id }}</td>
				<td>{{ $get_user->title }}</td>
				<td>{{ $get_user->name }}</td>
				<td>{{ $get_user->lastname }}</td>
				<td>{{ $get_user->gender }}</td>
				<td>{{ $get_user->education }}</td>
				<td>{{ $get_user->username }}</td>
				<td>{{ $get_user->mobile_number }}</td>
				<td>{{ $get_user->email }}</td>
				<td><img src="{{ asset('public/images/' . $get_user->image) }}" width=100 height=100 />
				</td>
				<td>{{ $get_user->country_name }}</td>
				<td>{{ $get_user->statename}}</td>
				<td>{{ $get_user->cityname }}</td>
				<td>{{ $get_user->created_at }}</td>
				<td>
				<a href="{{ route('user.edit',$get_user->user_id)}}"  style="cursor: pointer;">Edit</a>
				</td>
				<td>
				<a href="{{ route('user.delete',$get_user->user_id)}}" onclick="return confirm('Are you sure you want to delete?');" style="cursor: pointer;">Delete</a>	
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>

<table id="user_list_ajax" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>title</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>gender</th>
			<th>education</th>
			<th>username</th>
			<th>mobile_number</th>
			<th>email</th>
			<th>image</th>
			<th>country_id</th>
			<th>state_id</th>
			<th>city_id</th>
			<th>created_at</th>
			<th>action</th> 
		</tr>
	</thead>
</table>

<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#user_list').DataTable();
});
</script>

<script>

$(document).ready(function()
{ 
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var dataTable = $('#user_list_ajax').DataTable({
		processing:true,
		"language": {
		'loadingRecords': '&nbsp;',
		'processing': 'Loading...'
		},
		serverSide:true, 
		bLengthChange: true,
		searching:true,
		bFilter: true,
		bInfo: true,
		order: [[0, 'desc'] ],
		bAutoWidth: false,			 
		"ajax":{
			"url": "{{ url('user-list') }}",
			"dataType": "json",
			"type": "POST",
			"data": function (d) {
				d._token   = "{{csrf_token()}}";
				d.search   = $('input[type="search"]').val();
			}
		},
		"columns": [
			{ "data": "id" },
			{ "data": "title" },
			{ "data": "name" },
			{ "data": "lastname" },
			{ "data": "gender" },
			{ "data": "education" },
			{ "data": "username" },
			{ "data": "mobile_number" },
			{ "data": "email" },
			{ "data": "image"},
			{ "data": "country_id"},
			{ "data": "state_id"},
			{ "data": "city_id"},
			{ "data": "created_at" },
			{ "data": "action" }
		]	 
	});
	
	$(".search-input-text").keyup(function(){
		dataTable.draw();
	});
});

function confirm_click() {
	return confirm('Are you sure you want to delete?');
}

</script>