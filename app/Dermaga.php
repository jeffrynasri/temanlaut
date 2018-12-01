<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Dermaga extends Model
{

    public $table = "dermaga";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nama', 'lat', 'lon'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}