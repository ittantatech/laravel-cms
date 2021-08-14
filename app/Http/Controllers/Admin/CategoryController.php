<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        if($request->ajax()){
            $query = Category::where('type',$type);
            return datatables()->of($query)
            ->editColumn('created_at', function ($result) {
                return $result->created_at->format('Y-m-d');
            })
            ->editColumn('parent',function($result){
                return "-";
            })
            ->addColumn('action', function($result){
                $html='<div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">';
                            $html.='<a href="javascript:void(0);" data-url="'.route('admin.categories.edit',[$result->type,$result->id]).'" class="dropdown-item load_popup" title="Edit"><i class="icon-pencil7"></i> Edit</a>
                                <a href="javascript:void(0);" class="dropdown-item delete-record" title="Delete"><i class="icon-trash"></i> Delete</a>
                                <form method="post" action="'.route('admin.categories.destroy',[$result->type,$result->id]).'" class="delete-form" onsubmit="return confirm(\'Are you sure delete this item with his data?\');">
                                    <input type="hidden" name="_method" value="delete" />
                                    '.csrf_field().'
                                </form>
                            </div>
                        </div>
                    </div>';
                return $html;
            })->toJson();
        }

        return view("admin.{$type}.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$type)
    {
        
        $categories = Category::where(['parent_id'=>0,'status'=>1])->get();
        $html = View::make("admin.{$type}.create",['categories'=>$categories]);
        return $html;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$type)
    {
        $category = new Category();
        $category->name = $request->get('name');
        $category->type = $type;
        $category->status = $request->get('status');
        $category->slug = $this->generateSlug($request->get('name'),$type);
        $category->parent_id = $request->get('category',0);
        $category->save();
        return response()->json(['status'=>1,'message'=>"{$type} added!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$type,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$type,$id)
    {
        $category = Category::where(['type'=>$type,'id'=>$id])->first();
        $categories = Category::where(['parent_id'=>0,'status'=>1])->whereNotIn('id',[$id])->get();
        $html = View::make("admin.{$type}.edit",['categories'=>$categories,'category'=>$category]);
        return $html;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$type, $id)
    {
        $category = Category::where(['type'=>$type,'id'=>$id])->first();
        $category->name = $request->get('name');
        $category->status = $request->get('status');
        $category->slug = $this->generateSlug($request->get('name'),$type,$id);
        $category->parent_id = $request->get('category',0);
        $category->save();
        return response()->json(['status'=>1,'message'=>"{$type} updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$type,$id)
    {
        Category::where(['type'=>$type,'id'=>$id])->delete();
        return response()->json(['status'=>1,'message'=>"{$type} deleted!"]);
    }

    protected function generateSlug($name,$type,$id=0){
        $slug  = Str::slug($name);
        $original_slug = $slug;
        /*
        if($id>0){
            $count = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id','!=',$id)->count();
        }else{
            $count = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        }
        // if other slugs exist that are the same, append the count to the slug
        return $count ? "{$slug}-{$count}" : $slug;*/


          $count = 1;
          if($id > 0){
            while (Category::whereSlug($slug)->whereNotIn('id',[$id])->where('type',$type)->exists()) {
                $slug = "{$original_slug}-" . $count++;
            }
          }else{
            while (Category::whereSlug($slug)->where('type',$type)->exists()) {
                $slug = "{$original_slug}-" . $count++;
            }
          }
          
          return $slug;
    }
}
