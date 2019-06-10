<?php
require 'processTransactions.class.php';

$processTransactions = new processTransactions;

$jsonObject = file_get_contents('php://input');


$lnmoRaw = json_decode($jsonObject);

if($lnmoRaw->Body->stkCallback->ResultCode == 0){
	if($processTransactions->lnmo_process($lnmoRaw) == true){
		echo json_encode(['ResultCode' => 0, 'ResultDesc' => "Success, Response Received"]);
	}	
	else{
		echo json_encode(['ResultCode' => 1, 'ResultDesc' => "Failed, No Response Received"]);
	}
}
else{

	/**
	*
	* @todo Log API endpoint Access
	*
	*
	*/
	echo json_encode(['ResultCode' => 1, 'ResultDesc' => "Failed. Transaction Has Failed"]);
}
