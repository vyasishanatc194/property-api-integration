<div class="row ">

    
    <div class="col-md-6">
      
        
        
		@if(isset($item))
        <div class="form-group {{ $errors->has('uuid') ? 'has-error' : ''}}">
            <label for="uuid" class="">
                <span class="field_compulsory">*</span>Uuid
            </label>
			{!! Form::text('uuid', null, ['class' => 'form-control','disabled'=>'disabled']) !!}	
			{!! $errors->first('uuid', '<p class="help-block">:message</p>') !!}
        </div>
        @endif
		
		<div class="form-group {{ $errors->has('county') ? 'has-error' : ''}}">
            <label for="county" class="">
                <span class="field_compulsory">*</span>County
            </label>
            {!! Form::text('county', null, ['class' => 'form-control']) !!}
            {!! $errors->first('county', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
            <label for="country" class="">
                <span class="field_compulsory">*</span>Country
            </label>
            {!! Form::text('country', null, ['class' => 'form-control']) !!}
            {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
            <label for="postcode" class="">
                <span class="field_compulsory"></span>Postcode
            </label>
            {!! Form::text('postcode', null, ['class' => 'form-control']) !!}
            {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            <label for="description" class="">
                <span class="field_compulsory">*</span>Description
            </label>
			{!! Form::textarea('description', null, ['rows'=>2,'class' => 'form-control','autocomplete'=>'off']) !!}
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
            <label for="address" class="">
                <span class="field_compulsory">*</span>Address
            </label>
            {!! Form::text('address', null, ['class' => 'form-control']) !!}
            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('town') ? 'has-error' : ''}}">
            <label for="town" class="">
                <span class="field_compulsory">*</span>Town
            </label>
            {!! Form::text('town', null, ['class' => 'form-control']) !!}
            {!! $errors->first('town', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="col-md-6">
	
		<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
			<label for="logo">Uploaded Image </label>
			<div class="">
				<div class="row">
				@if(isset($item) && $item->image_full_a && $item->image_full_a != "")
				<div class="col-sm-2 relative-container" >
					<a  href="{!! $item->image_full_a !!}" >
					<img src="{!! $item->image_thumbnail_a !!}" height="75" />
					</a>
				</div>
				@endif
				</div>
				{!! Form::file('image',  ['class' => 'form-control','multiple'=>true]) !!}
				{!! $errors->first('images', '<p class="help-block text-danger">:message</p>') !!}
			</div>
		</div>
		
		<div class="form-group {{ $errors->has('num_bedrooms') ? 'has-error' : ''}}">
            <label for="num_bedrooms" class="">
                <span class="field_compulsory">*</span>Number of bedrooms
            </label>
			{!! Form::select('num_bedrooms',[1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6'], null, ['class' => 'form-control']) !!}
            {!! $errors->first('num_bedrooms', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('num_bathrooms') ? 'has-error' : ''}}">
            <label for="num_bathrooms" class="">
                <span class="field_compulsory">*</span>Number of bathrooms
            </label>
			{!! Form::select('num_bathrooms',[1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6'], null, ['class' => 'form-control']) !!}
            {!! $errors->first('num_bathrooms', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
            <label for="price" class="">
                <span class="field_compulsory">*</span>Price
            </label>
            {!! Form::number('price', null, ['class' => 'form-control']) !!}
            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
		</div>
		
		<div class="form-group {{ $errors->has('property_type_id') ? 'has-error' : ''}}">
            <label for="price" class="">
                <span class="field_compulsory">*</span>Property type
            </label>
            {!! Form::select('property_type_id',[1=>'Flat',2=>'Detatched',3=>'Semi-detached',4=>'Terraced',5=>'End of Terrace',6=>'Cottage',7=>'Bungalow'], null, ['class' => 'form-control']) !!}
			{!! $errors->first('property_type_id', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group  {{ $errors->has('type') ? 'has-error' : ''}}">
			<label for="type" class=""><span class="field_compulsory">*</span>Type</label>
			<div class="form-control">
			{!! Form::radio('type', 'rent',false ,['id' => 'rd2']) !!} <label for="rd2">Rent</label>
			{!! Form::radio('type', 'sale', true, ['id' => 'rd1']) !!} <label for="rd1">Sale</label>
			</div>
			{!! $errors->first('type', '<p class="help-block text-danger">:message</p>') !!}
		</div>
	</div>
</div>

<div class="row ">
    <div class="col-md-12">
		 <div class="form-group">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('comman.label.create'), ['class' => 'btn btn-primary']) !!}
        {{ Form::reset(trans('comman.label.clear_form'), ['class' => 'btn btn-light']) }}
        </div>
	</div>
</div>





