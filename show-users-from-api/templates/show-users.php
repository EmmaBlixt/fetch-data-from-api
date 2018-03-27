<?php
/*
* This is the template to display users
*/
$users = new User();
$epic_posts = new EpicPost();
$albums = new EpicAlbum();
$todos = new Todo();
$photos = new EpicPicture();
$html = '';
$post_count = 0;
$album_count = 0;
$todo_count = 0;
$photo_count = 0;

foreach ($users->get_user_values() as $user) :
  $html .= '<div class="displayed-person">';
  $html .= '<div class="person-info">';
  $html .= '<p><b>Name:</b><br>' . $user['name'] . '</p>';
  $html .= '<p><b>Email:</b><br>' . $user['email'] . '</p>';
  $html .= '<p><b>Address:</b><br>';
  foreach ($user['address'] as $address) :
    $html .= $address . '<br>';
  endforeach;
  $html .= '</div><div class="person-info">';
  $html .= '<p><b>Username:</b><br>' . $user['username'] . '</p>';
  $html .= '<p><b>Phone:</b><br>' . $user['phone'] . '</p>';
  $html .= '<p><b>Website:</b><br>' . $user['website'] . '</p>';
  $html .= '<p><b>Company:</b><br>';
  foreach ($user['company'] as $company) :
   $html .= $company . '<br>';
  endforeach;
  $html .= '</p></div></div>';

  foreach ($epic_posts->get_post_data() as $epic_post) :
    if ($epic_post['user_id'] === $user['id']) :
      $post_count++;
    endif;
  endforeach;
  foreach ($todos->get_todo_values() as $todo) :
    if ($todo['user_id'] === $user['id']) :
      $todo_count++;
    endif;
  endforeach;
  foreach ($albums->get_album_data() as $album) :
    if ($album['user_id'] === $user['id']) :
      $album_count++;
    endif;
  endforeach;
  foreach ($photos->get_image_data() as $photo) :
    if ($photo['album_id'] === $album_count) :
      $photo_count++;
    endif;
  endforeach;

  $html .= '<div class="made-by-user-content">';
  $html .= "<h4>Here's how " . $user['name'] . ' has contributed to the site:</h4>';
  $html .= '<div class="user-contribution">';
  $html .= '<p><b>Number of posts:</b> ' . $post_count . '</p>';
  $html .= '<p><b>Number of albums:</b>' . $album_count . '</p>';
  $html .= '</div><div class="user-contribution">';
  $html .= '<p><b>Number of todos:</b> ' . $todo_count . '</p>';
  $html .= '<p><b>Number of pictures:</b> ' . $photo_count . '</p>';
  $html .= '</div></div>';
endforeach;

echo $html;