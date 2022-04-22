<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {					  
		$get_city = City::all();
		//dd($get_city);
		return view('city.list')->with('get_city',$get_city);
		
    }
		public function cityList(Request $request)
	{
		$columns = array(
			0=>'id',
			0=>'cityname',
			//1=>'statename',
			1=>'stateid',
			2=>'countryid',
			//4=>'country_name',
			3=>'created_at',
			4=>'action',
		);
		
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
		$totalData = City::where('id','!=','')->count();
		
		$totalFiltered = City::where('id','!=','');
		
		$values = City::where('id','!=','')->offset($start)->limit($limit)->orderBy($order,$dir);
		
		if(!empty($request->input('search')))
        {
			$values = $values->where('cityname', 'LIKE',"%{$request->input('search')}%");
			
            $totalFiltered = $totalFiltered->where('cityname', 'LIKE',"%{$request->input('search')}%");
        }
			
		$values = $values->get();
		
		$totalFiltered = $totalFiltered->count();
		
        $data = array();
        if(!empty($values))
        {
            foreach ($values as $value)
			
            {	
				
				//$country_name = Country::where('id','=',$value->country_id)->first();
				$userdata['id'] = $value->id;
				$userdata['cityname'] = $value->cityname;
				$userdata['stateid'] = $value->stateid;
				$userdata['countryid'] = $value->countryid;
				$userdata['created_at'] = date('Y-m-d h:i:s', strtotime($value->created_at));
				
				$userdata['action'] = '<a href="'.route('city.edit', [$value->id]).'" style="cursor: pointer;">Edit</a>
				<a href=""'.route('city.delete', [$value->id]).'" style="cursor: pointer;" onClick="return confirm_click();">Delete</a>';
				
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
		//dd($get_country);
        return view('city.create', compact('get_state','get_country'));
		
	}
	
	public function store(Request $request)
    {	//print_r($_POST);
		
        $data = $request->validate([
            'cityname' => 'required|regex:/^[a-zA-Z]+$/|unique:cities',
			'stateid' => 'required',
			'countryid' => 'required',
        ]);
		
        City::create($data);
		
		return redirect()->route('city.index')->with('success', 'City created successfully.');
    }
	
	public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('city.index')->with('success', 'City deleted successfully');
    }
	
	public function delete($id)
	{
		try
		{
			City::where('id', $id)->delete();
			
			return redirect()->route('city.index')->with('success', 'city deleted successfully');
		}
		catch(\Exception $e)
		{
			return redirect()->route('city.index')->with('failed', $e->getMessage());
		}
	}
	
	public function edit(City $city)
    {
		$get_state = State::all();
		$get_country = Country::all();
        return view('city.edit', compact('city','get_state','get_country'));
    }
	
	/**
     * Update the specified record.
     */
    public function update(Request $request, City $city)
    {
        $data = $request->validate([
			'cityname' => "required|regex:/^[a-zA-Z]+$/|unique:cities',cityname,$city->id,id",
			/* 'stateid' => 'required',
			'countryid' => 'required', */
			
        ]);
        $city->update($data);
        return redirect()->route('city.index')->with('success', 'City updated successfully');
    }
	
	 public function getState(Request $request)
    {	
	
		$state_ajax = State::where("country_id",$request->countryid)
                    ->get();
		
				return response()->json($state_ajax);
				
	}
	
	public function getCity(Request $request)
    {	
	/* 	echo("hi");die; */
		$city_ajax = City::where("stateid",$request->sst_id)
                    ->get();

				return response()->json($city_ajax);
				
	}
	
	
}
