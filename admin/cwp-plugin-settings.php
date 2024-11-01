<?php

add_action('init','coolwp_plugin_skh_options');
if (!function_exists('coolwp_plugin_skh_options')) {
function coolwp_plugin_skh_options(){
$shortname = CWP_PLUGIN_SKH_SLUG;

//Populate the options array
global $tt_options;
$tt_options = get_option('of_options');

/*-----------------------------------------------------------------------------------*/
/* Coolwp Search keyword highlighting Options Panel
/*-----------------------------------------------------------------------------------*/
$options = array();

/* General Options */
$options[] = array( "name" => __('General',CWP_PLUGIN_SKH_SLUG),
			"type" => "heading");

$options[] = array( "name" => __('Info',CWP_PLUGIN_SKH_SLUG),
			"desc" => "",
			"id" => $shortname."_general_callout",
			"std" => "This plugin will highlight the search keyword(s) on the search result page(s).",
			"type" => "info");

$options[] = array( "name" => __('Specify Colors?',CWP_PLUGIN_SKH_SLUG),
			"desc" => __('If you want to specify the background color and the text color for your search keyword(s),check this box;<br> or will use the default setting,ex: <span style="background-color:'.CWP_PLUGIN_SKH_DEFAULT_BG_COLOR.';background:'.CWP_PLUGIN_SKH_DEFAULT_BG_COLOR.';color:'.CWP_PLUGIN_SKH_DEFAULT_TEXT_COLOR.'">Suifengtec</span>,and the following options will be NOT in use. ',CWP_PLUGIN_SKH_SLUG),
			"id" => $shortname."_turn_on",
			"std" => "true",
			"type" => "checkbox");

$options[] = array( "name" => __('Background Color for your search keyword(s)',CWP_PLUGIN_SKH_SLUG),
			"desc" => __('Pick a color as the  background color of search keyword(s).',CWP_PLUGIN_SKH_SLUG),
			"id" => $shortname."_bgcolor",
			"std" => "",
			"type" => "color");

$options[] = array( "name" => __('Text Color for your search keyword(s)',CWP_PLUGIN_SKH_SLUG),
			"desc" => __('Pick a color as the text color of  your search keyword(s).',CWP_PLUGIN_SKH_SLUG),
			"id" => $shortname."_color",
			"std" => "",
			"type" => "color");

$options[] = array( "name" => __('Your CSS',CWP_PLUGIN_SKH_SLUG),
			"desc" => "Additional CSS (also for your wordpress theme).",
			"id" => $shortname."_custom_css",
			"std" => "",
			"type" => "textarea");


/* /////////////////////////////////////General Options END */
/* Help and Support */
$options[] = array( "name" => __('Help',CWP_PLUGIN_SKH_SLUG),
			"type" => "heading");


$options[] = array( "name" => __('Help & Support',CWP_PLUGIN_SKH_SLUG),
			"desc" => "",
			"id" => $shortname."_help_callout",
			"std" => "
<h3>Features&Usage</h3>
			<p>
			<ul>
			<li>Highlight Your Search Keyword(s);</li>
			<li>(Optional)Sepecify a background color and/or a text color for your search keyword(s),Just a Click;</li>
			</ul>
			</p>
<h3>Support</h3>
			<p><ul>
				<li>Please feel free to contact Coolwp:<a href=https://www.facebook.com/Coolwpcom target=_blank title='Suifengtec at Facebook'>Coolwp</a></li>
<li>Plugin Homepage: <a href=http://suoling.net/wp-search-keyword-highlight/ target=_blank title='The homepage of WP Search Keyword(s) Highlight'>Here</a></li>.
			</ul></p>
			",
			"type" => "info");

update_option('of_template',$options);
update_option('of_shortname',$shortname);
}
}
?>