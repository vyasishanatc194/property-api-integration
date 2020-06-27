<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'properties';
	
	/**
     * The database primary key value.
     *
     * @var string
     */
	protected $primaryKey = 'id';

	/**
     * Array of all fillable fields
     *
     * @var string
     */
    protected $fillable = [
		"uuid",
		"property_type_id",
		"county",
		"country",
		"town",
		"description",
		"address",
		"image_full",
		"image_thumbnail",
		"latitude",
		"longitude",
		"num_bedrooms",
		"num_bathrooms",
		"price",
		"type",
		//"api_created_at",
		//"api_updated_at",
		"property_type",
		"created_from",
		"postcode",
	];
	
	protected $appends = ['image_full_a','image_thumbnail_a'];
	
	
	// To get image_full from local or live
	public function getImageFullAAttribute()
    {
		$res = $this->image_full; 
		if($this->refefile->count()){
			$rf = $this->refefile->first();
			if($rf->file_url && $rf->file_url != ""){
				$res = $rf->file_url; 
			}
		}
		return $res;
	}
	
	// To get image_thumbnail from local or live
	public function getImageThumbnailAAttribute()
    {
		$res = $this->image_thumbnail; 
		if($this->refefile->count()){
			$rf = $this->refefile->first();
			if($rf->file_thumb_url && $rf->file_thumb_url != ""){
				$res = $rf->file_thumb_url; 
			}
		}
		return $res;
	}
	
	
	/**
     * Relation with file/images table
     *
     * @var Relational object
	 * One proerty can have a multiple uploaded images
     */
	public function refefile()
    {
        return $this->hasMany('App\Refefile', 'refe_field_id', 'id')->where('refe_table_field_name', 'properties');
    }
	
	//Bind inset query event to set uuid
	public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
			if(!$model->uuid || $model->uuid == ""){
				$model->uuid = "PRPUUID_".$model->id;
				$model->save();
			}
		});
	}
	
}
