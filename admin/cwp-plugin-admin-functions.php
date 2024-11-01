<?php
/*-----------------------------------------------------------------------------------*/
/* Default options */
/*-----------------------------------------------------------------------------------*/
function coolwp_skh_init(){
	if(is_admin()):
		global $pagenow;
		if(@$pagenow == 'options-general.php' ):
			$template = get_option('of_template');
				foreach($template as $t):
					@$option_name = $t['id'];
					@$default_value = $t['std'];
					$value_check = get_option("$option_name");
					if($value_check == ''){
					  update_option("$option_name","$default_value");
					}
				endforeach;
		endif;
	endif;
}
add_action('init','coolwp_skh_init',90);
?>