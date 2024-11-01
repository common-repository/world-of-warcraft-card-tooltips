<?php
/*
Plugin Name: World of Warcraft TCG Card Tooltips
Plugin URI: http://deckbox.org/help/tooltips
Description: Easily transform World of Warcraft card names into links that show the card
  information in a tooltip when hovering over them.
Author: Sebastian Zaha
Version: 1.0.1
Author URI: http://deckbox.org/help/tooltips
*/


function deckbox_wow_register_button($buttons) {
    array_push($buttons, "separator", "deckbox_wow");
    return $buttons;
}

function deckbox_wow_add_tinymce_plugin($plugin_array) {
    $plugin_array['deckbox_wow'] = get_bloginfo('wpurl') .
        '/wp-content/plugins/world-of-warcraft-card-tooltips/resources/tinymce3/editor_plugin.js';
    return $plugin_array;
}

function deckbox_wow_add_buttons() {
    wp_enqueue_script('deckbox', 'http://deckbox.org/javascripts/bin/tooltip.js');

    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
 
    // Add only in Rich Editor mode
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "deckbox_wow_add_tinymce_plugin");
        add_filter('mce_buttons', 'deckbox_wow_register_button');
    }
}

add_action('init', 'deckbox_wow_add_buttons');
