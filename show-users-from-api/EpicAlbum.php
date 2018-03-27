<?php
defined('ABSPATH') or die('No script kiddies please!');

class EpicAlbum extends User
{
  private $user_id;
  private $id;
  private $title;

  /**
  * Fetch data from the api
  * @return object $albums that contains all the album information
  */
  private function fetch_album_data()
  {
    try {
    $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/albums' );
    $albums = json_decode( $response['body'] );

    } catch ( Exception $ex ) {
        $albums = null;
    }
    return $albums;
  }

  /**
  * Set data from the api
  * @param object $album
  */
  private function set_album_values($album)
  {
    $this->id        = $album->id;
    $this->user_id   = $album->userId;
    $this->title     = $album->title;
  }

  /**
  * Get the album data
  * @return arrray $output, contains all the album data
  */
  public function get_album_data()
  {
    $output = '';

    if (null == ($json_response = $this->fetch_album_data())) :
      $output = "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $album) :
        $this->set_album_values($album);
        $output[] = array(
            'id'       =>  $album->id,
            'user_id'  =>  $album->userId,
            'title'    =>  $album->title,
        );
      endforeach;
    endif;
    return $output;
  }
}
