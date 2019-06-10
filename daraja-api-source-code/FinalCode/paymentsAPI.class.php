<?php
require 'config.class.php';

/**
 * v1.0
 *
 *
 * (c) Benson Njunge
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 *
 */
class MobilePayments extends Config {
	/**
	* This is the OAuth Token Provided by M-PESA Gateway
	*
	*
	* @var string
	*/
	public $access_token;

	/**
	*
	* This is the consumer key obtained from the M-PESA Developer Account for 
	* our specific app
	*
	* @var string
	*/
	public $consumerKey;

	/**
	*
	* This is the consumer secret obtained from the M-PESA Developer Account for 
	* our specific app
	*
	* @var string
	*/
	public $consumerSecret;

	/**
	*
	* This are headers required to be sentalong with your request
	*
	* @var array
	*/
	public $headers;

	
	function __construct($consumerKey, $consumerSecret){
		$this->consumerKey = $consumerKey;
		$this->consumerSecret = $consumerSecret;
		$this->headers = ['Content-Type:application/json; charset=utf8'];
		$this->access_token = $this->get_access_token();
		$this->requestHeader = array('Content-Type:application/json','Authorization:Bearer '.$this->access_token);
	}

	/**
	*
	* This function is used to obtain the security credential
	*
	* @access private
	* @return string: access token
	*
	*/
	public function security_credential(){
		//@todo
	}

	/**
	*
	* This function is used to obtain the OAuth access token
	*
	* @access private
	* @return string: access token
	*
	*/

	private function get_access_token(){		
		$curl = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
		curl_setopt_array($curl,
			array(
				CURLOPT_HTTPHEADER => $this->headers, 
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => false,
				CURLOPT_USERPWD => $this->consumerKey.':'.$this->consumerSecret
			)
		);		
		$result = json_decode(curl_exec($curl));
		curl_close($curl);
		return $result->access_token;
	}

	public function register_urls($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}

	/**
	*
	* This is just an abstract method for a simulated transaction
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/

	public function simulate_transaction($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}


	/**
	*
	* This is just an abstract method for a lipa na m-pesa online
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/
	
	public function lipa_na_mpesa_online($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);		
	}


	/**
	*
	* This is just an abstract method for B2B API
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/

	public function b2b_api($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}



	/**
	*
	* This is just an abstract method for a B2C API
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/

	public function b2c_api($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}

	/**
	*
	* This is just an abstract method for a Account Balance API
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/

	public function account_balance_api($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}

	/**
	*
	* This is just an abstract method for Transaction Status API
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/

	public function transaction_status($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}

	/**
	*
	* This is just an abstract method for Reversal API
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/

	public function reverse_transaction($endPointURL, $curl_post_data){
		return $this->transaction_request_body($endPointURL, $curl_post_data);
	}

	/**
	*
	* This is a base method for initiating the API Request from all other methods
	*
	* @access public
	*
	* @param string: M-PESA API endpoint URL for transaction simulation
	* @param array: M-PESA API Request Body 
	*
	*/
	public function transaction_request_body($endPointURL, $curl_post_data){
		$curl = curl_init();		
		curl_setopt_array($curl, 
			array(
				CURLOPT_URL => $endPointURL,
				CURLOPT_HTTPHEADER => $this->requestHeader,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $curl_post_data
			)
		);
		$curl_response = curl_exec($curl);
		return $curl_response;
	}
	
}