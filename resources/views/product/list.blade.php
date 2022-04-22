<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<html>

<h1>Product List</h1>
      
@if (Session::get('success'))
	<h4>Success!</h4>
	{{ Session::get('success') }}
@endif
<head>

    <title>Laravel Add To Cart Function </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    
</head>
<body>

  

<div class="container">

    <div class="row">

        <div class="col-lg-12 col-sm-12 col-12 main-section">

            <div class="dropdown">

                <button type="button" class="btn btn-info" data-toggle="dropdown">

                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>

                </button>

                <div class="dropdown-menu">

                    <div class="row total-header-section">

                        <div class="col-lg-6 col-sm-6 col-6">

                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>

                        </div>

                        @php $total = 0 @endphp
							
                        @foreach((array) session('cart') as $id => $details)
							
                            @php $total += $details['price'] * $details['quantity'] @endphp

                        @endforeach

                        <div class="col-lg-6 col-sm-6 col-6 total-section text-right">

                            <p>Total: <span class="text-info">$ {{ $total }}</span></p>

                        </div>

                    </div>

                    @if(session('cart'))

                        @foreach(session('cart') as $id => $details)

                            <div class="row cart-detail">

                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">

                                    <img src="{{ $details['image'] }}" />

                                </div>

                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">

                                    <p>{{ $details['title'] }}</p>

                                    <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>

                                </div>

                            </div>

                        @endforeach

                    @endif

                    <div class="row">

                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">

                            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

  

<br/>

<div class="container">

  

    @if(session('success'))

        <div class="alert alert-success">

          {{ session('success') }}

        </div> 

    @endif

  

    @yield('content')

</div>

  

@yield('scripts')

<a href="{{ route('product.create') }}" class="btn btn-primary  mt-3 mb-3 btn-block">
	New Product Add
</a>					
				
<table border=1px id="country_list" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>title</th>
			<th>quantity</th>
			<th>price</th>
			<th>image</th>
			<th>description</th>
			<th>add to cart</th>              
		</tr>
	</thead>
	<tbody>
		@foreach($get_products as $get_product)
			<tr>
				<td>{{ $get_product->id }}</td>
				<td>{{ $get_product->title }}</td>
				<td>{{ $get_product->quantity }}</td>
				<td>{{ $get_product->price }}</td>
				<div class="col-sm-12">
					<td><?php 
				foreach(explode(",", $get_product->image) as $image){
					?><div>
				<img src="{{ asset('public/images/' . $image) }}" width=100 height=100 /></div>	
				<?php } ?>
				</td>
				</div>
				<div><td>{{ $get_product->description }}</td></div>
				<td>
				<a href="{{ url('add-to-cart/'.$get_product->id) }}"  style="cursor: pointer;">Add to cart</a>
				</td>
				
			</tr>
		@endforeach
	</tbody>
</table>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

       
	   
<!-- <table id="country_list_ajax" class="table table-bordered table-striped">
	// <thead>
		// <tr>
			// <th>CountryID</th>
			// <th>Country</th>
			// <th>Created</th>
			// <th>Action</th>              
		// </tr>
	// </thead>
// </table>
	
// <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
// <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

// <script type="text/javascript">
// $(document).ready(function() {
	// $('#country_list').DataTable();
// });
// </script>

// <script>

// $(document).ready(function()
// { 
	// $.ajaxSetup({
		// headers: {
			// 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		// }
	// });

	// var dataTable = $('#country_list_ajax').DataTable({
		// processing:true,
		// "language": {
		// 'loadingRecords': '&nbsp;',
		// 'processing': 'Loading...'
		// },
		// serverSide:true, 
		// bLengthChange: true,
		// searching:true,
		// bFilter: true,
		// bInfo: true,
		// order: [[0, 'desc'] ],
		// bAutoWidth: false,			 
		// "ajax":{
			// "url": "{{ url('country-list') }}",
			// "dataType": "json",
			// "type": "POST",
			// "data": function (d) {
				// d._token   = "{{csrf_token()}}";
				// d.search   = $('input[type="search"]').val();
			// }
		// },
		// "columns": [
			// { "data": "id" },
			// { "data": "country_name" },
			// { "data": "created_at" },
			// { "data": "action" }
		// ]	 
	// });
	
	// $(".search-input-text").keyup(function(){
		// dataTable.draw();
	// });
// });

// function confirm_click() {
	// return confirm('Are you sure you want to delete?');
// }

// </script> -->
