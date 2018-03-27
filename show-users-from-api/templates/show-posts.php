<?php
/*
* This is the template to display posts & their comments
*/

$epic_comments = new EpicComment();
$epic_posts = new EpicPost();
$users = new User();
$html = '';
$post_count = 0;
$i = 0;

foreach ($epic_posts->get_post_data() as $epic_post) :
  foreach ($users->get_user_values() as $user) :
    if ($user['id'] === $epic_post['user_id']) :
       $username = $user['name'];
    endif;
  endforeach;
  $post_count++;
  $html .= '<div class="epic-post-container">';
  $html .= '<h4 class="epic-post-title">' . ucfirst($epic_post['title']) . '</h4>';
  $html .= '<p><b>Written by:</b> ' . $username . '</p>';
  $html .= '<p>' . ucfirst($epic_post['content']) . '</p>';
  $html .= '</div>';
  $html .= '<div class="epic-comment-container">';
  $html .= 'Comments: ' . count($epic_comments->get_comment_data()) . '</p>';
  foreach ($epic_comments->get_comment_data() as $epic_comment) :
    if ($epic_comment['postId'] === $post_count) :
      $i++;
      $html .= '<div class="epic-comment-content">';
      $html .= '<p class="epic-comment-email">' . ucfirst($epic_comment['email']) . '</p>';
      $html .= '<p class="epic-post-title">' . ucfirst($epic_comment['name']) . '</p>';
      $html .= '<p>' . ucfirst($epic_comment['body']) . '</p>';
      $html .= '</div>';
      if($i == 3) :
        $html .= '</div>';
        $i = 0;
        break;
      endif;
    endif;
  endforeach;
  if($post_count == 10) :
    $html .= '</div>';
    break;
  endif;
endforeach;

echo $html;
