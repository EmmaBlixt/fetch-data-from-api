<?php
defined('ABSPATH') or die('No script kiddies please!');
include_once 'epiccomment.php';

class EpicPost extends User
{
  private $user_id;
  private $id;
  private $title;
  private $content;

  function __construct()
  {
    return $this->init();
  }

  /**
  * Initialize the class & add WP hooks
  */
  public function init()
  {
    add_shortcode('display-posts', array($this, 'show_posts'));
  }

  /**
  * Fetch data from the api
  * @return object $posts that contains all the post information
  */
  private function fetch_post_data()
  {
   try {
    $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/posts' );
    $posts = json_decode( $response['body'] );

    } catch ( Exception $ex ) {
        $posts = null;
    }
    return $posts;
  }

  /**
  * Get the username of the post's creator
  * @param object $user, object $post
  * @return string $output, contains the username
  */
  private function get_post_username($user, $post)
  {
    $output = '';
    foreach ($user as $person) {
      if ($person['id'] === $post->userId) {
         $output = $person['name'];
      }
    }
    return $output;
  }

  /**
  * Set the post values
  * @param object $post
  */
  private function set_post_values($post)
  {
    $this->user_id  = $post->userId;
    $this->id       = $post->id;
    $this->title    = $post->title;
    $this->content  = $post->body;
  }

  /**
  * Get the post data
  * @return array $output, contains all the post data
  */
  public function get_post_data()
  {
    $output = '';
    $users = new User();
    $user = $users->get_user_values();

    if (null == ($json_response = $this->fetch_post_data())) :
      $output = "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $post) :
          $output[] = array(
              'id'        =>  $post->id,
              'title'     =>  $post->title,
              'content'   =>  $post->body,
              'user_id'   =>  $post->userId,
              'username' => $this->get_post_username($user, $post)
          );
      endforeach;
    endif;
    return $output;
  }

  /**
  * Fetch the template that displays all the user data
  */
  public function show_posts()
  {
   display_template('show-posts.php');
  }
}

$show_posts = new EpicPost();
