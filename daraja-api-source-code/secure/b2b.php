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

    /**
    * Your POST  Request should Contain  Amount, PartyB(The Second Paybill/Till Number
    * you will paying to, Remarks, AccountReference
    *
    */
    $payData = $_POST;


    /* Do not alter from this Part */
    $payData['CommandID'] = 'BusinessPayBill';

    $basicData = array(
        //Fill in the request parameters with valid values
        'Initiator' => $Initiator,
        'SecurityCredential' => $securityCredential,
        'SenderIdentifierType' => '4',
        'RecieverIdentifierType' => '4',
        'PartyA' => $ShortCode,
        'QueueTimeOutURL' => $QueueTimeOutURL,
        'ResultURL' => $B2BResultURL
      );


    $endPointURL = 'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
    $curl_post_data = array_merge($payData, $basicData);       
    $curl_post_data = json_encode($curl_post_data);

    /* process transaction */     
    echo $BusninessAPI->b2b_api($endPointURL, $curl_post_data);

?>