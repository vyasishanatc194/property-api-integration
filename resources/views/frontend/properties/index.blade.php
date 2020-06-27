@extends('layouts.frontend')

@section('body_class',' pace-done')

@section('title','Properties')

@section('content')

@php( $prperty_type = [1=>'Flat',2=>'Detatched',3=>'Semi-detached',4=>'Terraced',5=>'End of Terrace',6=>'Cottage',7=>'Bungalow'])
<div class="row">
    <div class="col-sm-12">
        <div class="content-header"> Property Listing </div>
       
    </div>
</div>

    <section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
				{!! Form::open([
                    'method'=>'DELETE',
                    'id'=>'delete_item_form',
                    'url' => ['properties'],
                    'style' => 'display:inline'
                ]) !!}
				{!! Form::close() !!}
				
				<form method="get">
				<div class="row">
				
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <select class="form-control filter" id="filter_from" name="filter_from">
								<option value="">Filter by Data</option>
								<option value="local" >Local</option>
								<option value="live" >Live</option>
							</select>
                        </div>
                    </div>
					<div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <select class="form-control filter" id="filter_type" name="filter_type">
								<option value="">Filter by Type</option>
								<option value="rent" >Rent</option>
								<option value="sale" >Sale</option>
							</select>
                        </div>
                    </div>
					<div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            {!! Form::text('search', null, ['class' => 'form-control','placeholder'=>"Search"]) !!}
                        </div>
                    </div>
					<div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                             {!! Form::submit("Apply filter", ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
					
					
                </div>
				</form>
                </div>
                <div class="card-body collapse show">
                    
                    <div class="card-block card-dashboard">
						<div class="actions pull-left" style="padding: 0px 0px 8px 0px;" >
                            
                               <a href="{{url('get-api-data')}}" class="btn btn-success btn-sm task_form_open" >
                                   <i class="fa fa-sync" aria-hidden="true"></i> Fetch API Property
                               </a>
                       </div>
					   <div class="actions pull-right" style="padding: 0px 0px 8px 8px;">
                            
                               <a href="{{ url('properties') }}/create" class="btn btn-success btn-sm task_form_open" title="Add New ">
                                   <i class="fa fa-plus" aria-hidden="true"></i> Add New
                               </a>
                       </div>
                        
                        <div class="table-responsive">
                           <table class="table table-bordered table-striped datatable responsive">
                            <thead>
                            <tr>
                                <th >Uuid</th>
                                <th >Image</th>
                                <th >Property Type</th>
                                <th >For Sale/Rent</th>
								<th >Address</th>
								<th >Town</th>
								<th >Price</th>
                                <th >Action</th>
                                
                            </tr>
                            </thead>
							<tbody>
							@foreach($items as $item)
							<tr>
                                <td>{{ $item->uuid }}</td>
                                <td>
								@if(isset($item) && $item->image_thumbnail_a && $item->image_thumbnail_a != "")
									<img src="{!! $item->image_thumbnail_a !!}"  alt="{{$item->image_thumbnail_a}}" height="75" width="75" />
								@endif
								</td>
                                <td>
								@if(isset($item) && $item->property_type && $item->property_type != "")
									@php( $property_type_ob = json_decode($item->property_type,true))
									@if(isset($property_type_ob['title'])) {{ $property_type_ob['title'] }} @endif
								@else
									@if(isset($prperty_type[$item->property_type_id])) {{ $prperty_type[$item->property_type_id] }} @endif
								@endif
								</td>
                                <td>{{ ucfirst($item->type) }}</td>
								<td>{{ $item->address }}</td>
								<td>{{ $item->town }} </td>
								<td>{{ $item->price }}</td>
                                <td>
										{{--
										<a href="{{ url('properties/' . $item->id) }}" title="View Property">
                                            <i class="fa fa-eye" aria-hidden="true"></i> 
                                        </a>
										--}}
                                        
                                        <a href="{{ url('properties/' . $item->id . '/edit') }}" title="Edit Blog">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                                        </a>
                                       
                                        <a href="#" data-id="{{$item->id}}" class="recover-item" title="Edit Blog">
                                            <i class="fa fa-trash-o color-danger" aria-hidden="true"></i> 
                                        </a>
                                        
                                        
                                        
								
								</td>
                            </tr>
							@endforeach
							</tbody>
                        </table>
						{{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


@endsection



@push('js')
<script>
//Page level script
 $(document).on('click', '.recover-item', function (e) {
     var id = $(this).attr('data-id');
     var moduel = $(this).attr('moduel');
     var r = confirm("Are you sure to delete this data?");
     if (r == true) {
         var url= "{{ url('properties') }}/"+id;
		 $('#delete_item_form').attr('action',url).submit();
     }
	 return false;
 });   
</script>


@endpush