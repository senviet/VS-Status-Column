<?php

/*
Plugin Name: VS Status Column
Plugin URI: http://laptrinh.senviet.org
Description: Add status custom column for post
Version: 1.0
Author: nguyenvanduocit
Author URI: http://nvduoc.senviet.org
License: A "Slug" license name e.g. GPL2
*/

add_filter('manage_posts_columns' , 'sv_add_status_columns');
function sv_add_status_columns($columns) {
	$cb = $columns['cb'];
	unset($columns['cb']);
	$columns = array_merge(array('cb'=>$cb, 'status'=>'<span class="status_head tips" data-tip="' . esc_attr__( 'Status' ) . '">' . esc_attr__( 'Status' ) . '</span>'), $columns);
	return $columns;
}

add_action('manage_posts_custom_column', 'sv_render_status_column', 10, 2);
function sv_render_status_column($column_name, $post_id ){
	global $post;
	if($column_name === 'status'){
		$currentPostStatus = $post->post_status;
		$statusObject = get_post_status_object($currentPostStatus);
		if($statusObject != null){
			printf( '<mark class="%1$s tips" data-tip="%2$s">%3$s</mark>', $statusObject->name, $statusObject->label, $statusObject->label ) ;
		}
		else{
			printf( '<mark class="$1%s tips" data-tip="$1%s">$1%s</mark>', $currentPostStatus) ;
		}
	}
}

add_action( 'admin_enqueue_scripts', 'sv_admin_styles' );
function sv_admin_styles(){
	$screen = get_current_screen();
	if ( $screen->id =='edit-post' ) {
		wp_enqueue_style( 'sv_admin_styles', plugins_url('admin.css', __FILE__));
		wp_enqueue_script('jquery-tiptip', plugins_url('js/jquery.tipTip.js', __FILE__), array('jquery'));
		wp_enqueue_script('main-script', plugins_url('js/main.js', __FILE__), array('jquery-tiptip'));
	}
}