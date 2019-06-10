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

    $endPoint = 'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query';
    $basicData = array(
        'Initiator' => $Initiator,
        'SecurityCredential' => $securityCredential,
        'CommandID' => 'AccountBalance',
        'PartyA' => $ShortCode,
        'IdentifierType' => '4',
        'Remarks' => 'Bal',
        'QueueTimeOutURL' => $AccountBalanceQueueTimeOutURL,
        'ResultURL' => $AccountBalanceResultURL
      );

    $curl_post_data = json_encode($basicData);

    /* This expects a GET request to give you the balance status */
    echo $BusninessAPI->lipa_na_mpesa_online($endPoint, $curl_post_data);

?>
