<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Validator;
	use App\Models\Product;
	
	class ProductController extends Controller
	{
		/**
			* Display a listing of all records.
		*/
		public function index()
		{
			$get_products = Product::all();
			
			return view('product.list')->with('get_products', $get_products);
		}
		
		/**
			* Show the form for creating a new record.
		*/
		public function create()
		{
			return view('product.create');
		}
		
		/**
			* Store a newly created record.
		*/
		public function store(Request $request)
		{
			$data = $request->validate([
            'title' => 'required|unique:products',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
			'image' => 'required',
            'description' => 'required',
			]);
			//$images=array();
			if($imgs = $request->file('image')){
				foreach($imgs as $img){
					$img_name = rand(1000,10000).'.'.$img->getClientOriginalExtension();
					$destination = public_path('images/');
					$img->move($destination , $img_name);
					$arr[]=$img_name;
					//$data["education"] = implode(",",$data["education"]);
					$data["image"] = implode(",", $arr);
				
				}
				}
			Product::create($data);
			return redirect()->route('product.index')->with('success', 'Product created successfully.');
		}
		/**
			* Show the form for editing the specified record.
		*/
		public function edit(Product $product)
		{
			return view('product.edit', compact('product'));
		}
		
		/**
			* Update the specified record.
		*/
		public function update(Request $request, Product $product)
		{
			$data = $request->validate([
            'title' => "required|unique:products,title,$product->id,id",
			'quantity' => 'required|numeric',
            'price' => 'required|numeric',
			'image' => 'nullable',
            'description' => 'required',
			
			]);
			if($imgs = $request->file('image'))
			{
				foreach($imgs as $img)
				{
					$img_name = rand(1000,10000).'.'.$img->getClientOriginalExtension();
					$destination = public_path('images/');
					$img->move($destination , $img_name);
					$arr[]=$img_name;
					$data["image"] = implode(",", $arr);
				}
			}
			$product->update($data);
			return redirect()->route('product.index')->with('success', 'Product updated successfully');
		}
		/**
			* Remove the specified record from storage.
		*/
		public function destroy(Product $product)
		{
			$product->delete();
			
			return redirect()->route('product.index')->with('success', 'Product deleted successfully');
		}
		
		/**
			* Remove the specified record from storage.
		*/
		public function delete($id)
		{
			try
			{
				Product::where('id', $id)->delete();
				
				return redirect()->route('product.index')->with('success', 'Product deleted successfully');
			}
			catch(\Exception $e)
			{	
				return redirect()->route('product.index')->with('failed', $e->getMessage());
			}
		}
		/**
			* product cart .
		*/
		 public function cart()

		{
			
			return view('product.cart');

		}
		
		public function updatecart(Request $request)

		{

			if($request->id && $request->quantity)
			{
				

				$cart = session()->get('cart');

				$cart[$request->id]["quantity"] = $request->quantity;

				session()->put('cart', $cart);

				session()->flash('success', 'Cart updated successfully');
			
			}

		}
		
		public function remove(Request $request)

		{

			if($request->id) {

            $cart = session()->get('cart');

				if(isset($cart[$request->id])) 
				{

					unset($cart[$request->id]);

					session()->put('cart', $cart);

				}

				session()->flash('success', 'Product removed successfully');

			}

		}
		
		public function addToCart($id)

		{	
			$Product=Product::find($id);
			//session_use
			$cart=session()->get('cart', []);
		  if(isset($cart[$id])) 
			{

				$cart[$id]['quantity']++;
			}
          else 
			{
				$cart[$id]=[
				"title" => $Product-> title,
				"quantity" =>1,
				"price" => $Product-> price,
				"image" => $Product-> image,
				"description" => $Product-> description,
				];
				session()->put('cart',$cart);
			}
				//return view('product.list');
				return redirect()->back()->with('success', 'Product added To Cart successfully');
			
		}
	}
