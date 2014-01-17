<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
// Do not delete these lines
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
  die('Please do not load this page directly. Thanks!');

if (post_password_required()) {
  ?>
  <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p>
  <?php
  return;
}
?>

<!-- You can start editing here. -->

<?php if (have_comments()) : ?>
  <div class="supertitle"><?php comments_number(__('Noch kein Kommentar'), __('Ein Kommentar'), __('% Kommentare')); ?></div>

  <ol class="commentlist">
    <?php wp_list_comments(array('avatar_size' => 80, 'callback' => 'marctv_comment')); ?>
  </ol>

  <div class="nav-article">
    <span class="nav-previous"><?php previous_comments_link() ?></span>
    <span class="nav-next"><?php next_comments_link() ?></span>
  </div>

<?php else : // this is displayed if there are no comments so far ?>

  <?php if (comments_open()) : ?>
    <!-- If comments are open, but there are no comments. -->

  <?php else : // comments are closed ?>
    <!-- If comments are closed. -->
    <p class="nocomments"><?php _e('Kommentare sind geschlossen.'); ?></p>

  <?php endif; ?>
<?php endif; ?>


<?php if (comments_open()) : ?>

  <div class="inner">
    <?php if (!is_user_logged_in()) : ?>
    <?php endif; ?>


    <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
      <p><?php printf(__('Du musst <a href="%s">angemeldet</a> sein um einen Kommentar schreiben zu können.'), wp_login_url(get_permalink())); ?></p>
    <?php else : ?>
      <?php
      $fields = array(
        'author' =>
        '<p class="comment-form-author"><label for="author">' . __('Name', 'domainreference') . '</label> ' .
        ( $req ? '<span class="required">*</span>' : '' ) .
        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
        '" size="30" /></p>',
        'author' =>
        '<p class="comment-form-author"><input type="text" name="author" id="author" value="' . esc_attr($commenter['comment_author']) . '" size="22"  required />
            <label for="author">' . __('Name', 'domainreference') . '*</label></p>',
        'email' =>
        '<p class="comment-form-email"><label for="email">' . __('Email', 'domainreference') . '</label> ' .
        ( $req ? '<span class="required">*</span><em>Unterstützt <a rel="nofollow" href="http://gravatar.com">gravatar.com für Benutzerbilder</a></em>' : '' ) .
        '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) .
        '" size="30" /></p>',
        'email' =>
        '<p class="comment-form-email"><input type="email" name="email" id="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" required />
            <label for="email">' . __('Email', 'domainreference') . '* <small><em>Unterstützt <a rel="nofollow" tabindex="-1" href="http://gravatar.com">gravatar.com für Benutzerbilder</a></em></small></label></p>',
        'url' =>
        '<p class="comment-form-url"><label for="url">' . __('Website', 'domainreference') . '</label>' .
        '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) .
        '" size="30" /></p>',
        'url' =>
        '<p class="comment-form-url"><input type="url" name="url" id="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="22" />
            <label for="url">' . __('Website', 'domainreference') . ' <small><em>(optional)</em></small></label></p>',
      );

      $comments_args = array(
        // change the title of send button 
        'fields' => $fields,
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8"></textarea></p>'
      );
      
      comment_form($comments_args);
      ?>


    <?php endif; // If registration required and not logged in   ?>
  </div>
  <?php endif; // if you delete this the sky will fall on your head    ?>
