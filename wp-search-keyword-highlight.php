<?php
/*
**************************************************************************
Plugin Name: WP Search Keyword Highlight
Plugin URI: http://suoling.net/wp-search-keyword-highlight
Description: Installs 'WP Search Keyword Highlight' on your wordpress blog so it will highlight the search keyword(s) each time,you can specify the background color and the text color for the search keyword(s).
Version: 1.0
Author: Suifengtec
Author URI: http://suoling.net/
Text Domain: skh
Domain Path: /lang/
**************************************************************************
*/
/*  Copyright 2014  Suifengtec  (email :coolwp.com@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*SKH=Search Keyword Highlight*/

define('CWP_PLUGIN_SKH_URI',plugin_dir_url( __FILE__ ));
define('CWP_PLUGIN_SKH_SLUG','skh');
define('CWP_PLUGIN_SKH_VERSION','1.0');

//You can change this default setting.
define('CWP_PLUGIN_SKH_DEFAULT_BG_COLOR','#ff0');
define('CWP_PLUGIN_SKH_DEFAULT_TEXT_COLOR','#de6862');

//Option page
require_once( 'admin/init.php' );


add_action( 'plugins_loaded', 'coolwp_skh_load_textdomain' );
function coolwp_skh_load_textdomain(){

    load_plugin_textdomain( 'skh', '', dirname( plugin_basename( __FILE__ ) ) . '/lang' );


}


//Search Keyword(s) Highlighting
add_filter("the_title", "coolwp_plugin_skh", 200);
add_filter("the_excerpt", "coolwp_plugin_skh", 200);
add_filter("the_content", "coolwp_plugin_skh", 200);
function coolwp_plugin_skh($buffer){
	$coolwp_skh_turn_on=get_option('skh_turn_on');
	$default_bg_color=CWP_PLUGIN_SKH_DEFAULT_BG_COLOR;
	$default_text_color=CWP_PLUGIN_SKH_DEFAULT_TEXT_COLOR;
	$bgcolor=get_option('skh_bgcolor')?trim(get_option('skh_bgcolor')):$default_bg_color;
	$text_color=get_option('skh_color')?trim(get_option('skh_color')):$default_text_color;

    if(is_search()){
        $arr = explode(" ", get_search_query());
        $arr = array_unique($arr);
        foreach($arr as $v)
            if($v)
            	if($coolwp_skh_turn_on=='true'){
                $buffer = preg_replace("/(".$v.")/i", "<span style=\"background-color:$bgcolor;background:$bgcolor;color:$text_color;\"><strong>$1</strong></span>", $buffer);
	            }else{
	 				$buffer = preg_replace("/(".$v.")/i", "<span style=\"background-color:$default_bg_color;background:$default_bg_color;color:$default_text_color;\"><strong>$1</strong></span>", $buffer);
	            }
    }
    return $buffer;
}
//Custom CSS
add_action('wp_head','coolwp_skh_custom_css',999);
function coolwp_skh_custom_css(){
	$custom_css=get_option('skh_custom_css')?get_option('skh_custom_css'):'';
	if($custom_css!=''){
		$output='<style>';
		$output.=$custom_css;
		$output.="\n</style>";
		echo $output;
	}else{
		return;
	}
}