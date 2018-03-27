<?php
defined('ABSPATH') or die('No script kiddies please!');

class Todo extends User
{
  private $id;
  private $user_id;
  private $completed;
  private $title;
  private $user_name;

  function __construct()
  {
    return $this->init();
  }

  /**
  * Initialize the class & add WP hooks
  */
  public function init()
  {
    add_shortcode('display-todos', array($this, 'display_todos'));
  }

 /**
 *  Fetch data from the api
 *  @return object $todo that contains all the todo:s
 */
 public function fetch_todo_data()
 {
  try {
    $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/todos' );
    $todo = json_decode($response['body']);

   } catch ( Exception $ex ) {
       $todo = null;
   }
   return $todo;
 }

 /**
 *  Get the Todo's status
 *  @param obejct $todo
 *  @return string $status contains the Todo's status
 */
 private function get_todo_status($todo)
 {
  if ($todo->completed == true) :
    $status = '<span class="completed-todo">Completed</span>';
  else:
    $status = '<span class="uncompleted-todo">Uncompleted</span>';
  endif;
  return $status;
 }

  /**
  * Get data variables for User objects
  * @return array $output that contains all the todo information
  */
  public function get_todo_values()
  {
    $output = '';
    if (null == ($json_response = $this->fetch_todo_data())) :
      $output = "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $todo) :
          $output[] = array(
              'id'        =>  $todo->id,
              'title'     =>  $todo->title,
              'user_id'   =>  $todo->userId,
              'status'    =>  $this->get_todo_status($todo),
          );
      endforeach;
    endif;
    return $output;
  }

 /**
 *  Set all the Todo values
 *  @param object $todo
 */
 private function set_todo_values($todo)
 {
  $this->id         = $todo->id;
  $this->user_id    = $todo->userId;
  $this->title      = $todo->title;
  $this->completed  = $todo->completed;
 }

 /**
 *  Fetch template to display all the data
 */
 public function display_todos()
 {
   display_template('show-todos.php');
 }
}

$show_todos = new Todo();
