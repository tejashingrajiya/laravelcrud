<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class StateController extends Controller
{	
    public function index()
    {	
		$get_states = State::select('states.*','countries.id as cat_id','countries.country_name as cat_name')->join('countries','countries.id', '=','states.country_id')->get();
		
        return view('state.list')->with('get_states',$get_states);
    }
	
	public function stateList(Request $request)
	{
		$columns = array(
			0=>'statename',
			1=>'country_id',
			2=>'country_name',
			3=>'created_at',
			4=>'action',
		);
		
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
		$totalData = State::where('id','!=','')->count();
		
		$totalFiltered = State::where('id','!=','');
		
		$values = State::select('states.*','countries.id as cat_id','countries.country_name as cat_name')->join('countries','countries.id', '=','states.country_id')->offset($start)->limit($limit)->orderBy($order,$dir);
		
		
		if(!empty($request->input('search')))
        {
			$values = $values->where('statename', 'LIKE',"%{$request->input('search')}%");
			
            $totalFiltered = $totalFiltered->where('statename', 'LIKE',"%{$request->input('search')}%");
        }
			
		$values = $values->get();
		
		$totalFiltered = $totalFiltered->count();
		
        $data = array();
        if(!empty($values))
        {
            foreach ($values as $value)
            {	
				//$country_name = Country::where('id','=',$value->country_id)->first();
				$userdata['statename'] = $value->statename;
				$userdata['country_id'] = $value->country_id;
				$userdata['country_name'] = $value->cat_name;
				$userdata['created_at'] = date('Y-m-d h:i:s', strtotime($value->created_at));
				
				$userdata['action'] = '<a href="'.route('state.edit', [$value->id]).'" style="cursor: pointer;">Edit</a>
				<a href=""'.route('state.delete', [$value->id]).'" style="cursor: pointer;" onClick="return confirm_click();">Delete</a>';
				
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
		$get_country = Country::all();
        return view('state.create',["get_country"=>$get_country]);
    }
	public function store(Request $request)
    {
		
        $data = $request->validate([
			'country_id' => 'required',
            'statename' => 'required|regex:/^[a-zA-Z]+$/|unique:states',
			'status'=>1,
        ]);
		
        State::create($data);
		
		return redirect()->route('state.index')->with('success', 'State created successfully.');
    }
	public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('state.index')->with('success', 'State deleted successfully');
    }
	public function delete($id)
	{
		try
		{
			State::where('id', $id)->delete();
			
			return redirect()->route('state.index')->with('success', 'State deleted successfully');
		}
		catch(\Exception $e)
		{
			return redirect()->route('state.index')->with('failed', $e->getMessage());
		}
	}
	public function edit(State $state)
    {
		$get_country = Country::all();
        return view('state.edit', compact('state'),["get_country"=>$get_country]);
    }
	
	/**
     * Update the specified record.
     */
    public function update(Request $request, State $state)
    {
        $data = $request->validate([
            'statename' => "required|regex:/^[a-zA-Z]+$/|unique:states,statename,$state->id,id",
			'country_id' => '',
			
        ]);
        $state->update($data);
        return redirect()->route('state.index')->with('success', 'State updated successfully');
    }
}
