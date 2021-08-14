<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Media extends Model
{
    use HasFactory;


    public function getFileUrl(){
        if(!empty($this->name)){
            $exists = Storage::exists('medias/'.$this->name);
            if($exists){
                return Storage::url('medias/'.$this->name);
            }
        }
        return '';
    }

}
