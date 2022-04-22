<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<html>
<head>
	
    <title>Laravel Add To Cart Function</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    
</head>
<body>
<table id="cart" border="1" class="table table-hover table-condensed">

    <thead>

        <tr>

            <th style="width:30%">Product</th>

            <th style="width:30%">Description</th>
            
			<th style="width:10%">Price</th>

            <th style="width:8%">Quantity</th>

            <th style="width:12%" class="text-center">Subtotal</th>

            <th style="width:10%">Remove</th>

        </tr>

    </thead>

    <tbody>

        @php $total = 0 @endphp

        @if(session('cart'))

            @foreach(session('cart') as $id => $details)
				
                @php $total += $details['price'] * $details['quantity'] @endphp

                <tr data-id="{{ $id }}">

                    <td data-th="Product">

                        <div class="row">

                            
                            <div class="col-sm-12">
							<?php 

							//dd($details["image"]);die;
							$arrayimage=explode(',', $details["image"]);
							//dd($arrayimage);die;
				foreach($arrayimage as $image)
						{
					?>
				<img src="{{ asset('public/images/' . $image) }}" width=100 height=100 />
				<?php } ?>
				
                                <h4 class="nomargin">{{ $details['title'] }}</h4>

                            </div>

                        </div>

                    </td>

                    <td data-th="Description">{{ $details['description'] }}</td>
                    
					<td data-th="Price">${{ $details['price'] }}</td>

                    <td data-th="Quantity">

                        <input type="number" value="{{ $details['quantity'] }}" min="1" max="5" class="form-control quantity update-cart" />

                    </td>

                    <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>

                    <td class="actions" data-th="">

                        <button class="btn btn-danger btn-sm remove-from-cart">remove<i class="fa fa-trash-o"></i></button>

                    </td>

                </tr>

            @endforeach

        @endif

    </tbody>

    <tfoot>

        <tr>

            <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>

        </tr>

        <tr>

            <td colspan="5" class="text-right">

                <a href="{{ url('/product') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>

                <button class="btn btn-success">Checkout</button>

            </td>

        </tr>

    </tfoot>

</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script type="text/javascript">

  

    $(".update-cart").change(function (e) {
			alert("hi");
        e.preventDefault();

  

        var ele = $(this);

        $.ajax({
			
            url: '{{ route('updatecart.cart') }}',

            method: "patch",

            data: {

                _token: '{{ csrf_token() }}', 

                id: ele.parents("tr").attr("data-id"), 

                quantity: ele.parents("tr").find(".quantity").val()

            },

            success: function (response) {

               window.location.reload();

            }

        });

    });
	    $(".remove-from-cart").click(function (e) {

        e.preventDefault();

  

        var ele = $(this);

  

        if(confirm("Are you sure want to remove?")) {
			
            $.ajax({

                url: '{{ route('remove.from.cart') }}',

                method: "get",

                data: {

                    _token: '{{ csrf_token() }}', 

                    id: ele.parents("tr").attr("data-id")

                },

                success: function (response) {

                    window.location.reload();

                }

            });

        }

    });
</script>


  

