<?php
/*
* This is the template to display users
*/
$html = '';
$todos = new Todo();
  foreach ($todos->get_todo_values() as $todo) :
    $html .= '<div class="displayed-todo">';
    $html .= '<p><b>Title:</b> ' . $todo['title'] . '</p>';
    $html .= '<p><b>Status:</b> ' . $todo['status'] . '</p>';
    $html .= '<p><b>Person in charge of this task:</b> ' . $todo['user_name'] . '</p>';
    $html .= '</div>';
  endforeach;
echo $html;
