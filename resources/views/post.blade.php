@extends('layouts.app')

@section('content')
<!-- Single Post Section Begin -->
<section class="single-post spad">
        <div class="single-post__hero set-bg" data-setbg="{{$post->getFeaturedImage($post->getPostMeta('feature_image')->meta_value)}}"></div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="single-post__title">
                        <div class="single-post__title__meta">
                            <h2>{{$post->created_at->format('d')}}</h2>
                            <span>{{$post->created_at->format('M')}}</span>
                        </div>
                        <div class="single-post__title__text">
                            @if(!empty($post->categories))
                                <ul class="label">
                                    @foreach($post->categories as $category)
                                        <li>{{$category->name}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <h4>{{$post->post_title}}</h4>
                            <ul class="widget">
                                <li>by {{$post->admin->name}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="single-post__social__item">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                        </ul>
                    </div>
                    <div class="single-post__top__text">
                        {!! $post->post_content !!}
                    </div>
                    <div class="single-post__tags">
                        @if(!empty($post->tags))
                            @foreach($post->tags as $tag)
                                <a href="#">{{$tag->name}}</a>
                            @endforeach
                        @endif
                    </div>
                    <div class="single-post__next__previous">
                        <div class="row">
                            
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            @if(!empty($prevPost))
                                <a href="{{route('home',$prevPost->post_slug)}}" class="single-post__previous">
                                    <h6><span class="arrow_carrot-left"></span> Previous posts</h6>
                                    <div class="single-post__previous__meta">
                                        <h4>{{$prevPost->created_at->format('d')}}</h4>
                                        <span>{{$prevPost->created_at->format('M')}}</span>
                                    </div>
                                    <div class="single-post__previous__text">
                                        <span>Dinner</span>
                                        <h5>{{$prevPost->post_title}}</h5>
                                    </div>
                                </a>
                                @endif
                            </div>
                           
                            
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            @if(!empty($nextPost))
                                <a href="{{route('home',$nextPost->post_slug)}}" class="single-post__next">
                                    <h6>Next posts <span class="arrow_carrot-right"></span> </h6>
                                    <div class="single-post__next__meta">
                                        <h4>{{$nextPost->created_at->format('d')}}</h4>
                                        <span>{{$nextPost->created_at->format('M')}}</span>
                                    </div>
                                    <div class="single-post__next__text">
                                        <span>Smoothie</span>
                                        <h5>{{$nextPost->post_title}}</h5>
                                    </div>
                                </a>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Single Post Section End -->
@endsection