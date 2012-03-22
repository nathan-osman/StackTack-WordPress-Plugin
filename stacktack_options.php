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

if(!current_user_can('manage_options'))
        wp_die(__('You do not have sufficient permissions to access this page.'));

?>
<div class="wrap">
  <img src="<?php echo plugins_url('img/icon.png', __FILE__); ?>" class="icon32" />
  <h2>StackTack Options</h2>
<?php

// Check to see if the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Process the options
    $answers = isset($_POST['answers'])?$_POST['answers']:'accepted';
    $tags    = isset($_POST['tags'])?'true':'false';
    $secure  = isset($_POST['secure'])?'true':'false';
    
    // Apply the settings
    update_option('stacktack_answers', $answers);
    update_option('stacktack_tags',    $tags);
    update_option('stacktack_secure',  $secure);
?>
<div class="updated">
  <p><b>Your settings have been updated.</b></p>
</div>
<?php
}
else
{
    // Load the current values for the settings
    $answers = get_option('stacktack_answers', 'accepted');
    $tags    = get_option('stacktack_tags',    'true');
    $secure  = get_option('stacktack_secure',  'false');
}

?>
  <form method="post">
    <table class="form-table">
      <tr valign="top">
        <th>Answer Display</th>
        <td>
          <label>
            <input type="radio" name="answers" value="none" <?php if($answers == 'none') echo 'checked="checked"'; ?> />
            <span>Don't display any answers</span>
          </label>
          <br />
          <label>
            <input type="radio" name="answers" value="all" <?php if($answers == 'all') echo 'checked="checked"'; ?> />
            <span>Display all answers</span>
          </label>
          <br />
          <label>
            <input type="radio" name="answers" value="accepted" <?php if($answers == 'accepted') echo 'checked="checked"'; ?> />
            <span>Display only accepted answers</span>
          </label>
        </td>
      </tr>
      <tr valign="top">
        <th>Tags</th>
        <td>
          <label>
            <input type="checkbox" name="tags" <?php if($tags == 'true') echo 'checked="checked"'; ?> />
            <span>Display tags underneath each question</span>
          </label>
        </td>
      </tr>
      <tr valign="top">
        <th>Security</th>
        <td>
          <label>
            <input type="checkbox" name="secure" <?php if($secure == 'true') echo 'checked="checked"'; ?> />
            <span>Use HTTPS for requests to the API</span>
          </label>
        </td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" class="button-primary" value="Save Changes" name="submit">
    </p>
  </form>
</div>