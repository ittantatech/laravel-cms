<?php 
use Illuminate\Support\Facades\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

if(!function_exists('classActivePath'))
{	
	/**
	 * classActivePath
	 *
	 * @param  mixed $path
	 * @return void
	 */
	function classActivePath($path=array())
	{
		return Request::is($path) ? ' active' : '';
	}
}

if(!function_exists('classActiveSegment'))
{	
	/**
	 * classActiveSegment
	 *
	 * @param  mixed $segment
	 * @param  mixed $value
	 * @return void
	 */
	function classActiveSegment($segment, $value)
	{
		if(!is_array($value)) {
            return Request::segment($segment) == $value ? ' class="active"' : '';
        }
        foreach ($value as $v) {
            if(Request::segment($segment) == $v) return ' class="active"';
        }
        return '';
	}
}

if(!function_exists('classActiveSegmentMenu'))
{    
    /**
     * classActiveSegmentMenu
     *
     * @param  mixed $segment
     * @param  mixed $value
     * @return void
     */
    function classActiveSegmentMenu($segment, $value)
    {
        if(!is_array($value)) {
            return Request::segment($segment) == $value ? ' active' : '';
        }
        foreach ($value as $v) {
            if(Request::segment($segment) == $v) return ' active';
        }
        return '';
    }
}


if (!function_exists('classMenuOpenPath')) {    
    /**
     * classMenuOpenPath
     *
     * @param  mixed $paths
     * @param  mixed $seg
     * @return void
     */
    function classMenuOpenPath($paths=array(),$seg=2)
    {  
        foreach ($paths as $path)
        {
            if(strpos(Request::url(),$path) && Request::segment($seg)==$path) return 'nav-item-expanded nav-item-open';
        }
        //return (strpos(Request::url(),$path)) ? 'menu-open' : '';
    }
}

/**
     * generateSlug
     *
     * @param  string $name for post title
     * @param  int $id for existing post generate and check unique slug
     * @return unique slug
     */
if(!function_exists('generateSlug')){
    function generateSlug($name,$id=0){
        $slug  = Str::slug($name);
        $original_slug = $slug;
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
}
/**
     * generateTagSlug
     *
     * @param  string $name for category or tag title
     * @param string $type for category or tag
     * @param  int $id for existing category or tag generate and check unique slug
     * @return unique slug
     */
if(!function_exists('generateTagSlug')){
    function generateTagSlug($name,$type,$id=0){
        $slug  = Str::slug($name);
        $original_slug = $slug;
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