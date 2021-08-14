@extends('admin.layouts.app')
@section('css')
<style>
    .dropzone .dz-default.dz-message{height: auto;}
.dropzone.dz-started{background: none !important; border: none !important; box-shadow: none !important;}
.dropzone.dz-started:hover{background: none !important; border: none !important; box-shadow: none !important;}
.dropzone .dz-preview .dz-remove{  margin-top: 0px; z-index: 50; }
.dropzone .dz-preview .dz-error-message { top: 145px; /*left: -20px;*/ }
.dropzone .dz-preview .dz-details{ padding-top: 0em; font-size: 12px;  }
.dropzone .dz-preview .dz-details .dz-size{ margin-bottom: 0em; }
.dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark{ top: 32%; /*left: 43%;*/}
.dropzone.dz-drag-hover .cta.button-orange-outline{
  opacity: 0.5;
}
.dropzone.dz-drag-hover .text-note{
  opacity: 0.5;
}
/* Hide the progress bar when finished */
.previewtable .file-row.dz-success .progress {
  opacity: 0;
  transition: opacity 0.3s linear;
}

/* Hide the delete button initially */
.previewtable .file-row .delete {
  display: none;
}

/* Hide the start and cancel buttons and show the delete button */

.previewtable .file-row.dz-success .start,
.previewtable .file-row.dz-success .cancel {
  display: none;
}
.previewtable .file-row.dz-success .delete {
  display: block;
}
.file-row {
    border-bottom: 0px solid #ccc;
    background: rgba(0,0,0,.03);
    padding: 22px;
    margin-bottom: 8px;
    border-radius: 10px;
}
.error-div {
    margin: 10px 0;
}
.prograss-div{margin-bottom: 10px;}
.progress-2{
  height: 12px;
  background-image:-webkit-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);
  background-image:linear-gradient(to bottom,#ebebeb 0,#f5f5f5 100%);
  background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffebebeb', endColorstr='#fff5f5f5', GradientType=0)
}
.progress-bar-2{
  height: 12px;
  background: rgba(34,172,217,1);
}
.image-content img {
    width: 200px; /* You can set the dimensions to whatever you want */
    height: 200px;
    object-fit: cover;
}
.image-content{
  padding: 0 5px;
  margin-bottom: 10px;
}

</style>
@endsection
@section('content')
<form method="post" action="{{route('admin.posts.update',$post->id)}}">
  @csrf
  @method('PATCH')
    <input type="hidden" name="attachment_ids" value="{{!empty($post->getPostMeta('feature_image')) ? $post->getPostMeta('feature_image')->meta_value :''}}" id="attachment_ids">
    <div class="form-group text-right">
      <button type="submit" class="btn btn-lg btn-dark">Save</button>
    </div>
              
    <div class="row">
      
	    <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" value="{{old('title',$post->post_title)}}" class="form-control">
                        @if ($errors->has('title'))
				                    <span class="text-danger">
				                        <strong>{{ $errors->first('title') }}</strong>
				                    </span>
				                @endif
                    </div>
                    <div class="form-group">
                        <label for="title">{{ __('Content') }}</label>
                        <textarea class="editor" id="editor" name="content">{{old('content',$post->post_content)}}</textarea>
                        @if ($errors->has('content'))
				                    <span class="text-danger">
				                        <strong>{{ $errors->first('content') }}</strong>
				                    </span>
				                @endif
                    </div>
                    <div class="form-group">
                        <label for="title">{{ __('Excerpt') }}</label>
                        <textarea class="form-control" name="excerpt">{{old('excerpt',$post->post_excerpt)}}</textarea>
                        @if ($errors->has('excerpt'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('excerpt') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
              <div class="card-header bg-transparent">
                  <span class="card-title font-weight-semibold">Tags</span>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <select class="form-control  tag-select" name="tags[]" multiple="multiple">
                    @if(!empty($tags))
                      @foreach($tags as $tag)
                      <option value="{{$tag->id}}" @if(!empty($post->tags) && in_array($tag->id,$post->tags->pluck('id')->toArray())) selected="selected" @endif>{{$tag->name}}</option>      
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="sidebar-content">
              <div class="card">
                    <div class="card-header bg-transparent">
                        <span class="card-title font-weight-semibold">Status</span>
                    </div>
                    <div class="card-body p-0">
                      <div class="form-control">
                        <select name="status" class="form-control">
                              <option value="1" @if(1 == $post->post_status) selected="selected" @endif>Published</option>
                              <option value="0" @if(0 == $post->post_status) selected="selected" @endif>Unpublished</option>
                        </select>
                          @if ($errors->has('status'))
                          <span class="text-danger  pl-3 pb-1">
                              <strong>{{ $errors->first('status') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                </div>
              <div class="card">
                    <div class="card-header bg-transparent">
                        <span class="card-title font-weight-semibold">Author</span>
                    </div>
                    <div class="card-body p-0">
                      <div class="form-control">
                        <select name="author" class="form-control">
                          @if(!empty($admins))
                            @foreach($admins as $admin)
                              <option value="{{$admin->id}}" @if($admin->id == $post->admin_id) selected="selected" @elseif(auth()->user()->id == $admin->id) selected="selected" @endif >{{$admin->name}}</option>
                            @endforeach
                          @endif
                        </select>
                        @if ($errors->has('author'))
                          <span class="text-danger  pl-3 pb-1">
                              <strong>{{ $errors->first('author') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-transparent">
                        <span class="card-title font-weight-semibold">Categories</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="nav nav-sidebar my-2">
                          @if(!empty($categories))
                            @foreach($categories as $category)
                              <li class="nav-item pl-3 pb-1">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input type="checkbox" class="form-check-input-styled" @if(!empty($post->categories) && in_array($category->id,$post->categories->pluck('id')->toArray())) checked="checked" @endif name="categories[]" value="{{$category->id}}">{{$category->name}}</label>
                                  </div>
                              </li>
                            @endforeach
                          @endif
                          @if ($errors->has('categories'))
				                    <span class="text-danger  pl-3 pb-1">
				                        <strong>{{ $errors->first('categories') }}</strong>
				                    </span>
				                @endif
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">{{__('Post Image')}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="dropzone" id="dropzoneProductImageUpload" @if(!empty($post->getPostMeta('feature_image')) && !empty($post->getFeaturedImage($post->getPostMeta('feature_image')->meta_value))) style="display:none" @endif></div>
                        <div class="table table-striped previewtable" class="files" id="previews">

                        <div id="template" class="file-row">
                            <!-- This is used as the file preview template -->
                            <div class="image-div">
                                <span class="preview"><img data-dz-thumbnail /></span>
                            </div>
                            <div class="name-div">
                                <p class="name short" data-dz-name></p>
                            <p class="size" data-dz-size></p>
                            </div>
                            <div class="error-div">
                            <strong class="error text-danger" data-dz-errormessage></strong>
                            </div>
                            <div class="prograss-div">
                                <div class="progress-2" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-2" style="width:0%;" data-dz-uploadprogress></div>
                                </div>
                            </div>
                            <div class="button-div">
                            <button data-dz-remove class="btn btn-danger cancel"><i class="fa fa-trash"></i><span>Cancel</span></button>
                            </div>
                        </div>

                        </div>
                        <div class="product-images-main-container mt-3">
                        <div class="row" id="products-images">
                            @if(!empty($post->getPostMeta('feature_image')))
                                @if(!empty($post->getFeaturedImage($post->getPostMeta('feature_image')->meta_value)))
                                <div class="image-content card-img-actions" data-attachment-id="{{$post->getPostMeta('feature_image')->meta_value}}">
                                    <img class="card-img" src="{{$post->getFeaturedImage($post->getPostMeta('feature_image')->meta_value)}}" alt="">
                                    <div class="card-img-actions-overlay card-img">
                                    <a href="javascript:void(0);" class="delete-attachment-2 text-danger" title="Delete Image" data-href="#">
                                        <i class="icon-close2 icon-2x"></i>
                                    </a>
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-lg btn-dark">Save</button>
    </div>
</form>

<template id="image-template">
  <div class="image-content card-img-actions" data-attachment-id="__ATTACHMENT_ID__">
    <img class="card-img" src="__IMGURL__" alt="">
    <div class="card-img-actions-overlay card-img">
      <a href="javascript:void(0);" class="delete-attachment text-danger" title="Delete Image" data-href="__DELETE_URL__">
        <i class="icon-close2 icon-2x"></i>
      </a>
    </div>
  </div>
</template>
@endsection
@section('js')
<script type="text/javascript">
  var token = $('meta[name="csrf-token"]').attr('content');
  var previewNode;
  var previewTemplate;
  var url="{{route('admin.media.store')}}";
  
  var image_template = $('#image-template');
  var image_template_html = image_template.html();
  image_template.remove();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
  });
  previewNode = document.querySelector("#template");
  previewNode.id = "";
  previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);
  Dropzone.options.dropzoneProductImageUpload = {
    url:url,
    params: {
      _token: token
    },
    acceptedFiles: ".png,.jpg,.jpeg",
      //thumbnailWidth: 80,
      //thumbnailHeight: 80,
      previewTemplate: previewTemplate,
      previewsContainer: "#previews",
      paramName: "file", // The name that will be used to transfer the file
      dictDefaultMessage: 'Drop questions files to upload <span>or CLICK</span>',
      init: function() {
        var self = this;
        self.on("success", function (file, responseText) {
          file.id = responseText.id;
          var option_html = image_template_html.replace(/__IMGURL__/g,file.dataURL);
          option_html = option_html.replace(/__ATTACHMENT_ID__/g,file.id);
          option_html = option_html.replace(/__DELETE_URL__/g,responseText.deleteUrl);
          $("#products-images").append(option_html);
          self.removeFile(file);
          //Dropzone.instances.forEach(bz => bz.destroy());
            $(".dropzone").hide();
        }),
        self.on("error",function(file, message){
          file.previewElement.classList.add("dz-error");
          if(file.status == 'canceled'){
            file.previewElement.querySelector("[data-dz-errormessage]").textContent = "Upload Cancelled";
          }else{
            if(typeof message !=='object'){
              file.previewElement.querySelector("[data-dz-errormessage]").textContent = message;
            }else{
              file.previewElement.querySelector("[data-dz-errormessage]").textContent = message.errors.file;
            }
          }
        }),
        self.on("canceled",function(file){
          self.removeFile(file);
          return false;
        }),
        this.on("complete", function (file) {
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            updateAttachmentIds();
          }
        })
      }
    };
    jQuery(document).ready(function($){
        $('#editor').summernote();
        $('.form-check-input-styled').uniform();
        $('.tag-select').select2({
          tags:true
        });


        $(document).on("click",".delete-attachment",function(){
            var url = $(this).data('href');
            var obj= $(this);
            $.ajax({
                url:url,
                dataType:"json",
                type:"post",
                data:{_method:"delete"},
                beforeSend:function(){
                },
                success:function(res){
                    obj.parents('.image-content').remove();
                    if(res.status==1){
                        toastr.success(res.message);
                        $(".dropzone").show();
                        updateAttachmentIds();
                    }else{
                        toastr.error(res.message);
                    }
                },
                error:function(){
                    toastr.error("Image not deleted!");
                }
            });
        
        });
        $(document).on("click",".delete-attachment-2",function(){
            var obj= $(this);
            obj.parents('.image-content').remove();
            $(".dropzone").show();
        });
    });

    function updateAttachmentIds(){
        var sorted = [];
        $('#products-images .image-content').each(function() {
            sorted.push( $(this).data('attachment-id') );
        });
        $('#attachment_ids').val( sorted.join(',') );
    }

</script>
@endsection