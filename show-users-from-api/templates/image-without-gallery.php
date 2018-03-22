<?php
/*
* This is the template to display images without adding a gallery
*/
$i = 0;
$images = new EpicPicture();
$html = '<div class="image-container">';

foreach ($images->get_image_data() as $image) :
  $i++;
  $html .= '<div class="single-image-wrapper">';
  $html .= '<div class="single-image" style="background-image: url(' . $image['url']  .');"></div>';
  $html .= '<p class="single-image-title">' . $image['title'] . '</p>';
  $html .= '</div>';
  if($i % 3 == 0 && $i % 30 != 0) :
    $html .= '</div>';
    $html .= '<div class="image-container">';
  endif;
  if($i == 30) :
    $html .= '</div>';
    break;
  endif;
endforeach;
$html .= '</div>';

echo $html;
