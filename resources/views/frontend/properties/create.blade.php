@extends('layouts.frontend')
@section('title',"Create Property")

@section('content')

    <section id="basic-form-layouts">
	<div class="row">
            <div class="col-sm-12">
                <div class="content-header"> Create Property </div>
            </div>
        </div>
	<div class="row">
	    <div class="col-md-12">
	        <div class="card">
	            <div class="card-header">
                        <a href="{{ url('/') }}" title="Back">
                            <button class="btn-link-back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                            </button>
                        </a>
	                <div class="actions pull-right">
                          
                        </div>
                        
	            </div>
	            <div class="card-body">
	                <div class="px-3">
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
	                     {!! Form::open(['url' => 'properties', 'class' => 'form-horizontal','files' => true,'autocomplete'=>'off']) !!}

                                @include ('frontend.properties.form', ['submitButtonText' => "Create"])

                                {!! Form::close() !!}
                            
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	

	

	
</section>
   
@endsection
