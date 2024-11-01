<?php
/*admin UI for Coolwp Style Code*/
function coolwp_skh_style_code_add_admin() {

    global $query_string;

    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'coolwp_skh' ) {
		if (isset($_REQUEST['of_save']) && 'reset' == $_REQUEST['of_save']) {
			$options =  get_option('of_template');
			coolwp_skh_reset_options($options,'coolwp_skh');
			header("Location: admin.php?page=coolwp_skh");
			die;
		}
    }

    $tt_page = add_options_page('SKH Pannel', __('SKH Pannel'), 'edit_plugins', 'coolwp_skh', 'coolwp_skh_options_page');
	add_action("admin_print_scripts-$tt_page", 'coolwp_skh_js');
	add_action("admin_print_styles-$tt_page",'coolwp_skh_style');
}

add_action('admin_menu', 'coolwp_skh_style_code_add_admin');

/*-----------------------------------------------------------------------------------*/
/* Reset Function
/*-----------------------------------------------------------------------------------*/
function coolwp_skh_reset_options($options,$page = ''){
			$template = get_option('of_template');
			foreach($template as $t):
				@$option_name = $t['id'];
				@$default_value = $t['std'];
				update_option("$option_name","$default_value");
			endforeach;
}


/*-----------------------------------------------------------------------------------*/
/* Construct the Options Page
/*-----------------------------------------------------------------------------------*/

function coolwp_skh_options_page(){
    $options =  get_option('of_template');
?>

<div class="wrap" id="option_container">
  <div id="of-popup-save" class="of-save-popup">
    <div class="of-save-save">Updated!</div>
  </div>
  <div id="of-popup-reset" class="of-save-popup">
    <div class="of-save-reset">Reset!</div>
  </div>
  <form action="" enctype="multipart/form-data" id="ofform">
    <div id="header">
		<div class="logo">
			<h2>WP Search Keyword Highting</h2>
		</div>
		<div class="top-save-btn">
			<input type="submit" value="<?php _e('Save Changes'); ?>" class="button-primary" />
		</div>
      	<div class="clear"></div>
    </div>
    <?php $return = coolwp_plugin_skh_robot($options); ?>
    <div id="main">
      <div id="of-nav">
        <ul>
          <?php echo $return[1] ?>
        </ul>
      </div>
      <div id="content"> <?php echo $return[0]; ?> </div>
      <div class="clear"></div>
    </div>
    <div class="save_bar_top">
    <img style="display:none;" src="<?php echo CWP_PLUGIN_SKH_URI ?>/admin/images/loading_light.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Saving..." />
    <input type="submit" value="<?php _e('Save Changes'); ?>" class="button-primary" />
  </form>
  <form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="ofform-reset">
    <span class="submit-footer-reset">
    <input name="reset" type="submit" value="Reset Options" class="reset-button button-primary" onclick="return confirm('<?php _e('CAUTION: Any and all settings will be lost! Click OK to continue.',CWP_PLUGIN_SKH_SLUG); ?>');" />
    <input type="hidden" name="of_save" value="reset" />
    </span>
  </form>
</div>
<?php  if (!empty($update_message)) echo $update_message; ?>
<div style="clear:both;"></div>
</div>
<!--//wrap-->
<?php
}

/*-----------------------------------------------------------------------------------*/
/* Enqueue styles for Options Page
/*-----------------------------------------------------------------------------------*/

function coolwp_skh_style() {

	wp_enqueue_style('admin-style',CWP_PLUGIN_SKH_URI.'admin/admin-style.css');
	wp_enqueue_style('color-picker',CWP_PLUGIN_SKH_URI.'admin/colorpicker.css');
	wp_enqueue_style('admin-style-coffee',CWP_PLUGIN_SKH_URI.'admin/admin-style-coffee.css');

}


/*-----------------------------------------------------------------------------------*/
/* Enqueue javascripts for Options Page
/*-----------------------------------------------------------------------------------*/

function coolwp_skh_js() {
	add_action('admin_head', 'coolwp_of_admin_head');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('color-picker',CWP_PLUGIN_SKH_URI.'admin/js/colorpicker.js', array('jquery'));
	function coolwp_of_admin_head() {
	?>


<script type="text/javascript" language="javascript">

		jQuery(document).ready(function(){

		//JS files has be loaded?
			//Color picker
			<?php $options = get_option('of_template');

			foreach($options as $option){
			if($option['type'] == 'color'){
					$option_id = $option['id'];
					$color = get_option($option_id);

				?>
				 jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');
				 jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
					color: '<?php echo $color; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {

						jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
						jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value','#' + hex);
					}
				  });
			  <?php } } ?>

		});

		</script>

<script type="text/javascript">
			jQuery(document).ready(function(){
				var i = 0;
				jQuery('#of-nav li a').attr('id', function() {
				   i++;
				   return 'item'+i;
				});
			var flip = 0;

			jQuery('#expand_options').click(function(){
				if(flip == 0){
					flip = 1;
					jQuery('#option_container #of-nav').hide();
					jQuery('#option_container #content').width(755);
					jQuery('#option_container .group').add('#option_container .group h2').show();

					jQuery(this).text('[-]');

				} else {
					flip = 0;
					jQuery('#option_container #of-nav').show();
					jQuery('#option_container #content').width(579);
					jQuery('#option_container .group').add('#option_container .group h2').hide();
					jQuery('#option_container .group:first').show();
					jQuery('#option_container #of-nav li').removeClass('current');
					jQuery('#option_container #of-nav li:first').addClass('current');

					jQuery(this).text('[+]');

				}

			});

				jQuery('.group').hide();
				jQuery('.group:first').fadeIn();

				jQuery('.group .collapsed').each(function(){
					jQuery(this).find('input:checked').parent().parent().parent().nextAll().each(
						function(){
           					if (jQuery(this).hasClass('last')) {
           						jQuery(this).removeClass('hidden');
           						return false;
           					}
           					jQuery(this).filter('.hidden').removeClass('hidden');
           				});
           		});

				jQuery('.group .collapsed input:checkbox').click(unhideHidden);

				function unhideHidden(){
					if (jQuery(this).attr('checked')) {
						jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
					}
					else {
						jQuery(this).parent().parent().parent().nextAll().each(
							function(){
           						if (jQuery(this).filter('.last').length) {
           							jQuery(this).addClass('hidden');
									return false;
           						}
           						jQuery(this).addClass('hidden');
           					});

					}
				}
				jQuery('#of-nav li:first').addClass('current');
				jQuery('#of-nav li a').click(function(evt){

						jQuery('#of-nav li').removeClass('current');
						jQuery(this).parent().addClass('current');

						var clicked_group = jQuery(this).attr('href');

						jQuery('.group').hide();

							jQuery(clicked_group).fadeIn();

						evt.preventDefault();

					});
			//Update message popup postion
			jQuery.fn.center = function () {
				this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2+jQuery(window).scrollTop() + "px"},100);
				this.css("left", 366 );
				return this;
			}

			jQuery('#of-popup-save').center();
			jQuery(window).scroll(function() {
				jQuery('#of-popup-save').center();

			});


			//Save
			jQuery('#ofform').submit(function(){

					function newValues() {
					  var serializedValues = jQuery("#ofform").serialize();
					  return serializedValues;
					}
					jQuery(":checkbox, :radio").click(newValues);
					jQuery('.ajax-loading-img').fadeIn();
					var serializedReturn = newValues();

					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
					var data = {
						<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'coolwp_skh'){ ?>
						type: 'options',
						<?php } ?>
						action: 'of_ajax_post_action',
						data: serializedReturn
					};

					jQuery.post(ajax_url, data, function(response) {
						var success = jQuery('#of-popup-save');
						var loading = jQuery('.ajax-loading-img');
						loading.fadeOut();
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut();
						}, 2000);
					});
					return false;
				});
			});
		</script>
<?php }
}


/*-----------------------------------------------------------------------------------*/
/* Ajax Save Action
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_of_ajax_post_action', 'coolwp_of_ajax_callback');

function coolwp_of_ajax_callback() {
	global $wpdb;
	$save_type = $_POST['type'];

	if ($save_type == 'options' OR $save_type == 'framework') {
		$data = $_POST['data'];
		parse_str($data,$output);
		//Pull options
    	$options = get_option('of_template');
		foreach($options as $option_array){
			$id = $option_array['id'];
			$old_value = get_option($id);
			$new_value = '';
			if(isset($output[$id])){
				$new_value = $output[$option_array['id']];
			}
			if(isset($option_array['id'])) {
					$type = $option_array['type'];
					if ( is_array($type)){
						foreach($type as $array){
							if($array['type'] == 'text'){
								$id = $array['id'];
								$std = $array['std'];
								$new_value = $output[$id];
								if($new_value == ''){ $new_value = $std; }
								update_option( $id, stripslashes($new_value));
							}
						}
					}elseif($new_value == '' && $type == 'checkbox'){
						update_option($id,'false');
					}elseif ($new_value == 'true' && $type == 'checkbox'){
						update_option($id,'true');
					}else{
						update_option($id,stripslashes($new_value));
					}
				}
			}
	}

  die();
}

/*-----------------------------------------------------------------------------------*/
/* Various option types
/*-----------------------------------------------------------------------------------*/

function coolwp_plugin_skh_robot($options) {
    $counter = 0;
	$menu = '';
	$output = '';
	foreach ($options as $value) {
		$counter++;
		$val = '';
		//Heading-Start
		 if ( $value['type'] != "heading" )
		 {
		 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }

			$output .= '<div class="section section-'.$value['type'].' '. $class .'">'."\n";
			$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
			$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";

		 }
		 //Heading--END
		$select_value = '';
		switch ( $value['type'] ) {
			case 'text':
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "") { $val = $std; }
				$output .= '<input class="of-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $val .'" />';
			break;

			case 'textarea':
				$cols = '8';
				$ta_value = '';
				if(isset($value['std'])) {
					$ta_value = $value['std'];
					if(isset($value['options'])){
						$ta_options = $value['options'];
						if(isset($ta_options['cols'])){
						$cols = $ta_options['cols'];
						} else { $cols = '8'; }
					}
				}
					$std = get_option($value['id']);
					if( $std != "") { $ta_value = stripslashes( $std ); }
					$output .= '<textarea class="of-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';
			break;

			case "checkbox":
			   $std = $value['std'];
			   $saved_std = get_option($value['id']);
			   $checked = '';
				if(!empty($saved_std)) {
					if($saved_std == 'true') {
					$checked = 'checked="checked"';
					}
					else{
					   $checked = '';
					}
				}
				elseif( $std == 'true') {
				   $checked = 'checked="checked"';
				}
				else {
					$checked = '';
				}
				$output .= '<div class="coolwp-checkbox">	<input type="checkbox" class="checkbox of-input" name="'.  $value['id'] .'" id="'. $value['id'] .'" value="true" '. $checked .' />	<label for="'. $value['id'] .'"></label></div>';

			break;

			case "color":
				$val = $value['std'];
				$stored  = get_option( $value['id'] );
				if ( $stored != "") { $val = $stored; }
				$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
				$output .= '<input class="of-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
			break;

			case "info":
				$default = $value['std'];
				$output .= $default;
			break;

			case "heading":

				if($counter >= 2){
				   $output .= '</div>'."\n";
				}
				$jquery_click_hook = ereg_replace("[^A-Za-z0-9]", "", strtolower($value['name']) );
				$jquery_click_hook = "of-option-" . $jquery_click_hook;
				$menu .= '<li><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
				$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
			break;
		}


		if ( is_array($value['type'])) {
			foreach($value['type'] as $array){
					$id = $array['id'];
					$std = $array['std'];
					$saved_std = get_option($id);
					if($saved_std != $std){$std = $saved_std;}
					$meta = $array['meta'];

					if($array['type'] == 'text') {
						 $output .= '<input class="input-text-small of-input" name="'. $id .'" id="'. $id .'" type="text" value="'. $std .'" />';
						 $output .= '<span class="meta-two">'.$meta.'</span>';
					}
			}
		}
		if ( $value['type'] != "heading" ) {
			if ( $value['type'] != "checkbox" )
				{
				$output .= '<br/>';
				}
			if(!isset($value['desc'])){ $description_value = ''; } else{ $description_value = $value['desc']; }
			$output .= '</div><div class="description">'. $description_value .'</div>'."\n";
			$output .= '<div class="clear"> </div></div></div>'."\n";
			}

	}
    $output .= '</div>';
    return array($output,$menu);
}
?>