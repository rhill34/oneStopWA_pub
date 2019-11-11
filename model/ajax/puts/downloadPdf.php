<?php

//require_once 'vendor/autoload.php';
$ready = false;
if ($_COOKIE) {
    $ready = true;
//    echo "cookies set<br>";
//    debug_to_console($_COOKIE['age']);
//    echo json_decode($_COOKIE['age']);


    try {
        $mpdf = new \Mpdf\Mpdf(['debug' => true]);
        $mpdf->WriteHTML("<p>" . $_COOKIE['refresh'] . "</p>");

        $mpdf->WriteHTML("<p>" . $_COOKIE['age'] . "</p>");
        //first segment
        $mpdf->WriteHTML("<p><b>Resource Type</b> : " . $_COOKIE['resource'] .
            "<b>&emsp;&emsp;&emsp; Business Name</b> : " . $_COOKIE['office'] .
            "<b>&emsp;&emsp;&emsp;  Website</b> : " . $_COOKIE['website'] .
            "<b>&emsp;&emsp;&emsp;  Provider Name</b> : " . $_COOKIE['providerName'] . "</p>");


        //Second segment
        $mpdf->WriteHTML("<p><b>Email</b> : " . $_COOKIE['officeEmail'] .
            "<b>&emsp;&emsp;&emsp;  Phone</b> : " . $_COOKIE['officePhone'] .
            "<b>&emsp;&emsp;&emsp;  County</b> : " . $_COOKIE['county'] .
            "<b>&emsp;&emsp;&emsp;  Provider Gender</b> : " . $_COOKIE['providerGender'] . "</p>");

        //Third segment
        $mpdf->WriteHTML("<p><b>&emsp;&emsp;&emsp;  Address</b> : " . $_COOKIE['address'] .
            "<b>&emsp;&emsp;&emsp;  Ages Seen</b> : " . $_COOKIE['agesSeen'] .
            "<b>&emsp;&emsp;&emsp;  Credentials</b> : " . $_COOKIE['credentials'] . "</p>");

// Other code
        $mpdf->Output();
    } catch
    (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
        // Process the exception, log, print etc.
        echo $e->getMessage();
    }


    setcookie("age", "", time() - 3600);


}


if ($ready) {
//    header('Location: ' . $_SERVER['REQUEST_URI']);

//    echo "window.addEventListener('DOMContentLoaded',function(event){location.reload();});";

} else {
    echo "NOOO";
}

/* JS resonse on click to be printed example
resourceID: "8", speciality: "Therapy", office: "test2", officeEmail: "testone@testtwo.com", officePhone: "4444444222"
Referral_email: "samanthadesmul@yahoo.com"
Referral_fname: "Samantha Desmul"
Referral_lname: "Ref Name"
Referral_phone: "5555555555"
Resource_ServiceType: "Therapy"
Resource_status: "Accepted"
address: "test333 33 st"
age: null
city: "test3city"
countyOne: "County"
countyThree: null
countyTwo: null
fee: ""
insurance: ""
interpreter: ""
office: "test2"
officeEmail: "testone@testtwo.com"
officePhone: "4444444222"
resourceID: "8"
speciality: "Therapy"
state: "WA"
theraFname: "testtherfnamonettete"
theraGender: ""
theraLname: "testherlnamonetttt"
website: ""
zip: "33333"

*/


//function debug_to_console($data)
//{
//    $output = $data;
//    if (is_array($output))
//        $output = implode(',', $output);
//
//    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
//}
