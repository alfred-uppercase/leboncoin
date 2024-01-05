<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    /*cache control*/
    $this->load->database();
    $this->load->model('crud_model');
    $this->load->model('frontend_model');
    $this->load->model('email_model');
    $this->load->library('session');
    $this->load->helper('directory');
    // Set the timezone
    date_default_timezone_set(get_settings('timezone'));
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    $this->load->helper("file");
  }
  public function get_categories()
  {
    log_message('debug', 'get_categories method called'); // Ajoutez cette ligne
    $CI	=&	get_instance();
    $CI->load->database();

    // $CI->db->where('id', $category_id);
    $result = $CI->db->get('category');

    // if ($category_id > 0) {
    //     $this->db->where('id', $category_id);
    // }
    
    // $query = $this->db->get('category');
    $datas = $result->result_array();
    
    log_message('debug', 'Data from database: ' . json_encode($data)); // Ajoutez cette ligne
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($datas));
  }
  function get_cities()
  {
    $CI	=&	get_instance();
    $CI->load->database();


    $result = $CI->db->get('city');
    $datas = $result->result_array();

    $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas));
  }
  function get_listing_url($listing_id = ""){
    $CI =&  get_instance();
    $CI->load->database();
    $listing = $CI->db->get_where('listing', array('id' => $listing_id))->row_array();
    $custom_url = site_url($listing['listing_type'].'/'.slugify($listing['name']).'/'.$listing_id);
    // return $custom_url;
    $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($custom_url));
  }
    public function get_data() {
        // Logique pour récupérer les données depuis la base de données
        $data = array('1','2','3');

        // Convertir les données en format JSON et les renvoyer
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
	function get_phrase($phrase = '') {
		$CI	=&	get_instance();
		$CI->load->database();
		$language_code = $CI->db->get_where('settings' , array('type' => 'language'))->row()->description;
		$key = strtolower(preg_replace('/\s+/', '_', $phrase));

		$langArray = openJSONFile($language_code);
		if (array_key_exists($key, $langArray)) {
		} else {
			$langArray[$key] = ucfirst(str_replace('_', ' ', $key));
			$jsonData = json_encode($langArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			file_put_contents(APPPATH.'language/'.$language_code.'.json', stripslashes($jsonData));
		}
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($langArray[$key]));
	}
    function get_frontend_settings($type = '') {
      $CI	=&	get_instance();
      $CI->load->database();

      $CI->db->where('type', $type);
      $result = $CI->db->get('frontend_settings')->row('description');
      // return $result;
      $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
    function filter_listings($page_number = 1)
    {

        $category_ids = array();
        $amenity_ids    = array();
        $city_id        = "";
        $state_id        = "";
        $price_range  = 0;
        $with_video   = 0;
        $with_open   = 'all';
        $search_string="";

     

        //name  //zzz

        if (isset($_GET['search_string']) && !empty($_GET['search_string'])) {
            $search_string=$_GET['search_string'];
           
        }
        else
        {
            $search_string="";
        }

    

     

        if (isset($_GET['selected_city_id']) && !empty($_GET['selected_city_id'])) {
            if ($_GET['selected_city_id'] != '') {
                $city_id = $_GET['selected_city_id'];
            } else {

                $city_id = '';
            }
        }

        if (isset($_GET['selected_category_id']) && !empty($_GET['selected_category_id'])) {
           
                $category_id = $_GET['selected_category_id'];
                array_push($category_ids, $category_id);
            
        }


        // // OLD CODE
        // // Get the category ids
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $selected_categories = explode('--', $_GET['category']);
            foreach ($selected_categories as $category) {
                $category_id = $this->db->get_where('category', array('slug' => $category))->row()->id;
                array_push($category_ids, $category_id);
            }
        }

        // Get the amenity ids
        if (isset($_GET['amenity']) && !empty($_GET['amenity'])) {
            $selected_amenities = explode('--', $_GET['amenity']);
            foreach ($selected_amenities as $amenity) {
                $amenity_id = $this->db->get_where('amenities', array('slug' => $amenity))->row()->id;
                array_push($amenity_ids, $amenity_id);
            }
        }

        // Get the city ids
        if (isset($_GET['city']) && !empty($_GET['city'])) {
            if ($_GET['city'] != 'all') {
                $city_id = $this->db->get_where('city', array('slug' => $_GET['city']))->row()->id;
            } else {

                $city_id = 'all';
            }
        }

        // Get the state ids
        if (isset($_GET['state']) && !empty($_GET['state'])) {
            if ($_GET['state'] != 'all') {
                $state_id = $this->db->get_where('state', array('slug' => $_GET['state']))->row()->id;
            } else {
                $state_id = 'all';
            }
        }

        // Get video existance filter
        if (isset($_GET['video']) && !empty($_GET['video'])) {
            $with_video = $_GET['video'];
        }

        // Get status existance filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $with_open = $_GET['status'];
        }

        // Get Price range filter
        if (isset($_GET['price-range']) && !empty($_GET['price-range'])) {
            $price_range = $_GET['price-range'];
        }

        // If all the filter options remain default, redirect to listings method
        if ($_GET['category'] == "" && $_GET['amenity'] == "" && $_GET['city'] == "all" && $price_range == 0 && $_GET['video'] == 0 && $_GET['status'] == 'all') {
            redirect(site_url('home/listings'), 'refresh');
        }

        $all_listings = $this->frontend_model->filter_listing_all_rows($search_string,$category_ids, $amenity_ids, $state_id, $city_id, $price_range, $with_video, $with_open);
        $listings = $this->frontend_model->filter_listing($search_string,$category_ids, $amenity_ids, $state_id, $city_id, $price_range, $with_video, $with_open, $page_number);


        $page_data['geo_json']       =  $this->make_geo_json_for_map($listings);


        $total_listings = count($all_listings);
        if ($total_listings > 12) :

            $page_data['pagination'] = "filter_page";
            $total_page_number = $total_listings / 12;
            if ($total_listings % 12 != 0) :
                $total_page_number = intval($total_page_number) + 1;
            endif;

            $page_data['total_page_number'] = $total_page_number;
            $page_data['active_page_number'] = $page_number;
        else :
            $page_data['pagination'] = false;
        endif;

        $page_data['page_name']    =  'listings';
        $page_data['title']        = get_phrase('listings');
        $page_data['listings']     = $listings;
        $page_data['category_ids'] = $category_ids;
        //$page_data['selected_category_id'] = $selected_category_id;
        $page_data['amenity_ids']  = $amenity_ids;
        $page_data['city_id']      = $city_id;
        $page_data['search_string']      = $search_string;
        $page_data['state_id']      = $state_id;
        $page_data['with_video']   = $with_video;
        $page_data['with_open']   = $with_open;
        $page_data['price_range']  = $price_range;
        // $this->load->view('frontend/index', $page_data);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($page_data));
    }
  
}
