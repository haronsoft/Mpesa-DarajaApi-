<?php
	/**
	*
	* @source V1.0 M-PESA APIs
	* @author survtech
	* 
	* 
	*/
	require 'config.class.php';

	$conf = new Config;


	$jsonObject = file_get_contents('php://input');

	

	$phpJson = json_decode($jsonObject);
	file_put_contents('reverse.txt', print_r($jsonObject, true));
	die();


	if($phpJson->Result->ResultCode === 0){
		$b2bResult = $phpJson->Result->ResultParameters->ResultParameter;
		$b2bResult = json_encode($b2bResult);
		$b2bResult = json_decode($b2bResult, TRUE);

		$requiredData = [];
		foreach ($b2bResult as $nonreq => $params) {
			foreach ($params as $key => $value) {
				$requiredData[] = $value;
			}
		}
		$data = [];
		$getDebitAccountBalance = $requiredData[1];
		$getDebitAccountBalance = explode("|", $getDebitAccountBalance);
		$requiredData['0'] = 'DebitAccountBalance';
		$requiredData['1'] = $getDebitAccountBalance[2];

		for($i = 0; $i < count($requiredData); $i+=2){
			$data[':'.$requiredData[$i]] = $requiredData[$i+1];
		}
		$conf->insert_reverse_transaction($jsonReverseTransactionMpesaResponse = $data);	
	}
	else{
		echo "Transaction Failed before you knew it";
	}