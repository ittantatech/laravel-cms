<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class MediaController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'file' => 'mimes:png,jpg,jpeg'
        ];
        $request->validate($rules);
        if ($request->file('file') && $request->file('file')->isValid()) {
            $requestedImage=$request->file('file');

            $extension = $requestedImage->getClientOriginalExtension();
            $file_name = md5(time().Str::random(12)).'.'.$extension;
            $requestedImage->storeAs('medias',$file_name);
            $image = new Media;
            $image->title = $requestedImage->getClientOriginalName();
            $image->name=$file_name;
            $image->mime_type = $requestedImage->getMimeType();

            $image->save();
            $data=['status'=>1,'id' => $image->id,'imageUrl' => Storage::url('medias/' . $image->image),'deleteUrl'=>route('admin.media.destroy',$image->id)];
            return response()->json($data);

        }else{
            return response()->json(['errors' => ['file' => ['The file failed to upload']]], 422);
        }
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $image = Media::where('id',$id)->first();
            if(!empty($image) && count($image->toArray())>0){
                    $exists = Storage::exists('medias/'.$image->image);
                    if($exists){
                        Storage::delete('medias/'.$image->image);
                    }
                    $image->delete();
                    return response()->json(['status'=>1,'message'=>"Image deleted!"]);
            }else{
                return response()->json(['status'=>0,'message'=>"Sorry! This image not found in our records"]);
            }
        
    }
}
