<?php
/**
 * Defines custom post types for the theme.
 *
 * @package Land Talk Custom Theme
 */

/**
 * Removes unused post type menu options.
 */
function landtalk_remove_unused_menu_options() {

	remove_menu_page( 'edit.php' ); // removes Posts.
	remove_menu_page( 'edit-comments.php' ); // removes Comments.

}

add_action( 'admin_menu', 'landtalk_remove_unused_menu_options' );


/**
 * Registers Conversation custom post type.
 */
function landtalk_register_conversation_post_type() {

	register_post_type(
		CONVERSATION_POST_TYPE,
		array(
			'labels'       => array(
				'name'                  => 'Conversations',
				'singular_name'         => 'Conversation',
				'add_new_item'          => 'Add New Conversation',
				'edit_item'             => 'Edit Conversation',
				'new_item'              => 'New Conversation',
				'view_item'             => 'View Conversation',
				'view_items'            => 'View Conversations',
				'search_items'          => 'Search Conversations',
				'not_found'             => 'No Conversations Found',
				'not_found_in_trash'    => 'No Conversations found in Trash',
				'all_items'             => 'All Conversations',
				'archives'              => 'Conversation Archives',
				'attributes'            => 'Conversation Attributes',
				'insert_into_item'      => 'Insert into Conversation',
				'uploaded_to_this_item' => 'Uploaded to this Conversation',
			),
			'menu_icon'    => 'dashicons-admin-site',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'conversations' ),
			'show_in_rest' => true,
			'rest_base'    => 'conversations',
			'supports'     => array( 'title' ),
			'taxonomies'   => array( KEYWORDS_TAXONOMY, 'category' ),
		)
	);

}

add_action( 'init', 'landtalk_register_conversation_post_type' );


/**
 * Registers Report custom post type.
 */
function landtalk_register_report_post_type() {

	register_post_type(
		REPORT_POST_TYPE,
		array(
			'labels'       => array(
				'name'                  => 'Reports',
				'singular_name'         => 'Report',
				'add_new_item'          => 'Add New Report',
				'edit_item'             => 'Edit Report',
				'new_item'              => 'New Report',
				'view_item'             => 'View Report',
				'view_items'            => 'View Reports',
				'search_items'          => 'Search Reports',
				'not_found'             => 'No Reports Found',
				'not_found_in_trash'    => 'No Reports found in Trash',
				'all_items'             => 'All Reports',
				'archives'              => 'Report Archives',
				'attributes'            => 'Report Attributes',
				'insert_into_item'      => 'Insert into Report',
				'uploaded_to_this_item' => 'Uploaded to this Report',
			),
			'menu_icon'    => 'dashicons-thumbs-down',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'reports' ),
			'show_in_rest' => true,
			'rest_base'    => 'reports',
			'supports'     => array( 'title' ),
		)
	);

}

add_action( 'init', 'landtalk_register_report_post_type' );


/**
 * Registers Contact Message custom post type.
 */
function landtalk_register_contact_message_post_type() {

	register_post_type(
		CONTACT_MESSAGE_POST_TYPE,
		array(
			'labels'    => array(
				'name'                  => 'Messages',
				'singular_name'         => 'Message',
				'add_new_item'          => 'Add New Message',
				'edit_item'             => 'Edit Message',
				'new_item'              => 'New Message',
				'view_item'             => 'View Message',
				'view_items'            => 'View Messages',
				'search_items'          => 'Search Messages',
				'not_found'             => 'No Messages Found',
				'not_found_in_trash'    => 'No Messages found in Trash',
				'all_items'             => 'All Messages',
				'archives'              => 'Message Archives',
				'attributes'            => 'Message Attributes',
				'insert_into_item'      => 'Insert into Message',
				'uploaded_to_this_item' => 'Uploaded to this Message',
			),
			'menu_icon' => 'dashicons-email',
			'public'    => true,
			'rewrite'   => array( 'slug' => 'message' ),
			'supports'  => array( 'title' ),
		)
	);

}

add_action( 'init', 'landtalk_register_contact_message_post_type' );


/**
 * Registers Lesson custom post type.
 */
function landtalk_register_lesson_post_type() {

	register_post_type(
		LESSON_POST_TYPE,
		array(
			'labels'       => array(
				'name'                  => 'Lessons',
				'singular_name'         => 'Lesson',
				'add_new_item'          => 'Add New Lesson',
				'edit_item'             => 'Edit Lesson',
				'new_item'              => 'New Lesson',
				'view_item'             => 'View Lesson',
				'view_items'            => 'View Lessons',
				'search_items'          => 'Search Lessons',
				'not_found'             => 'No Lessons Found',
				'not_found_in_trash'    => 'No Lessons found in Trash',
				'all_items'             => 'All Lessons',
				'archives'              => 'Lesson Archives',
				'attributes'            => 'Lesson Attributes',
				'insert_into_item'      => 'Insert into Lesson',
				'uploaded_to_this_item' => 'Uploaded to this Lesson',
			),
			'menu_icon'    => 'dashicons-book-alt',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'lessons' ),
			'show_in_rest' => true,
			'rest_base'    => 'lessons',
			'supports'     => array( 'title' ),
		)
	);

}

add_action( 'init', 'landtalk_register_lesson_post_type' );

/**
 * Registers Reflection custom post type.
 */
function landtalk_register_reflection_post_type() {

	register_post_type(
		REFLECTION_POST_TYPE,
		array(
			'labels'       => array(
				'name'                  => 'Reflections',
				'singular_name'         => 'Reflection',
				'add_new_item'          => 'Add New Reflection',
				'edit_item'             => 'Edit Reflection',
				'new_item'              => 'New Reflection',
				'view_item'             => 'View Reflection',
				'view_items'            => 'View Reflections',
				'search_items'          => 'Search Reflections',
				'not_found'             => 'No Reflections Found',
				'not_found_in_trash'    => 'No Reflections found in Trash',
				'all_items'             => 'All Reflections',
				'archives'              => 'Reflection Archives',
				'attributes'            => 'Reflection Attributes',
				'insert_into_item'      => 'Insert into Reflection',
				'uploaded_to_this_item' => 'Uploaded to this Reflection',
			),
			'menu_icon'    => 'dashicons-format-aside',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'reflections' ),
			'show_in_rest' => true,
			'rest_base'    => 'reflections',
			'supports'     => array( 'title' ),
			'taxonomies'   => array( REFLECTION_CATEGORY_TAXONOMY ),
		)
	);

}

add_action( 'init', 'landtalk_register_reflection_post_type' );
