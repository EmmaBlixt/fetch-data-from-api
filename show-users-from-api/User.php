<?php
 /*
 Plugin Name: Show Users From Api
 description: Get users from a dummy API and display it through a shortcode
 Author: Emma Blixt
 Author URI: https://standout.se
 */

defined('ABSPATH') or die('No script kiddies please!');
require_once 'includes/setup.php';

class User
{
  private $id;
  private $name;
  private $username;
  private $email;
  private $address;
  private $phone;
  private $website;
  private $company;

  function __construct()
  {
    return $this->init();
  }

  /**
  * Initialize the class & add WP hooks
  */
  public function init()
  {
    add_shortcode('display-users', array($this, 'show_users'));
  }

  /**
  * Fetch data from the api
  * @return object $data that contains all the user information
  */
  private function fetch_data()
  {
    $response = wp_remote_get( 'https://jsonplaceholder.typicode.com/users' );
     try {
        $data = json_decode( $response['body'] );

    } catch ( Exception $ex ) {
        $data = null;
    }
    return $data;
  }

  /**
  * Fetch the user's address info from the api
  * @param object[] $data
  * @return array() $output containing the address info from $data
  */
  private function get_adress($data)
  {
    $output = array();

    if(!empty($data->address)):
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
    else :
      $output = array('status' => 'Not available');
    endif;
    return $output;
  }

  /**
  * Fetch the user's name from the api
  * @param object[] $data
  * @return array() $output containing the company info from $data
  */
  private function get_company($data)
  {
    $output = array();

    if(!empty($data->company)) :
      $company = get_object_vars($data->company);
      $output = array(
          'name'          =>  'Name: '  . $company["name"],
          'catchPhrase'   =>  'Catchphrase: '  . $company["catchPhrase"],
          'bs'            =>  'Bs: '  . $company["bs"],
          );
    else :
      $output = array('status' => 'Not available');
    endif;
    return $output;
  }

  /**
  * Set data variables for User objects
  * @param object[] $person
  */
  private function set_user_values($person)
  {
    if(!empty($person->username)) :
      $this->username = $person->username;
      else: $this->username = 'Not available';
    endif;

    if(!empty($person->email)) :
      $this->email = $person->email;
      else: $this->email = 'Not available';
    endif;

    if(!empty($person->phone)) :
      $this->phone = $person->phone;
      else: $this->phone = 'Not available';
    endif;

    if(!empty($person->website)) :
       $this->website = $person->website;
    else: $this->website = 'Not available';
    endif;

    if(!empty($person->address)) :
       $this->address = $person->address;
    endif;

    if(!empty($person->company)) :
       $this->company = $person->company;
    endif;

    $this->id = $person->id;
    $this->name = $person->name;
  }

  /**
  * Get data variables for User objects
  * @return array $output that contains user id and name
  */
  public function get_user_values()
  {
    $output = '';

    if (null == ($json_response = $this->fetch_data())) :
      $output = "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $person) :
        $this->set_user_values($person);
        $output[] = array(
            'id'    =>  $person->id,
            'name'  =>  $person->name,
        );
      endforeach;
    endif;
    return $output;
  }

  /**
  * Fetch the user's name from the api
  * @param object[] $data
  * @return string $html to display all user data
  */
  public function show_users($data)
  {
    $html = '';

    if (null == ($json_response = $this->fetch_data())) :
      $html .= "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $person) :
        $this->set_user_values($person);
        $html .= '<div class="displayed-person" style="height:340px">';
        $html .= '<div class="person-info" style="width: 300px; float: left;">';
        $html .= '<p><b>Name:</b><br>' . $this->name . '</p>';
        $html .= '<p><b>Email:</b><br>' . $this->email . '</p>';
        $html .= '<p><b>Address:</b><br>';
        foreach ($this->get_adress($this) as $value) :
          $html .= $value . '<br>';
        endforeach;
        $html .= '</div><div class="person-info" style="width: 360px; float: left;">';
        $html .= '<p><b>Username:</b><br>' . $this->username . '</p>';
        $html .= '<p><b>Phone:</b><br>' . $this->phone . '</p>';
        $html .= '<p><b>Website:</b><br>' . $this->website . '</p>';
        $html .= '<p><b>Company:</b><br>';
        foreach ($this->get_company($this) as $company) :
         $html .= $company . '<br>';
        endforeach;
        $html .= '</p></div></div><hr>';
      endforeach;
    endif;
    return $html;
  }
}

$show_users = new User();
