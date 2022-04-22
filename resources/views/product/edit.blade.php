<!DOCTYPE html>
<html>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<body>
      <h1>
        Edit Product   
      </h1>
		<li><a href="{{ route('product.index') }}">Product Table</a></li>

         <h3 class="box-title">Edit Product</h3>
            <form role="form" action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
				<div>
                  <label for="">Product TITLE:-</label>
                  <input type="text" class="title" name="title" id="title" placeholder="Enter Product Name Here" value="{{ $product->title }}">
				  @if ($errors->has('title'))
					<span class="validation">
						<strong style="color:red;">{{ $errors->first('title') }}</strong>
					</span>
					@endif
				</div>
			
                <div>
                  <label for="">QUANTITY:-</label>
                  <input type="text" name="quantity" id="quantity" class="quantity" value="{{ $product->quantity }}">
                  @if ($errors->has('quantity'))
					<span class="validation">
						<strong style="color:red;">{{ $errors->first('quantity') }}</strong>
					</span>
					@endif
                </div>

				<div>
                  <label for="">PRICE:-</label>
                  <input type="text" name="price" id="price" class="price" value="{{ $product->price }}">
                  @if ($errors->has('price'))
					<span class="validation">
						<strong style="color:red;">{{ $errors->first('price') }}</strong>
					</span>
					@endif
                </div>
				
				<div>
                  <label for="">IMAGE:-</label>
                  <input type="file" name="image[]" id="image" class="image" value="{{ $product->image }}" multiple >
				  <div>
				  <?php 
				foreach(explode(",", $product->image) as $image){
					?>
				<img src="{{ asset('public/images/' . $image) }}" width=100 height=100 />	
				<?php } ?>
				</div>
                  @if ($errors->has('image'))
					<span class="validation">
						<strong style="color:red;">{{ $errors->first('image') }}</strong>
					</span>
					@endif
                </div>
				
				<div>
                  <label for="">DESCRIPTION:-</label>
				  <textarea name="description" id="description" class="description" >{{ $product->description }}</textarea>
                  @if ($errors->has('description'))
					<span class="validation">
						<strong style="color:red;">{{ $errors->first('description') }}</strong>
					</span>
					@endif
                </div>
				
              <div class="box-footer">
			  <a href="javascript:history.go(-1)" class="btn btn-default">Cancel</a></div>
			  
			  <div>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
</body>
</html>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        
