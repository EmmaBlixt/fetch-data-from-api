<?php
 /*
 Plugin Name: Show Users From Api
 description: Get users from a dummy API and display it through a shortcode
 Author: Emma Blixt
 Author URI: https://standout.se
 */

defined('ABSPATH') or die('No script kiddies please!');
require_once 'includes/setup.php';

class showUsers
{
  private static $instance;

  function __construct()
  {
    return $this->init();
  }

  /**
  * Initialize the class & add WP hooks
  */
  public function init()
  {
    add_shortcode('display-users', array($this, 'display_users'));
  }

  /**
  * Fetch data from the api
  * @return object $data that contains all the user information
  */
  private function fetch_data()
  {
    $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/users' );
     try { // Note that we decode the body's response since it's the actual JSON feed
        $data = json_decode( $response['body'] );

    } catch ( Exception $ex ) {
        $data = null;
    } // end try/catch
    return $data[0];
  }

  /**
  * Fetch the user's name from the api
  * @param object[] $data
  * @return string $data->name from the $data object
  */
  private function get_name($data)
  {
    return $data->name;
  }

  /**
  * Fetch the user's username from the api
  * @param object[] $data
  * @return string $data->username from the $data object
  */
  private function get_username($data)
  {
    return $data->username;
  }

  /**
  * Fetch the user's email from the api
  * @param object[] $data
  * @return string $data->email from the $data object
  */
  private function get_email($data)
  {
    return $data->email;
  }

  /**
  * Fetch the user's address info from the api
  * @param object[] $data
  * @return array() $output containing the address info from $data
  */
  private function get_adress($data)
  {
    $address = get_object_vars($data->address);
    $geo = get_object_vars($address["geo"]);
    $output = array(
        'street'  =>  'Street: '  . $address["street"],
        'suite'   =>  'Suite: '  . $address["suite"],
        'city'    =>  'City: '  . $address["city"],
        'zipcode' =>  'Zipcode: '  . $address["zipcode"],
        'lat'     =>  'Latitude: '  . $geo["lat"],
        'lng'     =>  'Longitude: '  .  $geo["lng"],
        );
    return $output;
  }

  /**
  * Fetch the user's phonenumber from the api
  * @param object[] $data
  * @return string $data->phone
  */
  private function get_phone($data)
  {
    return $data->phone;
  }

  /**
  * Fetch the user's website from the api
  * @param object[] $data
  * @return string data->website containing the website info from $data
  */
  private function get_website($data)
  {
    return $data->website;
  }

  /**
  * Fetch the user's name from the api
  * @param object[] $data
  * @return array() $output containing the company info from $data
  */
  private function get_company($data)
  {
    $company = get_object_vars($data->company);
    $output = array(
        'name'          =>  'Name: '  . $company["name"],
        'catchPhrase'   =>  'Catchphrase: '  . $company["catchPhrase"],
        'bs'            =>  'Bs: '  . $company["bs"],
        );
    return $output;
  }

  /**
  * Fetch the user's name from the api
  * @param object[] $data
  * @return string $html to display all user data
  */
  public function display_users($data)
  {
    $html = '';

    if (null == ($json_response = $this->fetch_data())) :
      $html .= '<h1>';
      $html .= "Sorry, I couldn't find the api";
      $html .= '</h1>';
    else :
      foreach ($json_response as $person) :
        $html .= '<div class="displayed-person"><div>';
        $html .= '<p><b>Name:</b><br>' . $this->get_name($json_response) . '</p>';
        $html .= '<p><b>Username:</b><br> ' . $this->get_username($json_response) . '</p>';
        $html .= '<p><b>Email:</b><br>' . $this->get_email($json_response) . '</p>';
        $html .= '<p><b>Address:</b><br>';
        foreach ($this->get_adress($json_response) as $address) :
          $html .= $address . '<br>';
        endforeach;
        $html .= '</div><div>';
        $html .= '<p><b>Phone:</b><br>' . $this->get_phone($json_response) . '</p>';
        $html .= '<p><b>Website:</b><br>' . $this->get_website($json_response) . '</p>';
        $html .= '<p><b>Company:</b><br>';
        foreach ($this->get_company($json_response) as $company) :
          $html .= $company . '<br>';
        endforeach;
        $html .= '</p></div></div><hr>';
      endforeach;
    endif;

    return $html;
  }
}

$show_users = new showUsers();
