<?php
/*
* This is the template to display images in galleries
*/
$i = 0;
$album_count = 0;
$images = new EpicPicture();
$albums = new EpicAlbum();
$html = '';

foreach ($albums->get_album_data() as $album) :
  $html .= '<div class="album-container">';
  $album_count++;
  $html .= '<div class="album-info">';
  $html .= '<p><b>Gallery name:</b> ' . ucfirst($album['title']) . '</p>';
  $html .= '<p><b>Gallery creator:</b> ' . $album['user_name'] . '</p>';
  $html .= '</div>';
  $html .= '<div class="image-container">';
    foreach ($images->get_image_data() as $image) :
      if ($image['album_id'] === $album_count) :
        $i++;
        $html .= '<div class="single-image-wrapper">';
        $html .= '<div class="single-image" style="background-image: url(' . $image['url']  .');"></div>';
        $html .= '<p class="single-image-title">' . ucfirst($image['title']) . '</p>';
        $html .= '</div>';
         if($i == 3) :
           $html .= '</div>';
           $i = 0;
           break;
         endif;
      endif;
    endforeach;
  $html .= '</div>';
  if($album_count == 10) :
    break;
  endif;
endforeach;

echo $html;
