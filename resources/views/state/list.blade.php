<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


<h1>State List</h1>
      
@if (Session::get('success'))
	<h4>Success!</h4>
	{{ Session::get('success') }}
@endif

<a href="{{ route('state.create') }}">
	Create State
</a>					
					
<table id="state_list" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>State Name</th>
			<th>country_id</th>
			<th>country_name</th>
			<th>created_at</th>
			<th>edit</th>
			<th>delete</th>            
		</tr>
	</thead>
	<tbody>
		@foreach($get_states as $get_state)
			<tr>
				<td>{{ $get_state->statename }}</td>
				<td>{{ $get_state->cat_id }}</td>
				<td>{{ $get_state->cat_name }}</td>
				<td>{{ $get_state->created_at }}</td>
				<td>
				<a href="{{ route('state.edit',$get_state->id)}}"  style="cursor: pointer;">Edit</a>
				</td>	
				<td>
				<a href="{{ route('state.delete',$get_state->id)}}" onclick="return confirm('Are you sure you want to delete?');" style="cursor: pointer;">Delete</a>	
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>
       
<table id="state_list_ajax" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>state</th>
			<th>country_id</th>
			<th>country_name</th>
			<th>created</th>
			<th>action</th>   
		</tr>
	</thead>
</table>
	
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#state_list').DataTable();
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

	var dataTable = $('#state_list_ajax').DataTable({
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
			"url": "{{ url('state-list') }}",
			"dataType": "json",
			"type": "POST",
			"data": function (d) {
				d._token   = "{{csrf_token()}}";
				d.search   = $('input[type="search"]').val();
			}
		},
		"columns": [
			{ "data": "statename" },
			{ "data": "country_id" },
			{ "data": "country_name" },
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
