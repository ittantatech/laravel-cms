@extends('layouts.app')

@section('content')
<!-- Categories Section Begin -->
<section class="categories categories-grid spad">
        <div class="categories__post">
            <div class="container">
                <div class="categories__grid__post">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="breadcrumb__text">
                                @if($is_cat == 'home')
                                    <h2>Categories: <span>ALL</span></h2>
                                    <div class="breadcrumb__option">
                                        <a href="{{route('home')}}">Home</a>
                                    </div>
                                @endif
                                @if($is_cat == 'tag')
                                    <h2>Tag: <span>{{$cat_name}}</span></h2>
                                    <div class="breadcrumb__option">
                                        <a href="{{route('home')}}">Home</a>
                                        <span>{{ $cat_name }}</span>
                                    </div>
                                @endif
                                @if($is_cat == 'cat')
                                    <h2>Category: <span>{{$cat_name}}</span></h2>
                                    <div class="breadcrumb__option">
                                        <a href="{{route('home')}}">Home</a>
                                        <span>{{ $cat_name }}</span>
                                    </div>
                                @endif
                                
                            </div>
                            <div class="row masonry-layout">
                                @if(!empty($posts))
                                    @foreach($posts as $index => $post)
                                        <div class="col-lg-6 col-md-6 col-sm-6 categories__post__item">
                                            <div class="shadow-div">
                                                @if(!empty($post->getPostMeta('feature_image')))
                                                    @if(!empty($post->getFeaturedImage($post->getPostMeta('feature_image')->meta_value)))
                                                        <div class="{{$index}} categories__post__item__pic">
                                                            <img src="{{$post->getFeaturedImage($post->getPostMeta('feature_image')->meta_value)}}">
                                                            <div class="post__meta">
                                                                <h4>{{$post->created_at->format('d')}}</h4>
                                                                <span>{{$post->created_at->format('M')}}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="categories__post__item__text">
                                                    @if(!empty($post->categories))
                                                        <ul class="post__label--large">
                                                            @foreach($post->categories as $category)
                                                                <li>{{$category->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <h3><a href="{{route('home',$post->post_slug)}}">{{$post->post_title}}</a></h3>
                                                    <ul class="post__widget">
                                                        <li>by <span>{{$post->admin->name}}</span></li>
                                                    </ul>
                                                    <p>{{$post->post_excerpt}}</p>
                                                </div>
                                            </div>
                                        </div>    
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="sidebar__item">
                                <div class="sidebar__follow__item">
                                    <div class="sidebar__item__title">
                                        <h6>Follow me</h6>
                                    </div>
                                    <div class="sidebar__item__follow__links">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                                        <a href="#"><i class="fa fa-instagram"></i></a>
                                        <a href="#"><i class="fa fa-envelope-o"></i></a>
                                    </div>
                                </div>
                                @if(!empty($recentPosts))
                                <div class="sidebar__feature__item">
                                    <div class="sidebar__item__title">
                                        <h6>Recent Posts</h6>
                                    </div>
                                    
                                    <div class="sidebar__feature__item__list">
                                    @foreach($recentPosts as $post)
                                        <div class="sidebar__feature__item__list__single">
                                            <div class="post__meta">
                                                <h4>{{$post->created_at->format('d')}}</h4>
                                                <span>{{$post->created_at->format('M')}}</span>
                                            </div>
                                            <div class="post__text">
                                                <span>{{$post->categories->first()->name}}</span>
                                                <h5><a href="#">{{$post->post_title}}</a></h5>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @if(!empty($categories))
                                <div class="sidebar__item__categories">
                                    <div class="sidebar__item__title">
                                        <h6>Categories</h6>
                                    </div>
                                    <ul>
                                        @foreach($categories as $category)
                                            <li><a href="{{route('home',['categories',$category->slug])}}">{{$category->name}} <span>{{$category->posts_count}}</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @if(!empty($categories))
                                <div class="sidebar__item__categories">
                                    <div class="sidebar__item__title">
                                        <h6>Tags</h6>
                                    </div>
                                    <ul>
                                        @foreach($tags as $tag)
                                            <li><a href="{{route('home',['tags',$tag->slug])}}">{{$tag->name}} <span>{{$tag->posts_count}}</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->
@endsection
