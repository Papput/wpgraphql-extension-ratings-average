<?php
/**
 * Plugin Name: wpgraphql extension ratings average
 * Plugin URI: https://github.com
 * Version: 0.0.1
 * Author: Gunnar Abrahamsson
 * Author URI: https://github.com/papput
 * Description: Extends ratings plugin to GraphQL
 */

// require_once '../wp-postratings/wp-postratings.php';


add_action( 'graphql_register_types', 'graphql_extension_register_types' );

function graphql_extension_register_types() {

    register_graphql_field( 'recept', 'ratings_average', [
        'description' => __( 'This is just a example field' ),
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
}

?>