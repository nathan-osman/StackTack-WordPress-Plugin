<?php

/*
Plugin Name: StackTack
Plugin URI: https://github.com/nathan-osman/StackTack-WordPress-Plugin
Description: A WordPress plugin that makes it easy to embed questions from Stack Exchange sites in your blog.
Version: 1.2.1
Author: Nathan Osman
Author URI: http://quickmediasolutions.com/nathan-osman
License: GPL2
*/

/*
StackTack - A Question Widget for Your Blog
Copyright (C) 2012  Nathan Osman

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class StackTack
{
    // Adds the StackTack TinyMCE plugin
    static function add_plugin($plugin_array)
    {
        $plugin_array['stacktack'] = plugins_url('tinymce/editor_plugin.js', __FILE__);
        return $plugin_array;
    }
    
    // Adds the StackTack button to the editing toolbar
    static function register_button($buttons)
    {
        array_push($buttons, "separator", "stacktack");
        return $buttons;
    }
    
    // Registers the button in the editing toolbar
    static function add_button()
    {
        if(!current_user_can('edit_posts') &&
           !current_user_can('edit_pages') &&
           get_user_option('rich_editing') != 'true')
            return;
        
        add_filter('mce_external_plugins', array( __CLASS__, 'add_plugin'));
        add_filter('mce_buttons', array( __CLASS__, 'register_button'));
    }
    
    // Displays the options page
    static function options_page()
    {
        require 'stacktack_options.php';
    }
    
    // Adds the options page to the menu
    static function plugin_menu()
    {
        add_options_page('StackTack Options', 'StackTack', 'manage_options', 'stacktack-options', array( __CLASS__, 'options_page'));
    }
    
    // Writes the contents of the dialog to the page
    static function include_dialog()
    {
?>
<div style="display:none;">
    <form id="stacktack-dialog">
        <p class="howto">Paste a link to the question you would like to embed.</p>
        <label>
            <span>URL:</span>
            <input type="text" id="stacktack-url" autocomplete="off" />
        </label>
        <div id="stacktack-url-error" class="stacktack-option stacktack-error" style="display: none;">
          Please enter a valid URL.
        </div>
        <label>
            <span>Answers:</span>
            <select id="stacktack-answers">
                <option value="default">Use Global Default</option>
                <option value="accepted">Accepted</option>
                <option value="none">None</option>
                <option value="all">All</option>
                <option value="specific">Specific Answer</option>
            </select>
        </label>
        <div id="stacktack-answer-container" class="stacktack-option" style="display: none;"></div>
        <p class="howto">Specify the display options.</p>
        <label class="stacktack-option">
            <input type="checkbox" id="stacktack-hide-question" />
            Hide the question
        </label>
        <label class="stacktack-option">
            <input type="checkbox" id="stacktack-hide-votes" />
            Hide the vote totals
        </label>
        <div class="submitbox">
            <a href="#" id="stacktack-cancel"><?php _e( 'Cancel' ); ?></a>
            <input type="submit" value="Insert" id="stacktack-submit" class="button-primary">
        </div>
    </form>
</div>
<?php
        wp_enqueue_style('stacktack-dialog', plugins_url('css/dialog.css', __FILE__));
        wp_enqueue_script('stacktack-dialog', plugins_url('js/dialog.js', __FILE__));
    }
    
    // Outputs the HTML for the provided shortcode
    static function shortcode($atts)
    {
        extract(shortcode_atts(array('answers'      => FALSE,  // FALSE indicates we will use the global default
                                     'hidequestion' => FALSE,
                                     'site'         => 'stackoverflow',
                                     'id'           => FALSE,
                                     'hidevotes'    => FALSE),
                               $atts));
        
        // Generate the attributes for this instance
        $attr  = ($answers)?' data-answers="' . esc_attr($answers) . '"':'';
        $attr .= ($hidequestion)?' data-question="false"':'';
        $attr .= ($hidevotes)?' data-votes="false"':'';
        
        return ($id === FALSE)?'<div><b>StackTack Error:</b> Missing <code>id</code> attribute.</div>':
            "<div class='stacktack' data-site='$site' data-id='$id'$attr></div>";
    }
    
    // Enqueues the StackTack scripts and stylesheets
    static function enqueue_scripts()
    {
        // Enqueue the StackTack script
        wp_register_script('stacktack', plugins_url('js/stacktack.min.js', __FILE__), array('jquery'), false, true);
        wp_register_script('stacktack_init', plugins_url('js/stacktack.init.js', __FILE__), array('jquery', 'stacktack'), false, true);
        wp_enqueue_script('stacktack_init');
        
        // Load the parameters and pass it to the init script
        $answers = get_option('stacktack_answers', 'accepted');
        $tags    = get_option('stacktack_tags',    'true');
        $secure  = get_option('stacktack_secure',  'false');
        
        $params = array('answers' => $answers,
                        'tags'    => $tags,
                        'secure'  => $secure);
        
        wp_localize_script('stacktack_init', 'stacktack', $params);
        
        // Register and enqueue the stylesheet
        wp_register_style('stacktack', plugins_url('css/stacktack.min.css', __FILE__));
        wp_enqueue_style('stacktack');
    }
    
    // Initializes the plugin
    static function on_load()
    {
        add_action('admin_init', array( __CLASS__, 'add_button'));
        add_action('admin_menu', array( __CLASS__, 'plugin_menu'));
        add_action('admin_footer', array( __CLASS__, 'include_dialog'));
        add_shortcode('stacktack', array( __CLASS__, 'shortcode'));
        add_action('wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts'));
    }
}

StackTack::on_load();

?>