<?php 

/**
 *
 * This class is responsible for formatting the M-PESA Response 
 * Objects to an array then calling the database method for
 * the appropriate insertion.
 *
 * @source v1.0
 * @copyright survtech
 * @author Benson Nunge
 * @licence MIT
 */

require 'paymentsAPI.class.php';


class processTransactions extends MobilePayments{
	
	function __construct()
	{
		parent::__construct();
	}


	/**
	*
	* This method for simplifying C2B Result by preparing the transaction
	* object for saving to database
	*
	* @access public
	* @param array: M-PESA C2B json_decoded Responses
	* 
	* @return bool
	*
	*/
	public function c2b_process($c2bJson){

		$data = [];
		foreach ($c2bJson as $key => $value) {
			$data[':'.$key] = $value;
		}
		$this->insert_simulation_response($data);

		return true;
	}


	/**
	*
	* This method for simplifying by preparing account balance transaction
	* object for saving to database
	*
	* @access public
	* 
	* @param array: acc bal Result
	* 
	* @return bool
	*/

	public function account_balance($accBalJson){
		$accountBalanceResult = $accBalJson->Result->ResultParameters->ResultParameter;
		$accountBalanceResult = json_encode($accountBalanceResult);
		$accountBalanceResult = json_decode($accountBalanceResult, TRUE);

		$requiredData = [];
		foreach ($accountBalanceResult as $nonreq => $params) {
			foreach ($params as $key => $value) {
				$requiredData[] = $value;
			}
		}
		$data = [];
		for($i = 0; $i < count($requiredData); $i+=2){
			$data[$requiredData[$i]] = $requiredData[$i+1];
		}

		file_put_contents('here4.txt', print_r($data, true));
		// usable array data = $data;
		$newAr = explode('&', $data['AccountBalance']);
		
		#working arrays

		$WorkingAccount = array();
		$FloatAccount = array();
		$UtilityAccount = array();
		$ChargesPaidAccount = array();
		$OrganizationSettlementAccount = array();

		$WorkingAccount = $newAr[0];
		$WorkingAccount = explode('|', $WorkingAccount);
		$WorkingAccount[0] = str_replace(" ", "", $WorkingAccount[0]);

		$FloatAccount = $newAr[1];
		$FloatAccount = explode('|', $FloatAccount);
		$FloatAccount[0] = str_replace(" ", "", $FloatAccount[0]);

		$UtilityAccount = $newAr[2];
		$UtilityAccount = explode('|', $UtilityAccount);
		$UtilityAccount[0] = str_replace(" ", "", $UtilityAccount[0]);

		$ChargesPaidAccount = $newAr[3];
		$ChargesPaidAccount = explode('|', $ChargesPaidAccount);
		$ChargesPaidAccount[0] = str_replace(" ", "", $ChargesPaidAccount[0]);

		$OrganizationSettlementAccount = $newAr[4];
		$OrganizationSettlementAccount = explode('|', $OrganizationSettlementAccount);
		$OrganizationSettlementAccount[0] = str_replace(" ", "", $OrganizationSettlementAccount[0]);
		
		# create the array
		$accountBalanceSave = array(
			':OrganizationSettlementAccount' => $OrganizationSettlementAccount[2],
			':ChargesPaidAccount' => $ChargesPaidAccount[2],
			':UtilityAccount' => $UtilityAccount[2],
			':WorkingAccount' => $WorkingAccount[2],
			':FloatAccount' => $FloatAccount[2],
			':BOCompletedTime' => $data['BOCompletedTime']
		);
		file_put_contents('accountBalanceSave.txt', print_r($accountBalanceSave, true));
		$jsonAccountBalanceMpesaResponse = $accountBalanceSave;
		
		$this->insert_account_balance_response($jsonAccountBalanceMpesaResponse);	
	}


	/**
	*
	* This method for simplifying by preparing the transaction
	* object for saving to database
	*
	* @access public
	* 
	* @param array: LNMO Result
	* 
	* @return bool
	*/

	public function lnmo_process($lnmoRaw){

		/**
		*
		* Create Transaction Object into php array
		*
		*/

		$lnmoResult = $lnmoRaw->Body->stkCallback->CallbackMetadata->Item;
		$lnmoResult = json_encode($lnmoResult);
		$lnmoResult = json_decode($lnmoResult, TRUE);

		/*
		*
		* Create new array, with required order
		* for inserting to db
		*/

		$requiredData = [];
		foreach ($lnmoResult as $nonreq => $params) {
			foreach ($params as $key => $value) {
				if($value !== 'Balance'){
					$requiredData[] = $value;
				}
			}
		}
		$data = [];

		/**
		*
		* Convert keys to prepared placeholders
		*
		*/

		for($i = 0; $i < count($requiredData); $i+=2){
			$data[':'.$requiredData[$i]] = $requiredData[$i+1];
		}


		/**
		*
		* Call Method to insert to db
		*
		*/
		
		$this->insert_lnmo_transaction($jsonLNMOMpesaResponse = $data);
		return true;
	}


	/**
	*
	* This method for simplifying B2B Result by preparing the transaction
	* object for saving to database
	*
	* @access public
	* @param array: M-PESA B2B json_decoded Responses
	* 
	* @return bool
	*
	*/
	public function b2b_process($b2bJson){
		$accountBalanceResult = $b2bJson->Result->ResultParameters->ResultParameter;
		$accountBalanceResult = json_encode($accountBalanceResult);
		$accountBalanceResult = json_decode($accountBalanceResult, TRUE);

		/* 
		*
		* Convert Object to array 
		*/

		$requiredData = [];
		foreach ($accountBalanceResult as $nonreq => $params){
			foreach ($params as $key => $value){
				$requiredData[] = $value;
			}
		}

		unset($requiredData[10]);
		$newArr = array_values($requiredData);

		$data = [];
		for($i = 0; $i < count($newArr); $i+=2){
				$data[$newArr[$i]] = $newArr[$i+1];
		}

		/*
		* get balance 
		*
		*/

		$DebitPartyAffectedAccountBalance = $data['DebitPartyAffectedAccountBalance'];
		$balArray = explode('|', $DebitPartyAffectedAccountBalance);
		$data['DebitPartyAffectedAccountBalance'] = $balArray[2];


		/**
		*
		* get transaction cost 
		* @todo Get Transaction Cost
		*
		*/

		# uncomment this when Balnace starts showing up

		/*
		$DebitPartyCharges = $data['DebitPartyCharges'];
		$chargesArray = explode('|', $DebitPartyCharges);

		if($chargesArray[2] == ''  || !$chargesArray[2]){
			$chargesArray[2] = '0';
		}
		$data['DebitPartyCharges'] = $chargesArray[2];
		*/

		/* 
		*
		* Format Initiator Account Current Balance
		*/

		$InitiatorAccountCurrentBalance = $data['InitiatorAccountCurrentBalance'];
		$initiatorBalance = explode('{', $InitiatorAccountCurrentBalance);
		$initiatorBalance = explode('}', $initiatorBalance[2]);
		$initiatorBalance = explode('=', $initiatorBalance[0]);
		$data['InitiatorAccountCurrentBalance'] = $initiatorBalance[3];

		/* 
		* 
		* Format Debit Account Current Balance 
		*/
		$DebitAccountCurrentBalance = $data['DebitAccountCurrentBalance'];
		$initiatorDebitBalance = explode('{', $DebitAccountCurrentBalance);
		$initiatorDebitBalance = explode('}', $initiatorDebitBalance[2]);
		$initiatorDebitBalance = explode('=', $initiatorDebitBalance[0]);
		$data['DebitAccountCurrentBalance'] = $initiatorDebitBalance[3];

		$data['TransactionID'] = $b2bJson->Result->TransactionID;

		/* 
		*
		* Create new array with formatted values 
		*/
		$dataInit = [];
		foreach ($data as $key => $value) {
			$dataInit[':'.$key] = $value;
		}

		/**
		* 
		* Initiate the value of DebitPartyCharges to 0
		* then check @todo on the same
		* 
		*
		* @var DebitPartyCharges
		* 
		*/

		$dataInit[':DebitPartyCharges'] = 0;


		/* 
		*
		* save transaction to Database 
		*/

		$this->insert_b2b_response($dataInit);
		return true;
		
	}


	/**
	*
	* This method for simplifying B2C Result by preparing the transaction
	* object for saving to database
	*
	* @access public
	* @param array: M-PESA B2C json_decoded Responses
	* 
	* @return bool
	*
	*/
	public function bc2_process($b2cJsonObject){
		$b2cResult = $b2cJsonObject->Result->ResultParameters->ResultParameter;
		$b2cResult = json_encode($b2cResult);
		$b2cResult = json_decode($b2cResult, TRUE);

		$requiredData = [];
		foreach ($b2cResult as $nonreq => $params){
			foreach ($params as $key => $value) {
				$requiredData[] = $value;
			}
		}
		$data = [];
		for($i = 0; $i < count($requiredData); $i+=2){
			$data[':'.$requiredData[$i]] = $requiredData[$i+1];
		}		

		// usable array data = $data;
		$this->insert_b2c_response($jsonB2CMpesaResponse = $data);
		return true;
	}


	/**
	*
	* This method for simplifying B2C Result by preparing the transaction
	* object for saving to database
	*
	* @access public
	* @param array: M-PESA B2C json_decoded Responses
	* 
	* @return bool
	*
	*/
	public function transaction_status_process($transactionStatusJson){
		$server_url = $_GET['REQUEST']
		$b2bResult = $transactionStatusJson->Result->ResultParameters->ResultParameter;
		$b2bResult = json_encode($b2bResult);
		$b2bResult = json_decode($b2bResult, TRUE);

		$requiredData = [];
		foreach ($b2bResult as $nonreq => $params) {
			foreach ($params as $key => $value) {
				if($value !== 'TransactionReason'){
					$requiredData[] = str_replace(" ", "", $value);
				}
			}
		}
		$data = [];

		for($i = 0; $i < count($requiredData); $i+=2){
			$data[':'.$requiredData[$i]] = $requiredData[$i+1];
		}
		$DebitPartyCharge = $data[':DebitPartyCharges'];
		$DebitPartyCharges = array();
		$DebitPartyCharges = explode('|', $DebitPartyCharge);
		$data[':DebitPartyCharges'] = $DebitPartyCharges[2];

		file_put_contents('data.txt', print_r($DebitPartyCharges, true));

		// usable array data = $data;
		$this->insert_transaction_status_response($jsonTransactionStatusMpesaResponse = $data);
		return true;
	}
}