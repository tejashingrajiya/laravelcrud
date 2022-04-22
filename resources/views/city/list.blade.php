<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


<h1>City List</h1>
      
@if (Session::get('success'))
	<h4>Success!</h4>
	{{ Session::get('success') }}
@endif

<a href="{{ route('city.create') }}">
	Create City
</a>				

<table id="city_list" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Cityname</th>
			<th>Stateid</th>
			<th>Countryid</th>
			<th>created_at</th>
			<th>edit</th>
			<th>delete</th>            
		</tr>
	</thead>
	<tbody>
		@foreach($get_city as $get_city)
			<tr>
				<td>{{ $get_city->id }}</td>
				<td>{{ $get_city->cityname }}</td>
				<td>{{ $get_city->stateid }}</td>
				<td>{{ $get_city->countryid }}</td>
				<td>{{ $get_city->created_at }}</td>
				<td>
				<a href="{{ route('city.edit',$get_city->id)}}"  style="cursor: pointer;">Edit</a>
				</td>	
				<td>
				<a href="{{ route('city.delete',$get_city->id)}}" onclick="return confirm('Are you sure you want to delete?');" style="cursor: pointer;">Delete</a>	
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>

<table id="city_list_ajax" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>id</th>
			<th>city</th>
			<th>stateid</th>
			<th>countryid</th>
			<th>created</th>
			<th>action</th>   
		</tr>
	</thead>
</table>
 
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#city_list').DataTable();
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

	var dataTable = $('#city_list_ajax').DataTable({
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
			"url": "{{ url('city-list') }}",
			"dataType": "json",
			"type": "POST",
			"data": function (d) {
				d._token   = "{{csrf_token()}}";
				d.search   = $('input[type="search"]').val();
			}
		},
		"columns": [
			{ "data": "id" },
			{ "data": "cityname" },
			{ "data": "stateid" },
			{ "data": "countryid" },
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