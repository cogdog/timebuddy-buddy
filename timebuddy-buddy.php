<?php
/*
* Plugin Name: Time Buddy Buddy
* Description: Shortcode and editor button for adding World Time Buddy Event Widgets
* Version: 0.3
* Author: @cogdog
* Author URI: https://cog.dog

*/


/* ----- shortcode to time buddy widget -------- */
add_shortcode("timebuddy", "do_vc_timebuddy");  

function do_vc_timebuddy ( $atts ) {  

	// generate a Timebuddy widget because WP strips script tags
 	extract( shortcode_atts( array( "params" => ""), $atts ) );  
 	
 	if ( empty( $params ) ) {
 		return "<p><strong>Missing parameter for Timebuddy widget!</strong> -- set <code>params=\"xxxxx\"</code> from the Timebuddy generated embed code for <code>src=\"</code> e.g. <code>params=\"h=2643743&md=2/24/2023&mt=19.50&ml=1.00&sts=0&sln=0&wt=ew -ltc\"</code> after the \"?\"</p>";
 		
 	} elseif ( substr($params,0,2) !='h=' or strpos($params, 'md') ===false) {	
 	return "<p><strong>Malformed parameter! for Timebuddy widget!</strong> <code>params=" . $params . "</code> is not correct. check <code>params=\"xxxxx\"</code>  from the Timebuddy generated embed code for <code>src=\"</code> e.g. <code>params=\"h=2643743&md=4/27/2020&mt=19.50&ml=1.00&sts=0&sln=0&wt=ew -ltc\"</code> after the \"?\"</p>";
 		
 	} else {
 	
 		// if code entered does now have code for countdown clock, add one
 		if ( substr( $params, -1 ) != 'c' ) $params .= 'c';
 
 		return '<div style="text-align:center"><span class="wtb-ew-v1" style="width: 560px; display:inline-block"><script src="https://www.worldtimebuddy.com/event_widget.js?' . $params . '"></script><i><a target="_blank" href="https://www.worldtimebuddy.com/">Time converter</a> at worldtimebuddy.com</i><noscript><a href="https://www.worldtimebuddy.com/">Time converter</a> at worldtimebuddy.com</noscript><script>window[wtb_event_widgets.pop()].init()</script></span></div>';
	
	}

}

/* ----- editor buttons for time buddy widget -------- */

add_action('admin_head', 'timebuddy_buttons');

function timebuddy_buttons() {
		// check user permissions
		if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
				   return;
		}
        
        // check if WYSIWYG is enabled
	   if ( 'true' == get_user_option( 'rich_editing' ) ) {
    		add_filter( "mce_external_plugins", "timebuddy_add_buttons" );
    		add_filter( 'mce_buttons', 'timebuddy_register_buttons' );
		}
}


function timebuddy_add_buttons( $plugin_array ) {
    $plugin_array['timebuddy'] = plugin_dir_url( __FILE__ ) . 'timebuddy_widget.js';
    return $plugin_array;
}
function timebuddy_register_buttons( $buttons ) {
    array_push( $buttons, 'timebuddy'); 
    return $buttons;
}

?>