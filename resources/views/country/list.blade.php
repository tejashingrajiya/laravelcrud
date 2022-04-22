<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


<h1>Country List</h1>
      
@if (Session::get('success'))
	<h4>Success!</h4>
	{{ Session::get('success') }}
@endif

<a href="{{ route('country.create') }}">
	Create Country
</a>					
					
<table id="country_list" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Country Name</th>
			<th>Date</th>
			<th>Edit</th>
			<th>delete</th>              
		</tr>
	</thead>
	<tbody>
		@foreach($get_countries as $get_country)
			<tr>
				<td>{{ $get_country->id }}</td>
				<td>{{ $get_country->country_name }}</td>
				<td>{{ $get_country->created_at }}</td>
				<td>
				<a href="{{ route('country.edit',$get_country->id)}}"  style="cursor: pointer;">Edit</a>
				</td>
				<td>
				<a href="{{ route('country.delete',$get_country->id)}}" onclick="return confirm('Are you sure you want to delete?');" style="cursor: pointer;">Delete</a>	
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>
       
<table id="country_list_ajax" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>CountryID</th>
			<th>Country</th>
			<th>Created</th>
			<th>Action</th>              
		</tr>
	</thead>
</table>
	
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#country_list').DataTable();
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

	var dataTable = $('#country_list_ajax').DataTable({
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
			"url": "{{ url('country-list') }}",
			"dataType": "json",
			"type": "POST",
			"data": function (d) {
				d._token   = "{{csrf_token()}}";
				d.search   = $('input[type="search"]').val();
			}
		},
		"columns": [
			{ "data": "id" },
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
