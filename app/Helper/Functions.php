<?php 
use Illuminate\Support\Facades\Request;
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