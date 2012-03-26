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

(function() {
    
    // Create the plugin
    tinymce.create('tinymce.plugins.StackTack', {
        
        // Called to initialize the plugin
        init: function(editor, url) {
            
            // Register the mceStackTack command
            editor.addCommand('mceStackTack', function() {
                
                // Open the editor window
                editor.windowManager.open({
                    id: 'stacktack-dialog',
                    title:  'Insert StackTack Widget',
                    width:  460,
                    height: 'auto',
                    wpDialog: true
                }, {
                    plugin_url: url
                });
                
            });
            
            // Register the StackTack button in the editor
            editor.addButton('stacktack', {
                title: 'Insert StackTack Widget',
                cmd:   'mceStackTack',
                image: url + '/button.png'
            });
        },
        
        // Returns information about the plugin
        getInfo: function() {
            
            return {
                longname:  'StackTack Widget',
                author:    'Nathan Osman',
                authorurl: 'http://quickmediasolutions.com/nathan-osman',
                infourl:   'https://github.com/nathan-osman/StackTack-WordPress-Plugin',
                version:   '1.0'
            };
        }
    });
    
    // Register the plugin
    tinymce.PluginManager.add('stacktack', tinymce.plugins.StackTack);
    
})();