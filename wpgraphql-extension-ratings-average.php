<?php
/**
 * Plugin Name: wpgraphql extension ratings average
 * Plugin URI: https://github.com/Papput/wpgraphql-extension-ratings-average
 * Version: 0.0.1
 * Author: Gunnar Abrahamsson
 * Author URI: https://github.com/papput
 * Description: Extends ratings plugin to GraphQL
 */

// require_once '../wp-postratings/wp-postratings.php';


/**
 * Rating logs table name
 */
global $wpdb;
$wpdb->ratings = $wpdb->prefix . 'ratings';

// Get avrage ratings
add_action( 'graphql_register_types', 'graphql_extension_register_types' );

function graphql_extension_register_types() {

    register_graphql_field( 'recept', 'ratings_average', [
        'description' => __( 'avrage recept rating' ),
        'type' => 'int',
        'resolve' => function( $root, $args, $context, $info ) {
            // graphql_debug(['root' => $root, 'context' => $context, 'info' => $info]);
            //graphql_debug(['root' => $root -> databaseId]);
            // return get_post_meta($root -> databaseId, 'ratings_average');
            
            $avrage = get_post_meta($root -> databaseId, 'ratings_average', true);
            
            if($avrage == "") return null;
            return  (int) $avrage;
        }
        ] );
        register_graphql_field( 'recept', 'ratings_amount', [
            'description' => __( 'Total amount of ratings' ),
            'type' => 'int',
            'resolve' => function( $root, $args, $context, $info ) {
                // graphql_debug(['root' => $root, 'context' => $context, 'info' => $info]);
                //graphql_debug(['root' => $root -> databaseId]);
                // return get_post_meta($root -> databaseId, 'ratings_average');
                global $wpdb;
                $post_id = $root -> databaseId;

                $get_rated_amount = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->ratings} WHERE rating_postid = %d", $post_id) );
                return  (int) $get_rated_amount;
        }
    ] );
}

?>