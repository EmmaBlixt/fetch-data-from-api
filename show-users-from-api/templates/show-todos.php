<?php
/*
* This is the template to display todos
*/
$html = '';
$todos = new Todo();
$users = new User();
$username = '';

foreach ($users->get_user_values() as $user) :
  foreach ($todos->get_todo_values() as $todo) :
    $html .= '<div class="displayed-todo">';
    $html .= '<p><b>Title:</b> ' . ucfirst($todo['title']). '</p>';
    $html .= '<p><b>Status:</b> ' . $todo['status'] . '</p>';
      if ($user['id'] === $todo['user_id']) :
         $username = $user['name'];
      endif;
    $html .= '<p><b>Person in charge of this task:</b> ' . $username . '</p>';
    $html .= '</div>';
  endforeach;
endforeach;
echo $html;
