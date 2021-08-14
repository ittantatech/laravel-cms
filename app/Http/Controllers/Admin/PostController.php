<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PostMeta;
use App\Models\Admin;
class PostController extends Controller
{
    protected $settings;

    public function __construct() {
        $this->settings = config()->get('settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('browse-post');
        if($request->ajax()){
            $query = Post::with(['categories','tags','postMeta'])->join('admins','admins.id','=','posts.admin_id')->select('posts.*','admins.name');
            return datatables()->of($query)
            ->editColumn('created_at', function ($result) {
                return $result->created_at->format('Y-m-d');
            })
            ->editColumn('image', function ($result) {
                $image = $result->getPostMeta('feature_image');
                if(!empty($image)){
                    return $result->getFeaturedImage($image->meta_value);
                }
                return "";
            })
            ->editColumn('categories', function ($result) {
                return $result->categories()->pluck('name')->implode(', ');
            })
            ->editColumn('tags', function ($result) {
                return $result->tags()->pluck('name')->implode(', ');
            })
            ->addColumn('action', function($result){
                $html='<div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">';
                            $html.='<a href="'.route('admin.posts.edit',$result->id).'" class="dropdown-item" title="Edit"><i class="icon-pencil7"></i> Edit</a>
                                <a href="javascript:void(0);" class="dropdown-item delete-record" title="Delete"><i class="icon-trash"></i> Delete</a>
                                <form method="post" action="'.route('admin.posts.destroy',$result->id).'" class="delete-form" onsubmit="return confirm(\'Are you sure delete this post with his data?\');">
                                    <input type="hidden" name="_method" value="delete" />
                                    '.csrf_field().'
                                </form>
                            </div>
                        </div>
                    </div>';
                return $html;
            })->toJson();
        }
        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-post');
        $categories = Category::whereType('category')->whereStatus(1)->get();
        $tags = Category::whereType('tag')->whereStatus(1)->get();
        $admins = Admin::latest()->get();
        return view('admin.post.create',['categories'=>$categories,'tags'=>$tags,'admins'=>$admins]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->authorize('add-post');
        $rules = [
            'categories' => 'required',
            'title' => 'required',
            'content' => 'required'
        ];
        $request->validate($rules);

        $attachment = $request->get('attachment_ids');
        $categories = $request->get('categories');
        $tags = $request->get('tags');
        $content = $request->get('content');
        $title = $request->get('title');

        $post = new Post();
        $post->post_title = $title;
        $post->post_content = $content;
        $post->post_slug = $this->generateSlug($title);
        $post->post_status = 1;
        $post->post_excerpt = $request->get('excerpt');
        $post->admin_id = ($request->has('author')?$request->has('author'):$request->user()->id);
        if($post->save()){
            if(!empty($attachment)){
                PostMeta::create([
                    'post_id' => $post->id,
                    'meta_key' => 'feature_image',
                    'meta_value' => $attachment
                ]);
            }
            if(!empty($categories)){
                $post->categories()->syncWithPivotValues($categories,['type'=>'category']);
            }
            $tagIds = [];
            if(!empty($tags)){
                
                foreach($tags as $tag){
                    if(sprintf('%d',$tag) == 0){
                        $tagIds[]=$this->createTag($tag);
                    }else{
                        $tagIds[]= $tag;
                    }
                }
                $post->tags()->syncWithPivotValues($tagIds,['type'=>'tag']);
            }
        }
        flash("Post Added")->success();
        return redirect(route('admin.posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('browse-post');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-post');
        $post = Post::findOrFail($id);
        $post->load('categories');
        $post->load('tags');
        $post->load('postMeta');

        $categories = Category::whereType('category')->whereStatus(1)->get();
        $tags = Category::whereType('tag')->whereStatus(1)->get();
        $admins = Admin::latest()->get();

        return view('admin.post.edit',['post'=>$post,'categories'=>$categories,'tags'=>$tags,'admins'=>$admins]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit-post');
        $rules = [
            'categories' => 'required',
            'title' => 'required',
            'content' => 'required'
        ];
        $request->validate($rules);

        $post = Post::findOrFail($id);

        $attachment = $request->get('attachment_ids');
        $categories = $request->get('categories');
        $tags = $request->get('tags');
        $content = $request->get('content');
        $title = $request->get('title');

        $post->post_title = $title;
        $post->post_content = $content;
        $post->post_slug = $this->generateSlug($title,$post->id);
        $post->post_status = $request->get('status');
        $post->post_excerpt = $request->get('excerpt');
        $post->admin_id = ($request->has('author')?$request->has('author'):$request->user()->id);
        if($post->save()){
            if(!empty($attachment)){
                $meta = PostMeta::firstOrNew([
                    'post_id' => $post->id,
                    'meta_key' => 'feature_image'
                ]);
                $meta->meta_value = $attachment;
                $meta->save();
            }else{
                $image = $post->getPostMeta('feature_image');
                if(!empty($image)){
                    return $image->delete();
                }
            }
            if(!empty($categories)){
                $post->categories()->syncWithPivotValues($categories,['type'=>'category']);
            }
            $tagIds = [];
            if(!empty($tags)){
                
                foreach($tags as $tag){
                    if(sprintf('%d',$tag) == 0){
                        $tagIds[]=$this->createTag($tag);
                    }else{
                        $tagIds[]= $tag;
                    }
                }
                $post->tags()->syncWithPivotValues($tagIds,['type'=>'tag']);
            }
        }
        flash("Post Updated")->success();
        return redirect(route('admin.posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-post');
        $post = Post::findOrFail($id);
        $post->delete();
        flash("Post deleted")->success();
        return redirect(route('admin.posts.index'));
    }

    protected function createTag($tag){
        $category = new Category();
        $category->name = $tag;
        $category->type = 'tag';
        $category->status = 1;
        $category->slug = $this->generateSlug($tag,'tag');
        $category->save();
        return $category->id;
    }

    protected function generateSlug($name,$id=0){
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
            while (Post::wherePostSlug($slug)->whereNotIn('id',[$id])->exists()) {
                $slug = "{$original_slug}-" . $count++;
            }
          }else{
            while (Post::wherePostSlug($slug)->exists()) {
                $slug = "{$original_slug}-" . $count++;
            }
          }
          
          return $slug;
    }

    protected function generateTagSlug($name,$type,$id=0){
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
