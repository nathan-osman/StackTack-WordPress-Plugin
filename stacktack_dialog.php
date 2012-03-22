<?php

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

global $pagenow;
if($pagenow == 'post-new.php' || $pagenow == 'post.php')
{

?>
<style type="text/css">
#stacktack-dialog {
    padding: 0px 10px;
}
#stacktack-dialog label span {
    display: inline-block;
    width: 40px;
}
#stacktack-dialog label input[type=text] {
    width: 380px;
}
#stacktack-dialog .submitbox {
    padding-top: 14px;
}
#stacktack-cancel {
    display: inline-block;
    padding-top: 10px;
}
#stacktack-submit {
    float: right;
}
</style>
<div style="display:none;">
    <form id="stacktack-dialog">
        <p class="howto">Paste a link to the question you would like to embed.</p>
        <label>
            <span>URL:</span>
            <input type="text" id="stacktack-url" autocomplete="off" />
        </label>
        <div class="submitbox">
            <a href="#" id="stacktack-cancel"><?php _e( 'Cancel' ); ?></a>
            <input type="submit" value="Insert" id="stacktack-submit" class="button-primary">
        </div>
    </form>
</div>
<script type="text/javascript">
(function($) {
    
    $('#stacktack-submit').click(function(e) {
        
        e.preventDefault();
        
        // Fetch the URL that the user is trying to paste and convert it into the shortcode
        var url = $('#stacktack-url').val();
        var matches = url.match(/^http:\/\/([\w\.]+)\.com\/q(?:uestions)?\/(\d+)/)
        
        // Make sure the URL is valid
        if(matches !== null) {
        
            // Insert the shortcode into the editor
            var shortcode = '[stacktack site=' + matches[1] + ' id=' + matches[2] + ']';
            tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);
            
            // Close the dialog and clear the contents
            $('#stacktack-dialog').wpdialog('close');
            $('#stacktack-url').val('');
            
        } else {
            
            // Yes, this is dumb - but the alert dialog doesn't pop
            // OVER the existing content - so we have to do this
            $('#stacktack-dialog').wpdialog('close');
            
            // Let the user know the problem
            tinymce.activeEditor.windowManager.alert('The URL you have entered is not valid.', function() {
                
                $('#stacktack-dialog').wpdialog('open');
                
            });
            
        }
    });
    
    $('#stacktack-cancel').click(function(e) {
        
        e.preventDefault();
        $('#stacktack-dialog').wpdialog('close');
        $('#stacktack-url').val('');
        
    });
    
})(jQuery);
</script>
<?php

}

?>