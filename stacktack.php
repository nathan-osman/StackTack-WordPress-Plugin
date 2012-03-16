<?php

/*
Plugin Name: StackTack
Plugin URI: https://github.com/nathan-osman/StackTack-WordPress-Plugin
Description: A WordPress plugin that makes it easy to embed questions from Stack Exchange sites in your blog.
Version: 1.0
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

function stacktack_addbutton()
{
    if(!current_user_can('edit_posts') &&
       !current_user_can('edit_pages') &&
       get_user_option('rich_editing') != 'true')
        return;
    
    add_filter('mce_external_plugins', 'stacktack_addplugin');
    add_filter('mce_buttons', 'stacktack_registerbutton');
}

function stacktack_addplugin($plugin_array)
{
    $plugin_array['stacktack'] = plugins_url('tinymce/editor_plugin.js', __FILE__);
    return $plugin_array;
}

function stacktack_registerbutton($buttons)
{
    array_push($buttons, "separator", "stacktack");
    return $buttons;
}

add_action('init', 'stacktack_addbutton');

?>