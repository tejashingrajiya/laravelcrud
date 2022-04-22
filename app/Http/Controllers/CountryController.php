<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
   public function index()
    {
		$get_countries = Country::all();
        return view('country.list')->with('get_countries', $get_countries);
    }
	
	public function countryList(Request $request)
	{
		$columns = array(
			0=>'id',
			1=>'country_name',
			2=>'created_at',
			3=>'action',
		);
		
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
		$totalData = Country::where('id','!=','')->count();
		
		$totalFiltered = Country::where('id','!=','');
		
		$values = Country::where('id','!=','')->offset($start)->limit($limit)->orderBy($order,$dir);
		
		if(!empty($request->input('search')))
        {
			$values = $values->where('country_name', 'LIKE',"%{$request->input('search')}%");
			
            $totalFiltered = $totalFiltered->where('country_name', 'LIKE',"%{$request->input('search')}%");
        }
			
		$values = $values->get();
		
		$totalFiltered = $totalFiltered->count();
		
        $data = array();
        if(!empty($values))
        { 
            foreach ($values as $value)
            {	
				$userdata['id'] = $value->id;
				$userdata['country_name'] = $value->country_name;
				$userdata['created_at'] = date('Y-m-d h:i:s', strtotime($value->created_at));
				
				$userdata['action'] = '<a href="'.route('country.edit', [$value->id]).'" style="cursor: pointer;">Edit</a>
				
				<a href=""'.route('country.delete', [$value->id]).'" style="cursor: pointer;" onClick="return confirm_click();">Delete</a>';
				
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
        return view('country.create');
    }
	
	public function store(Request $request)
    {
        $data = $request->validate([
            'country_name' => 'required|regex:/^[a-zA-Z]+$/|unique:countries',
        ]);
		
        Country::create($data);
		
		return redirect()->route('country.index')->with('success', 'Country created successfully.');
    }
	
	public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }
	
	/**
     * Update the specified record.
     */
    public function update(Request $request, Country $country)
    {
        $data = $request->validate([
            'country_name' => "required|regex:/^[a-zA-Z]+$/|unique:countries,country_name,$country->id,id",
        ]);
		
        $country->update($data);
		
        return redirect()->route('country.index')->with('success', 'Country updated successfully');
    }
	
	public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->route('country.index')->with('success', 'Country deleted successfully');
    }
	
	public function delete($id)
	{
		try
		{
			Country::where('id', $id)->delete();
			
			return redirect()->route('country.index')->with('success', 'Country deleted successfully');
		}
		catch(\Exception $e)
		{
			return redirect()->route('country.index')->with('failed', $e->getMessage());
		}
	}
}
