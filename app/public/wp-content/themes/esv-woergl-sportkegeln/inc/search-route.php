<?php
    function customRegisterSearch() {
        register_rest_route('club/v1', 'search', array(
            'methods' => WP_REST_Server::READABLE, // => the same as 'GET', to make sure that it works on every browser
            'callback' => 'customSearchResults'
        ));
    }
    add_action('rest_api_init', 'customRegisterSearch');

    function customSearchResults($data) {
        $mainQuery = new WP_Query(array(
            'post_type' => array('post', 'page', 'member', 'event', 'league', 'team'),
            's' => sanitize_text_field($data['term']) // s -> stands for search
        ));

        $searchResults = array(
            'generalInfo' => array(),
            'memberInfo' => array(),
            'leagueInfo' => array(),
            'teamInfo' => array(),
            'eventInfos' => array()
        );

        while($mainQuery->have_posts()) {
            $mainQuery->the_post();

            if (get_post_type() == 'post' or get_post_type() == 'page') {
                array_push($searchResults['generalInfo'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'postAuthor' => get_the_author(),
                    'postType' => get_post_type(),
                    'id' => get_the_ID()
                ));
            }

            if (get_post_type() == 'member') {
                array_push($searchResults['memberInfo'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'portrait' => get_the_post_thumbnail_url(0, 'memberLandscape'),
                    'id' => get_the_ID()
                ));
            }

            if (get_post_type() == 'league') {
                array_push($searchResults['leagueInfo'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'id' => get_the_ID()
                ));
            }

            if (get_post_type() == 'team') {
                $relatedLeagues = get_field('related_league');

                if ($relatedLeagues) {
                    foreach($relatedLeagues as $league) {
                        array_push($searchResults['leagueInfo'], array(
                            'title' => get_the_title($league),
                            'url' => get_the_permalink($league)
                        ));
                    }
                }

                array_push($searchResults['teamInfo'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'id' => get_the_ID()
                ));
            }

            if (get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                $description = null;
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 18);
                }

                array_push($searchResults['eventInfos'], array(
                    'title' => get_the_title(),
                    'url' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description,
                    'id' => get_the_ID()
                ));
            }
            
        }

        if ($searchResults['teamInfo']) {
            $memberMetaQuery = array('relation' => 'OR');

            foreach($searchResults['teamInfo'] as $item) {
                array_push($memberMetaQuery, array(
                    'key' => 'related_team',
                    'compare' => 'LIKE',
                    'value' => '"' . $item['id'] . '"'
                ));
            }

            $memberRelationshipQuery = new WP_Query(array(
                'post_type' => array('member', 'event', 'league'),
                'meta_query' => $memberMetaQuery
            ));

            while($memberRelationshipQuery->have_posts()) {
                $memberRelationshipQuery->the_post();

                if (get_post_type() == 'member') {
                    array_push($searchResults['memberInfo'], array(
                        'title' => get_the_title(),
                        'url' => get_the_permalink(),
                        'portrait' => get_the_post_thumbnail_url(0, 'memberLandscape')
                    ));
                }

                if (get_post_type() == 'event') {
                    $eventDate = new DateTime(get_field('event_date'));
                    $description = null;
                    if (has_excerpt()) {
                        $description = get_the_excerpt();
                    } else {
                        $description = wp_trim_words(get_the_content(), 18);
                    }

                    array_push($searchResults['eventInfos'], array(
                        'title' => get_the_title(),
                        'url' => get_the_permalink(),
                        'month' => $eventDate->format('M'),
                        'day' => $eventDate->format('d'),
                        'description' => $description,
                        'id' => get_the_ID()
                    ));
                }
            }

            $searchResults['memberInfo'] = array_values(array_unique($searchResults['memberInfo'], SORT_REGULAR));
            $searchResults['eventInfos'] = array_values(array_unique($searchResults['eventInfos'], SORT_REGULAR));
        }

        return $searchResults;
    }