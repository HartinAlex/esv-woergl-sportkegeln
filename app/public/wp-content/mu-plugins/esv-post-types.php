<?php
    function esv_post_types() {
        // Event Post Type
        register_post_type('Event', array(
            'capability_type' => 'event',
            'map_meta_cap' => true,
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
            'capability_type' => 'member',
            'map_meta_cap' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
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
            'capability_type' => 'team',
            'map_meta_cap' => true,
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
            'capability_type' => 'league',
            'map_meta_cap' => true,
            'show_in_rest' => true,
            'hierarchical' => true,
            'supports' => array('title', 'page-attributes'),
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

        // Note post type -> is to delete after change this function to custom homepage
        register_post_type('note', array(
            'capability_type' => 'note',
            'map_meta_cap' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor'),
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Notes',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note',
                'add_new' => 'Add New Note'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog'
        ));
    }
    add_action('init', 'esv_post_types');