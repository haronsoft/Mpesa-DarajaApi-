<?php
	require 'processTransactions.class.php';


	$processTransactions = new processTransactions;
	$jsonObject = file_get_contents('php://input');

	$accBalJson = json_decode($jsonObject);

	if($accBalJson->Result->ResultCode == 0){
		$processTransactions->account_balance($accBalJson);
	}
	else{
		echo "Transaction Failed before you knew it";
	}

