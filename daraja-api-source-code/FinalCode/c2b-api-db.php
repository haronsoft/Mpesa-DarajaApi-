<?php
	require 'processTransactions.class.php';

	$processTransactions = new processTransactions;


	$jsonObject = file_get_contents('php://input');
	$c2bJson = json_decode($jsonObject, true);
	$processTransactions->c2b_process($c2bJson);

	

