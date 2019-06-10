<?php

/**
 * 
 */
class Config
{

	
	function __construct(){
	
	}
public function connect(){
	# 1.1. DB Config Section
		$dbName = '';
		$dbHost = '';
		$dbUser = '';
		$dbPass = '';

	# 1.1.1 establish a connection
		try{
			$con = new PDO("mysql:dbhost=$dbHost;dbname=$dbName", $dbUser, $dbPass);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $con;
		}
		catch(PDOException $e){
			die("Error Connecting ".$e->getMessage());
		}
}

	
public function insert_simulation_response($jsonMpesaResponse){
	$conn = $this->connect();
	
	# 1.1.2 Insert Response to Database
	try{
		$insert = $conn->prepare("INSERT INTO `mobile_payments`(`TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`) VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)");
		$insert->execute((array)$jsonMpesaResponse);

		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('Transaction.txt', 'a');
		fwrite($Transaction, json_encode($jsonMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonMpesaResponse);
	}
}

public function insert_b2c_response($jsonB2CMpesaResponse){
	$conn = $this->connect();
	try{
		$insert = $conn->prepare("INSERT INTO `b2c_api_response`(`TransactionReceipt`, `TransactionAmount`, `B2CWorkingAccountAvailableFunds`, `B2CUtilityAccountAvailableFunds`, `TransactionCompletedDateTime`, `ReceiverPartyPublicName`, `B2CChargesPaidAccountAvailableFunds`, `B2CRecipientIsRegisteredCustomer`) VALUES (:TransactionReceipt, :TransactionAmount, :B2CWorkingAccountAvailableFunds, :B2CUtilityAccountAvailableFunds, :TransactionCompletedDateTime, :ReceiverPartyPublicName, :B2CChargesPaidAccountAvailableFunds, :B2CRecipientIsRegisteredCustomer)");
		$insert->execute((array)($jsonB2CMpesaResponse));

		echo "We saved that";
		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('B2CTransactions.log', 'a');
		fwrite($Transaction, json_encode($jsonB2CMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonB2CMpesaResponse);
	}
}

public function insert_b2b_response($jsonB2BMpesaResponse){
	$conn = $this->connect();
	try{
		$insert = $conn->prepare("INSERT INTO `b2b_api_response`(`TransactionID`, `InitiatorAccountCurrentBalance`, `DebitAccountCurrentBalance`, `Amount`, `DebitPartyAffectedAccountBalance`, `TransCompletedTime`, `DebitPartyCharges`, `ReceiverPartyPublicName`, `Currency`) VALUES (:TransactionID, :InitiatorAccountCurrentBalance,:DebitAccountCurrentBalance, :Amount, :DebitPartyAffectedAccountBalance, :TransCompletedTime, :DebitPartyCharges, :ReceiverPartyPublicName, :Currency)");
		$insert->execute((array)($jsonB2BMpesaResponse));

		echo "We saved that";
		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('B2CTransaction.log', 'a');
		fwrite($Transaction, json_encode($jsonB2BMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonLNMOMpesaResponse);
	}
}

public function insert_transaction_status_response($jsonTransactionStatusMpesaResponse){
	$conn = $this->connect();
	try{
		$insert = $conn->prepare("INSERT INTO `transaction_status`(`ReceiptNo`, `ConversationID`, `FinalisedTime`, `Amount`, `TransactionStatus`, `ReasonType`, `DebitPartyCharges`, `DebitAccountType`, `InitiatedTime`, `OriginatorConversationID`, `CreditPartyName`, `DebitPartyName`) VALUES (:ReceiptNo, :ConversationID, :FinalisedTime, :Amount, :TransactionStatus, :ReasonType, :DebitPartyCharges, :DebitAccountType, :InitiatedTime, :OriginatorConversationID, :CreditPartyName, :DebitPartyName)");
		$insert->execute((array)($jsonTransactionStatusMpesaResponse));

		echo "We saved that";
		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('StatusTransaction.log', 'a');
		fwrite($Transaction, json_encode($jsonTransactionStatusMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonTransactionStatusMpesaResponse);
	}
}

public function insert_account_balance_response($jsonAccountBalanceMpesaResponse){
	$conn = $this->connect();
	try{
		$insert = $conn->prepare("INSERT INTO `accountbalance`(`WorkingAccount`, `FloatAccount`, `UtilityAccount`, `ChargesPaidAccount`, `OrganizationSettlementAccount`, `BOCompletedTime`) VALUES (:WorkingAccount, :FloatAccount, :UtilityAccount, :ChargesPaidAccount, :OrganizationSettlementAccount, :BOCompletedTime)");
		$insert->execute((array)($jsonAccountBalanceMpesaResponse));

		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('AccountBalTransaction.log', 'a');
		fwrite($Transaction, json_encode($jsonAccountBalanceMpesaResponse));
		fclose($Transaction);
		
		return json_encode(['Success']);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonAccountBalanceMpesaResponse);
	}
}

public function insert_reverse_transaction($jsonReverseTransactionMpesaResponse){
	$conn = $this->connect();
	try{
		$insert = $conn->prepare("INSERT INTO `reverse_transaction`(`DebitAccountBalance`, `Amount`, `TransCompletedTime`, `OriginalTransactionID`, `Charge`, `CreditPartyPublicName`, `DebitPartyPublicName`) VALUES (:DebitAccountBalance, :Amount, :TransCompletedTime, :OriginalTransactionID, :Charge, :CreditPartyPublicName, :DebitPartyPublicName)");
		$insert->execute((array)($jsonReverseTransactionMpesaResponse));

		echo "We saved that";
		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('ReverseTransactions.log', 'a');
		fwrite($Transaction, json_encode($jsonReverseTransactionMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonReverseTransactionMpesaResponse);
	}
}

public function insert_lnmo_transaction($jsonLNMOMpesaResponse){
	$conn = $this->connect();
	try{
		$insert = $conn->prepare("INSERT INTO `lnmo_api_response`(`Amount`, `MpesaReceiptNumber`, `TransactionDate`, `PhoneNumber`) VALUES (:Amount, :MpesaReceiptNumber, :TransactionDate, :PhoneNumber)");
		$insert->execute((array)($jsonLNMOMpesaResponse));

		echo "We saved that";
		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('LNMOTransaction.log', 'a');
		fwrite($Transaction, json_encode($jsonLNMOMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$this->error_log($e, $MpesaResponse = $jsonLNMOMpesaResponse);
		
	}
}
/**
*
* Error Log
* @access private
*
* @
*/

private function error_log($e, $MpesaResponse){
			$errLog = fopen('error.txt', 'a');
			fwrite($errLog, date('d-m-Y H:i:s'). ' - ' .$e->getMessage());
			fclose($errLog);

			# 1.1.2o Optional. Log the failed transaction. Remember, it has only failed to save to your database but M-PESA Transaction itself was successful. 
			$logFailedTransaction = fopen('FailedTransactions.log', 'a');
			fwrite($logFailedTransaction, json_encode($MpesaResponse));
			fclose($logFailedTransaction);
	}
}
?>