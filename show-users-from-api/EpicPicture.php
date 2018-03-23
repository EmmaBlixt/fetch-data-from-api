<?php
defined('ABSPATH') or die('No script kiddies please!');
include_once 'epicalbum.php';

class EpicPicture extends EpicAlbum
{
  private $album_id;
  private $id;
  private $title;
  private $url;
  private $thumbnail_url;

  function __construct()
  {
    return $this->init();
  }

  /**
  * Initialize the class & add WP hooks
  */
  public function init()
  {
    add_shortcode('display-pictures', array($this, 'show_pictures'));
  }

  /**
  * Fetch data from the api
  * @return object $images that contains all the image information
  */
  private function fetch_image_data()
  {
    try {
    $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/photos' );
    $images = json_decode( $response['body'] );

    } catch ( Exception $ex ) {
        $images = null;
    }
    return $images;
  }

  /**
  * Set data from the api
  * @param object $image
  */
  private function set_image_values($image)
  {
    $this->id            = $image->id;
    $this->album_id      = $image->albumId;
    $this->title         = $image->title;
    $this->url           = $image->url;
    $this->thumbnail_url = $image->thumbnailUrl;
  }

  /**
  * Set data from the api
  * @return array $output that contains the image data
  */
  public function get_image_data()
  {
    if (null == ($json_response = $this->fetch_image_data())) :
      $output = "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $image) :
        $this->set_image_values($image);
        $output[] = array(
            'id'            =>  $image->id,
            'album_id'      =>  $image->albumId,
            'title'         =>  $image->title,
            'url'           =>  $image->url,
            'thumbnail_url' =>  $image->thumbnailUrl,
        );
      endforeach;
    endif;
    return $output;
  }

  /**
  * Fetch template to display pictures
  */
  public function show_pictures()
  {
    display_template('show-image-gallery.php');
  }
}

$show_pictures = new EpicPicture();
