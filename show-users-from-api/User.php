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
        $users = json_decode( $response['body'] );

    } catch ( Exception $ex ) {
        $users = null;
    }
    return $users;
  }

  /**
  * Fetch the user's address info from the api
  * @param object[] $user
  * @return array() $output containing the address info from $user
  */
  private function get_adress($user)
  {
    $output = array();

    if(!empty($user->address)):
      $address = get_object_vars($user->address);
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
  * @param object[] $user
  * @return array() $output containing the company info from $user
  */
  private function get_company($user)
  {
    $output = array();

    if(!empty($user->company)) :
      $company = get_object_vars($user->company);
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
  * @param object[] $user
  */
  private function set_user_values($user)
  {
    $this->id = $user->id;

    if(!empty($user->name)) :
      $this->name = $user->name;
      else: $this->name = 'Not available';
    endif;

    if(!empty($user->username)) :
      $this->username = $user->username;
      else: $this->username = 'Not available';
    endif;

    if(!empty($user->email)) :
      $this->email = $user->email;
      else: $this->email = 'Not available';
    endif;

    if(!empty($user->phone)) :
      $this->phone = $user->phone;
      else: $this->phone = 'Not available';
    endif;

    if(!empty($user->website)) :
       $this->website = $user->website;
    else: $this->website = 'Not available';
    endif;

    if(!empty($user->address)) :
       $this->address = $user->address;
    endif;

    if(!empty($user->company)) :
       $this->company = $user->company;
    endif;
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
  * @return string $html to display all user data
  */
  public function show_users()
  {
    $html = '';

    if (null == ($json_response = $this->fetch_data())) :
      $html .= "<h1>Sorry, I couldn't find the api</h1>";
    else :
      foreach ($json_response as $user) :
        $this->set_user_values($user);
        $html .= '<div class="displayed-person">';
        $html .= '<div class="person-info">';
        $html .= '<p><b>Name:</b><br>' . $this->name . '</p>';
        $html .= '<p><b>Email:</b><br>' . $this->email . '</p>';
        $html .= '<p><b>Address:</b><br>';
        foreach ($this->get_adress($this) as $value) :
          $html .= $value . '<br>';
        endforeach;
        $html .= '</div><div class="person-info">';
        $html .= '<p><b>Username:</b><br>' . $this->username . '</p>';
        $html .= '<p><b>Phone:</b><br>' . $this->phone . '</p>';
        $html .= '<p><b>Website:</b><br>' . $this->website . '</p>';
        $html .= '<p><b>Company:</b><br>';
        foreach ($this->get_company($this) as $company) :
         $html .= $company . '<br>';
        endforeach;
        $html .= '</p></div></div>';
      endforeach;
    endif;
    return $html;
  }
}

$show_users = new User();
