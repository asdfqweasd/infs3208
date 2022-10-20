<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class User_Authentication extends CI_Controller { 
     
    function __construct(){ 
        parent::__construct(); 
         
        // Load user model 
        $this->load->model('user'); 
         
        // Load twitter oauth library 
        $this->load->library('twitteroauth'); 
    } 
     
    public function index(){ 
        $userData = array(); 
         
        // Get existing token and token secret from session 
        $sessToken = $this->session->userdata('token'); 
        $sessTokenSecret = $this->session->userdata('token_secret'); 
         
        // Get status and user info from session 
        $sessStatus = $this->session->userdata('status'); 
        $sessUserData = $this->session->userdata('userData'); 
         
        if(!empty($sessStatus) && $sessStatus == 'verified'){ 
            // Connect and get latest tweets 
            $twitteroauth = $this->twitteroauth->authenticate($sessUserData['accessToken']['oauth_token'], $sessUserData['accessToken']['oauth_token_secret']); 
             
            $data['tweets'] = $twitteroauth->get('statuses/user_timeline', array('screen_name' => $sessUserData['username'], 'count' => 5)); 
 
            // User info from session 
            $userData = $sessUserData; 
             
        }elseif(isset($_REQUEST['oauth_token']) && $sessToken == $_REQUEST['oauth_token']){ 
            // Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name 
            $twitteroauth = $this->twitteroauth->authenticate($sessToken, $sessTokenSecret); 
            $accessToken = $twitteroauth->getAccessToken($_REQUEST['oauth_verifier']); 
             
            if($twitteroauth->http_code == '200'){ 
                // Get the user's twitter profile info 
                $userInfo = $twitteroauth->get('account/verify_credentials'); 
                 
                // Preparing data for database insertion 
                $name = explode(" ",$userInfo->name); 
                $first_name = isset($name[0])?$name[0]:''; 
                $last_name = isset($name[1])?$name[1]:''; 
                 
                $userData = array( 
                    'oauth_provider' => 'twitter', 
                    'oauth_uid' => $userInfo->id, 
                    'username' => $userInfo->screen_name, 
                    'first_name' => $first_name, 
                    'last_name' => $last_name, 
                    'locale' => $userInfo->lang, 
                    'link' => 'https://twitter.com/'.$userInfo->screen_name, 
                    'picture' => $userInfo->profile_image_url 
                ); 
                 
                // Insert or update user data 
                $userID = $this->user->checkUser($userData); 
                 
                // Get latest tweets 
                $data['tweets'] = $twitteroauth->get('statuses/user_timeline', array('screen_name' => $userInfo->screen_name, 'count' => 5)); 
                 
                // Store the status and user profile info into session 
                $userData['accessToken'] = $accessToken; 
                $this->session->set_userdata('status', 'verified'); 
                $this->session->set_userdata('userData', $userData); 
            }else{ 
                $data['error_msg'] = 'Authentication failed, please try again later!'; 
            } 
        }elseif(isset($_REQUEST['denied'])){ 
            $data['oauthURL'] = base_url().'user_authentication/'; 
            $data['error_msg'] = 'Twitter authentication was denied!'; 
        }else{ 
            // Unset token and token secret from the session 
            $this->session->unset_userdata('token'); 
            $this->session->unset_userdata('token_secret'); 
             
            // Fresh authentication 
            $twitteroauth = $this->twitteroauth->authenticate($sessToken, $sessTokenSecret); 
            $requestToken = $twitteroauth->getRequestToken(); 
             
            // If authentication is successful (http code is 200) 
            if($twitteroauth->http_code == '200'){ 
                // Get token info from Twitter and store into the session 
                $this->session->set_userdata('token', $requestToken['oauth_token']); 
                $this->session->set_userdata('token_secret', $requestToken['oauth_token_secret']); 
             
                // Twitter authentication url 
                $twitterUrl = $twitteroauth->getAuthorizeURL($requestToken['oauth_token']); 
                $data['oauthURL'] = $twitterUrl; 
            }else{ 
                // Internal authentication url 
                $data['oauthURL'] = base_url().'user_authentication/'; 
                $data['error_msg'] = 'Error connecting to twitter! try again later!'; 
            } 
        } 
 
        $data['userData'] = $userData; 
        $this->load->view('user_authentication/index', $data); 
    } 
 
    public function logout() { 
        // Remove session data 
        $this->session->unset_userdata('token'); 
        $this->session->unset_userdata('token_secret'); 
        $this->session->unset_userdata('status'); 
        $this->session->unset_userdata('userData'); 
        $this->session->sess_destroy(); 
         
        // Redirect to the login page 
        redirect('/user_authentication/'); 
    } 
     
}