<?php

	function uploadModalReferenceFileA($files,$upath ,$refe_table_field_name ,$ref_field_id , $type  )
    {
		$path = public_path('/') .'/'. $upath;	
		$path_thumb = public_path('/') .'/'. $upath.'/thumb';	
		$upload = 0;
		
        foreach ($files as $i => $file) {

			$timestamp = uniqid();
			$real_name = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$name = $timestamp."_".$ref_field_id.".".$extension;
			
			$imgexist = \App\Refefile::where("refe_file_real_name",$real_name)->where("refe_field_id",$ref_field_id)->first();
			if(1 || !$imgexist){
			
						
			\File::exists($path_thumb) or mkdir($path_thumb, 0777, true);
			
			if(in_array($extension,['jpg','jpeg','png','PNG','JPEG','JPG'])){
			
				$img = Image::make($file->getRealPath(),array(

					'width' => 100,

					'height' => 100,

					'grayscale' => false

				));

				$img->save($path_thumb.'/'.$name);
				
			}
			$size = $file->getSize();
			$file->move($path,$name);
			
			$requestData = array();
			$requestData['refe_file_path'] = $upath;
			$requestData['refe_file_name'] = $name;
			$requestData['refe_file_real_name'] = $real_name;
			$requestData['refe_field_id'] = $ref_field_id;
			$requestData['refe_table_field_name'] = $refe_table_field_name;
			$requestData['refe_type'] = $type;
			
			\App\Refefile::create($requestData);
            
			$upload++;
			
			}
			
		}
        
     
        return $upload;
		
    }
	function uploadModalReferenceFile($files,$upath ,$refe_table_field_name ,$ref_field_id , $type )
    {
		
		$path = public_path() .'/'. $upath;	
		
		$upload = 0;
		
        foreach ($files as $i => $file) {

			$timestamp = uniqid();
			$real_name = $file->getClientOriginalName();
			$name = $timestamp."_".$real_name;
			$extension = $file->getClientOriginalExtension();
			
			$file->move($path,$name);
			
			$requestData = array();
			$requestData['refe_file_path'] = $upath;
			$requestData['refe_file_name'] = $name;
			$requestData['refe_file_real_name'] = $real_name;
			$requestData['refe_field_id'] = $ref_field_id;
			$requestData['refe_table_field_name'] = $refe_table_field_name;
			$requestData['refe_type'] = $type;
			\App\Refefile::create($requestData);
            
			$upload++;
			
		}
        
     
        return $upload;
		
    }
	function apiCall($url,$method, $content = NULL)
    {
        try{

            $ch = curl_init ($url); // your URL to send array data
            if ($content !== NULL) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
            }
            switch (strtolower($method)) {

                case "get":
                    curl_setopt($ch, CURLOPT_HTTPGET, true);
                    break;

                case "post":
                    curl_setopt($ch, CURLOPT_POST, true);
                    break;

                case "put":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
                    break;

                case "delete":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
            }

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_HTTPHEADER, []);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            if(0){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }else{
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            }


            $result = curl_exec ($ch);

            if(!curl_errno($ch))
            {
                return json_decode($result,true);

            }else{
                return [];
            }




        }catch (\Exception $e){
			dd($e->getMessage());
        }
    }
	function removeRefeImage($refe)
    {
		if($refe){
		
			$path = public_path('/');
			
			if ($refe->refe_file_name && $refe->refe_file_name !="" && \File::exists($path."/".$refe->refe_file_path."/".$refe->refe_file_name)) {
				unlink($path."/".$refe->refe_file_path."/".$refe->refe_file_name);
			}
			if ($refe->refe_file_name && $refe->refe_file_name !="" && \File::exists($path."/".$refe->refe_file_path."/thumb/".$refe->refe_file_name)) {
				unlink($path."/".$refe->refe_file_path."/thumb/".$refe->refe_file_name);
			}
		
		$refe->delete();
		}
	}

    
?>