<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
class Post extends Model
{
    use HasFactory;

    public function categories(){
        return $this->belongsToMany(Category::class)->wherePivot('type','category');
    }

    public function tags(){
        return $this->belongsToMany(Category::class)->wherePivot('type','tag');
    }


    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function postMeta(){
        return $this->hasMany(PostMeta::class);
    }
    public function getPostMeta($meta_key,$post_id=0){
        if($post_id == 0){
            $post_id = $this->id;
        }
        return $this->postMeta()->where('meta_key',$meta_key)->where('post_id',$post_id)->first();
    }

    public function getFeaturedImage($image_id){
        $media = Media::where('id',$image_id)->first();
        if(!empty($media)){
            return $media->getFileUrl();
        }
        return "";
    }

}
