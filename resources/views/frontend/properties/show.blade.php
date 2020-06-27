@extends('layouts.frontend')
@section('title',"Property Detail")

@section('content')

    <section id="basic-form-layouts">
	<div class="row">
            <div class="col-sm-12">
                <div class="content-header"> Property Detail</div>
               
            </div>
        </div>
	<div class="row">
	    <div class="col-md-12">
	        <div class="card">
	            <div class="card-header">
                        <a href="{{ url('/') }}" title="Back">
                            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                            </button>
                        </a>
	                 <div class="next_previous pull-right">
                   
                      </div>  
                          
                        
                        
	            </div>
	            <div class="card-body">
	                <div class="px-3">
                           <div class="box-content ">
                               <div class="row">
                                   <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>

											@foreach($item_arr as $key =>$arr)
											@if($key != "property_type")
                                            <tr>
												
                                                <td>{{ ucfirst($key) }}</td>
                                                <td>
												@if($key == "image_thumbnail" || $key == "image_full")
													<a class="example-image-link " href="{!! $arr !!}" data-lightbox="example-2" data-title="">
					<img src="{!! $arr !!}" height="75" />
					</a>
													
												@else
												{{ $arr }}
												@endif
												</td>
                                            </tr>
											@endif
                                            @endforeach
											
											@if(isset($item) && $item->refefile->count())
											<tr>
												<td>Uploaded Image</td>
                                                <td>
											<div class="row">	
											@foreach($item->refefile as $rf)
											@if($rf->file_thumb_url && $rf->file_thumb_url != "")
											<div class="col-sm-2 relative-container" id="ref{{$rf->id}}">
												
												<a class="example-image-link " href="{!! $rf->file_url !!}?uid={{ time() }}" data-lightbox="example-2" data-title="{{$rf->refe_file_real_name}}">
												<img src="{!! $rf->file_thumb_url !!}" height="75" />
												</a>
											</div>

											@endif
											@endforeach
											</div>
											</td>
											</tr>
											@endif
											
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	

	

	
</section>


@endsection


     