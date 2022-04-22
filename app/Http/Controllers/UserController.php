<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City	;
use App\Models\User;
use Str;

class UserController extends Controller
{	
   public function index()
    {	
		$get_users = User::select('users.*','countries.*','states.*','cities.*','users.id as user_id','countries.id as cat_id','states.id as stt_id','cities.id as ctt_id')->join('countries', 'countries.id', '=', 'users.country_id')->join('states', 'states.id', '=', 'users.state_id')->join('cities', 'cities.id', '=', 'users.city_id')->get();
		
	//dd($get_user);die(); 
        return view('user.list')->with('get_users', $get_users);
    }
	
	
	public function userList(Request $request)
	{	
		$columns = array(
			0=>'id',
			1=>'title',
			2=>'name',
			3=>'lastname',
			4=>'gender',
			5=>'education',
			6=>'username',
			7=>'mobile_number',
			8=>'email',
			9=>'image',
			10=>'country_id',
			11=>'country_name',
			12=>'state_id',
			13=>'state_name',
			14=>'city_id',
			15=>'city_name',
			16=>'created_at',
			17=>'action',
		);
		
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
		$totalData = User::where('id','!=','')->count();
		
		$totalFiltered = User::where('id','!=','');
		
		$values = User::select('users.*','countries.id as cat_id','countries.country_name as cat_name','states.id as stt_id','states.statename as stt_name','cities.id as ctt_id','cities.cityname as ctt_name')->join('countries', 'countries.id', '=', 'users.country_id')->join('states', 'states.id', '=', 'users.state_id')->join('cities', 'cities.id', '=', 'users.city_id')->offset($start)->limit($limit)->orderBy($order,$dir);
		//dd($values);die;
		
		if(!empty($request->input('search')))
        {
			$values = $values->where('username', 'LIKE',"%{$request->input('search')}%");
			
            $totalFiltered = $totalFiltered->where('username', 'LIKE',"%{$request->input('search')}%");
        }
			
		$values = $values->get();
		
		$totalFiltered = $totalFiltered->count();
		
        $data = array();
        if(!empty($values))
        { 
            foreach ($values as $value)
            {	//dd($values);die;
			
				//$country_name = Country::where('id','=',$value->country_id)->first();
				$userdata['id'] = $value->id;
				$userdata['title'] = $value->title;
				$userdata['name'] = $value->name;
				$userdata['lastname'] = $value->lastname;
				$userdata['gender'] = $value->gender;
				$userdata['education'] = $value->education;
				$userdata['username'] = $value->username;
				$userdata['mobile_number'] = $value->mobile_number;
				$userdata['email'] = $value->email;
				$userdata['image'] = '<img src="public/images/'.$value->image.'">';
				$userdata['country_id'] = $value->cat_name;
				//$userdata['country_name'] = $value->cat_name;
				$userdata['state_id'] = $value->stt_name;
				//$userdata['state_name'] = $value->stt_name;
				$userdata['city_id'] = $value->ctt_name;
				//$userdata['city_name'] = $value->ctt_name;
				$userdata['created_at'] = date('Y-m-d h:i:s', strtotime($value->created_at));
				
				$userdata['action'] = '<a href="'.route('user.edit', [$value->id]).'" style="cursor: pointer;">Edit</a>
				
				<a href=""'.route('user.delete', [$value->id]).'" style="cursor: pointer;" onClick="return confirm_click();">Delete</a>';
				
                $data[] = $userdata;
            }
        } 
		
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data
                    );
            
        echo json_encode($json_data); 
	}
	
	
	public function create()
    {	
		$get_state = State::all();
		$get_country = Country::all();
		$get_city = City::all();
        return view('user.create', compact('get_state','get_country','get_city'));
    }
	
	public function store(Request $request)
    {
        $data = $request->validate([
			'title' => 'required|in:mr.,ms.,dr.',
			'name' => 'required|regex:/^[a-zA-Z]+$/',
			'lastname' => 'required|regex:/^[a-zA-Z]+$/',
			'gender' => 'required',
			'education' => 'required',
			'username' => 'required|regex:/^[a-zA-Z]+$/|unique:users',
			'mobile_number' =>  'required|digits:10|unique:users',
			'email' => 'email:rfc,dns|unique:users',
			'password' => 'required','min:6','	regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/','confirmed',
			'conform_password' => 'required||same:password',
			'image' => '',
			'country_id' => 'required',
			'state_id' => 'required',
			'city_id' => 'required',
			
			
        ]);

		
		$img = $request->file('image');
		$img_name = time().'.'.$img->getClientOriginalExtension();
        $destination = public_path('images/');
        $img->move($destination , $img_name);
        $data["image"] =  $img_name;
		$data["education"] = implode(",",$data["education"]);
        
		User::create($data);	
		
		return redirect()->route('user.index')->with('success', 'Data Save successfully.');
    }
	
	public function edit(User $user)
    {	
		$get_country = Country::all();
		$get_state = State::all();
		$get_city = City::all();
        return view('user.edit',[
		'user' => $user,
		'get_country'=>$get_country,
		'get_state'=>$get_state,
		'get_city'=>$get_city,
        'education' => explode(',', $user->education)]);
		
    }
	
	/**
     * Update the specified record.
     */
    public function update(Request $request, User $user)
    {
		//echo($user);die;
        $data = $request->validate([
			'title' => 'required|in:mr.,ms.,dr.',
			'name' => 'required|regex:/^[a-zA-Z]+$/',
			'lastname' => 'required|regex:/^[a-zA-Z]+$/',
			'gender' => 'required',
			'education' => 'required',
			'username' => "required|regex:/^[a-zA-Z]+$/|unique:users,username,$user->id,id",
			'mobile_number' =>  "required|digits:10|unique:users,mobile_number,$user->id,id",
			'email' => "email:rfc,dns|unique:users,email,$user->id,id",
			'image' => 'nullable',
			'country_id' => 'required',
			'state_id' => 'required',
			'city_id' => 'required',
			
			
			 ]);
			 
		
		if ($request->hasFile('image'))
		{	 
		 $img = $request->file('image');
		$img_name = time().'.'.$img->getClientOriginalExtension();
        $destination = public_path('images/');
        $img->move($destination , $img_name);
       
        $data["image"] =  $img;
		}
		$data["education"] = implode(",",$data["education"]);
        
		//echo($data);die;
        $user->update($data);
		
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
	
	public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
	
	public function delete($id)
	{	
		try
		{
			User::where('id', $id)->delete();
			
			return redirect()->route('user.index')->with('success', 'User deleted successfully');
		}
		catch(\Exception $e)
		{
			return redirect()->route('user.index')->with('failed', $e->getMessage());
		}
	}
	
	public function getState(Request $request)
    {	
		
		$state_ajax = State::where("country_id",$request->countryid)
                    ->get();
		
					
				return response()->json($state_ajax);
				
	}
	
	public function getCity(Request $request)
    {	
	
		$city_ajax = City::where("stateid",$request->stateid)
                    ->get();
		
					
				return response()->json($city_ajax);
				
	}
	public function table()
    {	
		$get_users = User::select('users.*','countries.*','states.*','cities.*','users.id as user_id','countries.id as cat_id','states.id as stt_id','cities.id as ctt_id')->join('countries', 'countries.id', '=', 'users.country_id')->join('states', 'states.id', '=', 'users.state_id')->join('cities', 'cities.id', '=', 'users.city_id')->get();
		
	//dd($get_user);die(); 
        return view('user.list')->with('get_users', $get_users);
    }
}