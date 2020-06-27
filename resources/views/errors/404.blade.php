@php( $layout = 'layouts.frontend' )	

@extends($layout)

@section('title',"No file found")

@section('content')



			
<section id="basic-badges" class="height-725">
   
    <div class="row match-height justify-content-md-center">
        <div class="col-12 ">
            <div class="card" style="height: 600px;">
               
                <div class="card-body">
					<div class="card-block pt-3 text-center">
							<div class="clearfix">
								<h5 class="text-bold-500  font-45 primary ">Route Not Found !</h5>
							</div>
							<div class="sussess">
								<img src="{{ asset('img/no-file.png') }}" alt="img">
							</div>
							<p class="line">The route you are trying to open is not available and cannot be opened</p>
							<hr class="line-1">
							
							
							 <p class="text-muted text-center col-12 py-1"> <?php $today = getdate(); ?>
        &copy; <a href="#" target="_blank"> {{ config('app.name') }} {{$today['year']}} </a>All Rights</p>
							
							<div class="card-block ">
								<a href="{{url('/')}}" class="btn btn-raised btn-dark ">Back!</a>
																
							</div>
							
							
									
							
						</div>
                    
                </div>
				
            </div>
        </div>
        
        
        
        
        
        
        
    </div>
</section>

@endsection
