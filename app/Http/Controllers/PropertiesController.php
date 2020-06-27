<?php

namespace App\Http\Controllers;

use App\Properties;
use Illuminate\Http\Request;
use Session;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$page = $request->get('page', 1);
		$perpage = $request->get('per_page',\config('settings.DATA_LISTING_PER_PAGE'));
		
		$items = Properties::where("id",">",0);
		
		if ($request->has('filter_from') &&  $request->get('filter_from') != '') {
            $items->where('created_from',$request->filter_from);
        }
		if ($request->has('filter_type') &&  $request->get('filter_type') != '') {
            $items->where('type',$request->filter_type);
        }
		if ($request->has('search') &&  $request->get('search') != '') {
            $keyword = $request->search;
			$items->where(function ($query) use($keyword) {
				$query->where('uuid', 'like', '%' . $keyword . '%')
				   ->orWhere('county', 'like', '%' . $keyword . '%')
				   ->orWhere('country', 'like', '%' . $keyword . '%')
				   ->orWhere('town', 'like', '%' . $keyword . '%')
				   ->orWhere('address', 'like', '%' . $keyword . '%')
				   ->orWhere('price', 'like', '%' . $keyword . '%')
				   ->orWhere('postcode', 'like', '%' . $keyword . '%');
			  });
        }
        
		$items = $items->orderby("id","desc")->paginate($perpage);
        return view('frontend.properties.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        
        $rules = [
				"property_type_id"=>['required'],
				"county"=>['required'],
				"country"=>['required'],
				"town"=>['required','max:100'],
				"description"=>['required'],
				"address"=>['required','max:191'],
				"num_bedrooms"=>['required'],
				"num_bathrooms"=>['required'],
				"price"=>['required'],
				"type"=>['required'],
				"postcode"=>['required'],
				'image' => 'mimes:jpeg,png,jpg,gif,svg',
        ];

        $this->validate($request, $rules);

        $item = Properties::create($input);
		
		if($request->hasFile('image'))
		{
			$files = [$request->file('image')];
			uploadModalReferenceFileA($files,'uploads/properties/'.$item->id,'properties',$item->id,'properties',[]);
		}
		
		Session::flash('flash_success',"Item created");
		return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Properties  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Properties::where("id",$id)->first();
		if(!$item){
			Session::flash('flash_error',"Data not found");
            return redirect('/');
		}
		$item_arr = json_encode($item);
		$item_arr = json_decode($item_arr,true);
		
		return view('frontend.properties.show',compact('item','item_arr'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Properties  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$item = Properties::where("id",$id)->first();
        if(!$item){
			Session::flash('flash_error',"Data not found");
            return redirect('/');
		}
		return view('frontend.properties.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Properties  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$item = Properties::where("id",$id)->first();
		if(!$item){
			Session::flash('flash_error',"Data not found");
            return redirect('/');
		}
		
        $input = $request->except(['_token','uuid']);
        
		//Form validation rules
        $rules = [
				"property_type_id"=>['required'],
				"county"=>['required'],
				"country"=>['required'],
				"town"=>['required','max:100'],
				"description"=>['required'],
				"address"=>['required','max:191'],
				"num_bedrooms"=>['required'],
				"num_bathrooms"=>['required'],
				"price"=>['required'],
				"type"=>['required'],
				"image' => 'mimes:jpeg,png,jpg,gif,svg"
        ];

        $this->validate($request, $rules);
		
		$item->update($input);
		
		if($request->hasFile('image'))
		{
			//Delete old images before new upload
			foreach($item->refefile as $rf){
				removeRefeImage($rf);
			}
		
			$files = [$request->file('image')];
			//Upload & generate thumb of image
			uploadModalReferenceFileA($files,'uploads/properties/'.$item->id,'properties',$item->id,'properties',[]);
		}
		
		Session::flash('flash_success',"Item updates!");
		return redirect('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Properties  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$item = Properties::where("id",$id)->first();
        if(!$item){
			Session::flash('flash_error',"Data not found");
            return redirect('/');
		}
		//Delete related data or images before property item delete
		foreach($item->refefile as $rf){
			removeRefeImage($rf);
		}
		
		$item->delete();
		
		Session::flash('flash_success',"Item deleted!");
		return redirect('/');
    }
	
	/**
     * Get data from api and store to local database
     *
     */
    public function loadApiData()
    {
		$API_BASE_URL = \config('settings.API_BASE_URL');
		$API_MAX_CALL = \config('settings.API_MAX_CALL');
		$API_PER_PAGE = \config('settings.API_PER_PAGE');
		$API_KEY = \config('settings.API_KEY');
		
		$url = $API_BASE_URL."/properties?api_key=".$API_KEY."&page%5Bsize%5D=".$API_PER_PAGE;
		$is_complete = 0;
		$counter = 0;
		
		//To get all paginated data 
		do{
			$api_data = apiCall($url,'get',NULL);
			
			if(isset($api_data['data']) && count($api_data['data'])){
				
				foreach($api_data['data'] as $_data){
					$_data['property_type'] = json_encode($_data['property_type']);
					$_data['created_from'] = "live";
					
					//Update record if uuid already exist
					$res = Properties::updateOrCreate(['uuid'=>$_data['uuid']],$_data);
					
					//Delete exsisting images
					foreach($res->refefile as $rf){
						removeRefeImage($rf);
					}
					$counter = $counter + 1;
				}
				// To break loop after number of page
				if($api_data['current_page'] > $API_MAX_CALL){
					$is_complete = 1;
				}
				// To break loop after end of all page
				if($api_data['current_page'] >= $api_data['last_page']){
					$is_complete = 1;
				}
				// To break loop after last page
				if($api_data['next_page_url']){
					$url = $api_data['next_page_url'];
				}else{
					$is_complete = 1;
				}
				
				
			}else{
				$is_complete = 1;
			}
		
		} while ($is_complete !=1);
		
        Session::flash('flash_success',"Data imported!");
        return redirect("/");
    }

}
