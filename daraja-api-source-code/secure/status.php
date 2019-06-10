<?php
  /**
  *
  * This file helps in receiving simulation requests from your form.
  * The Post Request should be formatted only to accept amount and billref
  * as all the rest are provided for in the FinalCode/params.php
  *
  * This Code is provided in 'as is' no warranties whatsoever on whether it will work
  * and no assurances. By using it, you indemnify the source from any legal obligations.
  *
  */
    require '../FinalCode/params.php';
    
    /* Your POST Request should Contain: TransactionID, Remarks and Occasion. The rest shall be provided from the FinalCode/params.php */
    $payData = $_POST;
    $payData['CommandID'] = 'TransactionStatusQuery';

    $endPointURL = 'https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query';

    $basicData = array(
        'Initiator' => $Initiator,
        'SecurityCredential' => $securityCredential,
        'CommandID' => 'TransactionStatusQuery',
        'PartyA' => $ShortCode,
        'IdentifierType' => '4',
        'ResultURL' => $transactionStatusResultURL,
        'QueueTimeOutURL' => $QueueTimeOutURL
      );
    $curl_post_data = array_merge($payData, $basicData);       
    $curl_post_data = json_encode($curl_post_data);

    /* process transaction */
    echo $BusninessAPI->transaction_status($endPointURL, $curl_post_data);

?>