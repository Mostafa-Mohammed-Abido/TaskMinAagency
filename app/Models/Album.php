<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['album_id','photo'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    

    public function scopeParent($query){
        return $query -> whereNull('album_id');
    }
    public function scopeChild($query){
        return $query -> whereNotNull('album_id');
    }

    
    public function _parent(){
        return $this->belongsTo(self::class, 'album_id');
    }

  

    //get all childrens=
    public function childrens(){
        return $this -> hasMany(Self::class,'album_id');
    }

    public function albumImages()
    {
        return $this -> belongsToMany(AlbumImage::class,'albumImages_albums');
    }

    

}

