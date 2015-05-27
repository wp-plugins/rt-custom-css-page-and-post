<?php
/*
Plugin Name: Royal Custom CSS for Page and Post
Plugin URI: http://wordpress.org/plugins/rt-custom-css/
Description: Royal Custom CSS for every Page and Post
Author: SM Mehdi Akram
Version: 1.1
Author URI: http://www.shamokaldarpon.com/
*/


//Custom CSS option panel
add_action('admin_menu', 'rt_custom_css_hooks');
add_action('save_post', 'rt_save_custom_css');
add_action('wp_head','rt_insert_custom_css');
function rt_custom_css_hooks() {
	add_meta_box('custom_css', 'Royal Custom CSS', 'custom_css_input', 'post', 'normal', 'high');
	add_meta_box('custom_css', 'Royal Custom CSS', 'custom_css_input', 'page', 'normal', 'high');
}
function custom_css_input() {
	global $post;
	echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename" value="'.wp_create_nonce('custom-css').'" />';
	echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'rt_custom_css',true).'</textarea>';
}
function rt_save_custom_css($post_id) {
	if (!wp_verify_nonce($_POST['custom_css_noncename'], 'custom-css')) return $post_id;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$custom_css = $_POST['custom_css'];
	update_post_meta($post_id, 'rt_custom_css', $custom_css);
}
function rt_insert_custom_css() {
	if (is_page() || is_single()) {
		if (have_posts()) : while (have_posts()) : the_post();
			echo '<style type="text/css" media="screen">'.get_post_meta(get_the_ID(), 'rt_custom_css', true).'</style>';
		endwhile; endif;
		rewind_posts();
	}
}



?>