<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = [
      "postcode" ,
      "open_Monday" ,
      "open_Tuesday" ,
      "open_Wednesday" ,
      "open_Thursday" ,
      "open_Friday" ,
      "open_Saturday" ,
      "open_Sunday" ,
      "closed_Monday" ,
      "closed_Tuesday" ,
      "closed_Wednesday" ,
      "closed_Thursday" ,
      "closed_Friday" ,
      "closed_Saturday" ,
      "closed_Sunday" ,
      "lat" ,
      "lng" ,
    ];
}
