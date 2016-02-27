<?php
    require 'vendor/autoload.php';
    require 'plivo/plivo.php';
    use Plivo\RestAPI;

    // Configuration
    $auth_id = "XXXXXXXXXXXXXXXXXXXX";
    $auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXX";
    $app_url = "my-domain.com/callmeapp";    //This app URL
    $from = '12121211110';    //Number that your client will see
    $to = ['12121211110'];    //List of number Plivo will dial
    $from_plivo = '12777777777';    //Number that you will see when Plivo call you

    //Connect to Plivo API
    $p = new RestAPI($auth_id, $auth_token);
    $callback_number = $_REQUEST['phoneNumber'];

    //Prepare number to dial
    $next_number = 0;
    if(isset($_REQUEST['nextNumber'])){
        $next_number = $_REQUEST['nextNumber'];
    }

    // Make Call 
    if(count($to) >= $next_number + 1){
           
        $params = array(
                'to' => $to[$next_number],
                'from' => $from_plivo,
                'answer_url' => 'http://' . $app_url . '/callback.php?TO=' . $callback_number . '&CLID=' . $from,
                'hangup_url' => 'http://' . $app_url . '/make_call.php?phoneNumber=' . $callback_number . '&nextNumber=' . ++$next_number,
                'answer_method' => 'GET',
                'hangup_method' => 'GET',
            );
        $response = $p->make_call($params);
       
         // Send a SMS message
        // foreach ($to as $t) {
        //     $params = array(
        //             'src' => $from_plivo, // Sender's phone number with country code
        //             'dst' => $t, // Receiver's phone number with country code
        //             'text' => $callback_number // Your SMS text message
        //         );
        //     // Send message
        //     $response = $p->send_message($params);
        // }
    }
?>