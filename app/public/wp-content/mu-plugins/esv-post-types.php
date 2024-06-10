<?php
    function esv_post_types() {
        // Event Post Type
        register_post_type('Event', array(
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'rewrite' => array('slug' => 'events'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
                'singular_name' => 'Event',
                'add_new' => 'Add New Event'
            ),
            'menu_icon' => 'dashicons-calendar'
        ));

        // Spieler Post Type
        register_post_type('Member', array(
            'show_in_rest' => true,
            'supports' => array('title'),
            'rewrite' => array('slug' => 'members'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'Member',
                'add_new_item' => 'Add New Member',
                'edit_item' => 'Edit Member',
                'all_items' => 'All Members',
                'singular_name' => 'Member',
                'add_new' => 'Add New Member'
            ),
            'menu_icon' => 'dashicons-admin-users'
        ));

        // Mannschaft Post Type
        register_post_type('Team', array(
            'show_in_rest' => true,
            'supports' => array('title'),
            'rewrite' => array('slug' => 'teams'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'Team',
                'add_new_item' => 'Add New Team',
                'edit_item' => 'Edit Team',
                'all_items' => 'All Teams',
                'singular_name' => 'Team',
                'add_new' => 'Add New Team'
            ),
            'menu_icon' => 'dashicons-groups'
        ));

        // Liga Post Type
        register_post_type('League', array(
            'show_in_rest' => true,
            'supports' => array('title'),
            'rewrite' => array('slug' => 'leagues'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'League',
                'add_new_item' => 'Add New League',
                'edit_item' => 'Edit League',
                'all_items' => 'All Leagues',
                'singular_name' => 'League',
                'add_new' => 'Add New League'
            ),
            'menu_icon' => 'dashicons-editor-table'
        ));
    }
    add_action('init', 'esv_post_types');