<?php
/*
* Template Name: Show Users
*/
$users = new User();
$html = '';
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
endforeach;
echo $html;
