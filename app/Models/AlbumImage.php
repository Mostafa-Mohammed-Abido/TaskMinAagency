<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumImage extends Model
{
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    
    
    protected $dates = [
        'start_date',
        'end_date',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'albumImages_albums');
    }

  
    

}