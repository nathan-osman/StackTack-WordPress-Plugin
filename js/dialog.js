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

(function($) {
    
    // The RegEx that determines whether a question link is valid
    var question_regex = /^http:\/\/([\w\.]+)\.com\/q(?:uestions)?\/(\d+)/;
    
    // Loads the answers for the specified question
    function LoadAnswers(site, id) {
        
        $.ajax({ 'url': 'http://api.stackexchange.com/2.0/questions/' + id + '/answers',
                 'data': {
                     'filter': '!-)dQB3E8g_ab',
                     'key':    'CRspH1WAlZKCeCinkGOLHw((',
                     'site':   site,
                     'sort':   'votes'
                 },
                 'dataType': 'jsonp',
                 'success': function(data) {
                     
                     if(typeof data['error_message'] != 'undefined') {
                         
                         $('#stacktack-answer-container').html('<div class="stacktack-error">Error: ' + data['error_message'] + '</div>');
                         $('#stacktack-answers').val('default');
                         return;
                         
                     }
                     
                     if(!data['items'].length) {
                         
                         $('#stacktack-answer-container').html('<div class="stacktack-error">There are no answers for this question.</div>');
                         $('#stacktack-answers').val('default');
                         return;
                         
                     }
                     
                     var html = '<select id="stacktack-answers-id">';
                     $.each(data['items'], function(key, answer) {
                         
                         // Grab the first little bit of the answer and add it to the user's name
                         var answer_snippet = answer['body'].replace(/<.*?>/g, '').substr(0, 30);
                         html += '<option value="' + answer['answer_id'] + '">' + answer['owner']['display_name'] + ' (' +
                                 answer['score'] + ')' + ' - ' + answer_snippet + '...</option>';
                         
                     })
                     html += '</select>';
                     
                     // Display the answers for the user to select from
                     $('#stacktack-answer-container').html(html);
                 
                 }
        });
    }
    
    // Bind to the change event handler for the answer box
    $('#stacktack-answers').change(function() {
        
        if($('#stacktack-answers').val() == 'specific') {
            
            // Make sure we have a valid question URL
            var matches = $('#stacktack-url').val().match(question_regex);
            if(matches === null) {
                
                // Tell the user it's invalid and set it back to default
                $('#stacktack-url-error').show();
                $('#stacktack-answers').val('default');
                return;
                
            }
            
            // Let the user know that we're loading the answers
            $('#stacktack-answer-container').html('<span class="howto"><i>Please wait...</i></span>');
            $('#stacktack-answer-container').show();
            
            // Now load the answers
            LoadAnswers(matches[1], matches[2]);
            
        }
        else
            $('#stacktack-answer-container').hide();
        
        // Hide the error message
        $('#stacktack-url-error').hide();
        
    });
    
    // Bind to the click event for the submit button
    $('#stacktack-submit').click(function(e) {
        
        e.preventDefault();
        
        // Fetch the URL that the user is trying to paste and convert it into the shortcode
        var matches = $('#stacktack-url').val().match(question_regex);
        
        // Make sure the URL is valid
        if(matches === null) {
            
            $('#stacktack-url-error').show();
            return;
            
        }
        
        // Generate the shortcode to insert
        var answers = $('#stacktack-answers').val();
        var shortcode = '[stacktack site=' + matches[1] + ' id=' + matches[2];
        if(answers != 'default') {
            
            if(answers != 'specific')
                shortcode += ' answers=' + answers;
            else
                shortcode += ' answers=' + $('#stacktack-answers-id').val();
            
        }
        if($('#stacktack-hide-question')[0].checked) shortcode += ' hidequestion=true';
        if($('#stacktack-hide-votes')[0].checked) shortcode += ' hidevotes=true';
        shortcode += ']';
        
        // Insert the content into the editor
        tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);
        
        // Clear and close the dialog
        $('#stacktack-url').val('');
        $('#stacktack-answers').val('default');
        $('#stacktack-hide-question')[0].checked = false;
        $('#stacktack-hide-votes')[0].checked = false;
        $('#stacktack-dialog').wpdialog('close');
        
    });
    
    // Also bind to the cancel link/button
    $('#stacktack-cancel').click(function(e) {
        
        e.preventDefault();
        $('#stacktack-dialog').wpdialog('close');
        
    });
    
})(jQuery);