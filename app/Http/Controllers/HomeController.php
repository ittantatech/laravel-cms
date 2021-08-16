<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
class HomeController extends Controller
{
    
    /**
     * Show the application home page with all posts or tag and category base posts.
     * @param  \Illuminate\Http\Request  $request
     * @param Category or Tag $type
     * @param Category or Tag unique slug $item
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type="",$item="")
    {

        if($type == 'categories'){
            if(!empty($item)){
                $category = Category::where('slug',$item)->where('type','category')->where('status',1)->first();
            }else{
                $category = Category::where('type','category')->where('status',1)->latest()->first();
            }
            $posts = $category->posts;
            $is_cat = "cat";
            $cat_name = $category->name;
        }elseif($type == 'tags'){
            if(!empty($item)){
                $category = Category::where('slug',$item)->where('type','tag')->where('status',1)->first();
            }else{
                $category = Category::where('type','tag')->where('status',1)->latest()->first();
            }
            $posts = $category->posts;
            $is_cat = "tag";
            $cat_name = $category->name;
        }else{
            $posts = Post::where('post_status',1)->with(['tags','categories'])->get();
            $is_cat = "home";
            $cat_name = "ALL";
        }
        
        $recentPosts = Post::where('post_status',1)->with(['tags','categories'])->limit(5)->latest()->get();
        $categories = Category::withCount('posts')->where(['type'=>'category','status'=>1])->get();
        $tags = Category::withCount('posts')->where(['type'=>'tag','status'=>1])->get();
        return view('home',['posts' => $posts,'recentPosts' => $recentPosts,'categories'=>$categories,'tags' => $tags,'is_cat'=>$is_cat,'cat_name'=>$cat_name]);
    }

    /**
     * Display the specified resource.
     *
     * @param  post_slug  $post_slug
     * @return \Illuminate\Http\Response
     */
    public function show($post_slug){
        $post = Post::where('post_slug',$post_slug)->where('post_status',1)->first();
        
        // Check post is empty or not if empty then display 404 page
        if(empty($post)){
            return abort(404);
        }

        $nextPost = Post::where('id','>',$post->id)->where('post_status',1)->latest()->first();
        $prevPost = Post::where('id','<',$post->id)->where('post_status',1)->latest()->first();
        return view('post',['post'=>$post,'nextPost' => $nextPost,'prevPost' => $prevPost]);
    }
}
