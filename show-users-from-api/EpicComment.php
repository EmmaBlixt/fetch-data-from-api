<?php
defined('ABSPATH') or die('No script kiddies please!');

class EpicComment extends EpicPost
{
    private $postId;
    private $id;
    private $name;
    private $email;
    private $body;

    /**
    * Fetch data from the api
    * @return object $comments that contains all the comment information
    */
    private function fetch_comment_data()
    {
     try {
      $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/comments' );
      $comments = json_decode( $response['body'] );

      } catch ( Exception $ex ) {
          $comments = null;
      }
      return $comments;
    }

    /**
    * Set the post values
    * @param object $comment
    */
    private function set_comment_values($comment)
    {
      $this->postid = $comment->postId;
      $this->id     = $comment->id;
      $this->title  = $comment->title;
      $this->email  = $comment->email;
      $this->body   = $comment->body;
    }

    /**
    * Get the comment data
    * @return array $output, contains all the comment data
    */
    public function get_comment_data()
    {
      $output = '';
      $posts = new EpicPost();
      $post = $posts->get_post_data();

      if (null == ($json_response = $this->fetch_comment_data())) :
        $output = "<h1>Sorry, I couldn't find the api</h1>";
      else :
        foreach ($json_response as $comment) :
            $output[] = array(
                'postId' => $comment->postId,
                'name'   => $comment->name,
                'body'   => $comment->body,
                'email'  => $comment->email
            );
        endforeach;
      endif;
      return $output;
    }
}

$show_comments = new EpicComment();
