<?php
class linked1 extends CI_Controller {

    function __construct(){
        parent:: __construct();
        $this->load->library('session');
    }


    public function getAuthorizationCode() {
        $params = array('response_type' => 'code',
            'client_id' => "81mo00q4vr60vw",
            'scope' => "r_basicprofile,r_emailaddress",
            'state' => uniqid('', true), // unique long string
            'redirect_uri' => base_url()."register/socialresponse/3/",
        );
        // Authentication request
        $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);

        // Needed to identify request when it returns to us
        $this->session->set_userdata('state',$params['state']);

        // Redirect user to authenticate
        header("Location: $url");
        exit;
    }

    public function getAccessToken() {
        $params = array('grant_type' => 'authorization_code',
            'client_id' => "81mo00q4vr60vw",
            'client_secret' => "MrmvKCcP3ZNx8ljt",
            'code' => $_GET['code'],
            'redirect_uri' => base_url()."register/socialresponse/3/",
        );
        // Access Token request
        $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);

        // Tell streams to make a POST request
        $context = stream_context_create(
            array('http' =>
                array('method' => 'POST',
                )
            )
        );

        // Retrieve access token information
        $response = file_get_contents($url, false, $context);

        // Native PHP object, please
        $token = json_decode($response);

        // Store access token and expiration time
        $ses_params = array('access_token' => $token->access_token,
            'expires_in' => $token->expires_in,
            'expires_at' => time() + $_SESSION['expires_in']);
        $this->session->set_userdata($ses_params);
        return true;
    }

    public function fetch($method, $resource, $body = '') {
        $params = array('oauth2_access_token' => $_SESSION['access_token'],
            'format' => 'json',
        );

        // Need to use HTTPS
        $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
        // Tell streams to make a (GET, POST, PUT, or DELETE) request
        $context = stream_context_create(
            array('http' =>
                array('method' => $method,
                )
            )
        );


        // Hocus Pocus
        $response = file_get_contents($url, false, $context);

        // Native PHP object, please
        return json_decode($response);
    }

}