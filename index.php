<?php
/**
 * Created by PhpStorm.
 * User: samantha
 * Date: 2019-10-04
 * Time: 15:09
 */

// Start session!
session_start();

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');
require_once('model/validation.php');
require_once('model/officeValidation.php');
require_once('model/thereapistValidation.php');

//create an instance of the Base class/ fat free object
$f3 = Base::instance();

// Set days array
$f3->set('day', array('Sunday', 'Monday', 'Tuesday', 'Wednesday',
    'Thursday', 'Friday', 'Saturday'));

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// arrays of age
$f3->set('age', array('0-4', '5-9', '10-12', '13-17', '18+'));

//Define a default root, there can be multiple routes

//homepage
$f3->route('GET /', function () {
    //display the contents of the page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render("views/homePage.html");
    echo $view->render('views/includes/footer.html');
});

$f3->route('GET /home', function () {
    session_destroy();

    //display the contents of the page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render("views/homePage.html");
    echo $view->render('views/includes/footer.html');
});

$f3->route('GET /resources', function ($f3) {

    //display the contents of the page
    $view = new Template();
    $f3->set('title', "Resources");

    echo $view->render('views/includes/header.html');
    echo $view->render("views/resources.html");
    echo $view->render('views/includes/footer.html');
});

/*
 * Clickable row route
 */
$f3->route('GET /resources/service/@type', function ($f3) {

    //display the contents of the page
    $view = new Template();
    $f3->set('title', 'Service');
    $f3->set('resource', $f3->get('PARAMS.type'));
    echo $view->render('views/includes/header.html');
    echo $view->render("views/serviceResource.html");
    echo $view->render('views/includes/footer.html');
});

// personal contact info form route
$f3->route('GET|POST /recommended', function ($f3) {
    //If form has been submitted, validate
    if (!empty($_POST)) {
        // Get data from form
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Add data to hive
        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('email', $email);
        $f3->set('phone', $phone);

        // if data is valid
        if (validForm()) {
            // Write data to session
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;

            // redirect to confirmation
            $f3->reroute('/provider');
        }
    }

    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render('views/recommendedForm.html');
    echo $view->render('views/includes/footer.html');
});

// office information form route
$f3->route('GET|POST /provider', function ($f3) {
    //If form has been submitted, validate
    if (!empty($_POST)) {

        // Get data from form
        $category = $_POST['category'];
        $office = $_POST['office'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $office_phone = $_POST['office_phone'];
        $office_email = $_POST['office_email'];
        $website = $_POST['website'];
        $comments = $_POST['comments'];

        // Add data to hive
        $f3->set('category', $category);
        $f3->set('office', $office);
        $f3->set('address', $address);
        $f3->set('city', $city);
        $f3->set('state', $state);
        $f3->set('zip', $zip);
        $f3->set('office_phone', $office_phone);
        $f3->set('office_email', $office_email);
        $f3->set('website', $website);
        $f3->set('comments', $comments);

        // if data is valid
        if (validOfficeForm()) {
            // Write data to session
            $_SESSION['category'] = $category;
            $_SESSION['office'] = $office;
            $_SESSION['address'] = $address;
            $_SESSION['city'] = $city;
            $_SESSION['state'] = $state;
            $_SESSION['zip'] = $zip;
            $_SESSION['office_phone'] = $office_phone;
            $_SESSION['office_email'] = $office_email;
            $_SESSION['website'] = $website;
            $_SESSION['comments'] = $comments;

            // redirect to confirmation
            $f3->reroute('/therapist');
        }
    }

    //display the office form of the page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render("views/officeForm.html");
    echo $view->render('views/includes/footer.html');
});

// therapist form route
$f3->route('GET|POST /therapist', function ($f3) {
    //If form has been submitted, validate
    if (!empty($_POST)) {
        // Get data from form
        $theraFname = $_POST['theraLname'];
        $theraLname = $_POST['theraLname'];
        $theraEmail = $_POST['theraEmail'];
        $theraPhone = $_POST['theraPhone'];
        $theraGender = $_POST['theraGender'];

        // Add data to hive
        $f3->set('theraFname', $theraFname);
        $f3->set('theraLname', $theraLname);
        $f3->set('theraEmail', $theraEmail);
        $f3->set('theraPhone', $theraPhone);
        $f3->set('theraGender', $theraGender);

        // if data is valid
        if (validTherapist()) {
            // Write data to session
            $_SESSION['theraFname'] = $theraFname;
            $_SESSION['theraLname'] = $theraLname;
            $_SESSION['theraEmail'] = $theraEmail;
            $_SESSION['theraPhone'] = $theraPhone;
            $_SESSION['theraGender'] = $theraGender;

            // redirect to confirmation
            $f3->reroute('/optionalInfo');
        }
    }

    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render('views/therapistForm.html');
    echo $view->render('views/includes/footer.html');
});

// optional information route
$f3->route('GET|POST /optionalInfo', function ($f3) {

    //If form has been submitted, validate
    if (!empty($_POST)) {
        // Get data from form
        $age = $_POST['age'];
        $interpreter = $_POST['interpreter'];
        $insurance = $_POST['insurance'];
        $fee = $_POST['fee'];

        // Add data to hive
        $f3->set('age', $age);
        $f3->set('interpreter', $interpreter);
        $f3->set('insurance', $insurance);
        $f3->set('fee', $fee);

        // if data is valid
        if (!empty($_POST)) {
            // Write data to session
            $_SESSION['age'] = $age;
            $_SESSION['interpreter'] = $interpreter;
            $_SESSION['insurance'] = $insurance;
            $_SESSION['fee'] = $fee;

            if (empty($age)) {
                $_SESSION['age'] = "No age selected";
            } else {
                $_SESSION['age'] = implode(', ', $age);
            }


            // redirect to confirmation
            $f3->reroute('/dayHour');
        }
    }
    //display the confirmation of the page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render("views/optionalForm.html");
    echo $view->render('views/includes/footer.html');
});



// day and hour information route
$f3->route('GET|POST /dayHour', function ($f3) {

    //If form has been submitted, validate
    if (!empty($_POST)) {
        // Get data from form
        $days = $_POST['days'];
        $_SESSION['days'] = $days;

        if(!empty($days)) {
            // loop through and check which days are checked
            foreach($_SESSION['days'] as $day) {
                if (isset($day)) {
                    // Add data to hive and set session for time
                    $_SESSION[$day.'FromTime'] = date('h:i A', strtotime($_POST[$day.'FromTime']));
                    $f3->set($day.'FromTime', $_POST[$day.'FromTime']);

                    $_SESSION[$day.'ToTime'] = date('h:i A', strtotime($_POST[$day.'ToTime']));
                    $f3->set($day.'ToTime', $_POST[$day.'ToTime']);
                }
            }
        }

        $countyOne = $_POST['countyOne'];
        $countyTwo = $_POST['countyTwo'];
        $countyThree = $_POST['countyThree'];

        // Add data to hive
        $f3->set('countyOne', $countyOne);
        $f3->set('countyTwo', $countyTwo);
        $f3->set('countyThree', $countyThree);

        // if data is valid
        if (!empty($_POST)) {
            // Write data to session
            $_SESSION['countyOne'] = $countyOne;
            $_SESSION['countyTwo'] = $countyTwo;
            $_SESSION['countyThree'] = $countyThree;

            // redirect to confirmation
            $f3->reroute('/confirmation');
        }
    }


    //display the day and hour of the page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render("views/dayHourForm.html");
    echo $view->render('views/includes/footer.html');
});



// Confirmation route
$f3->route('GET|POST /confirmation', function ($f3) {
    if(empty($_SESSION['days'])) {
        foreach($f3->get('day') as $day) {
            $_SESSION[$day.'NoTime'] = 'No time selected';
        }
    }
    else {
        foreach($_SESSION['days'] as $day) {
            foreach($f3->get('day') as $value) {
                if($day != $value) {
                    $_SESSION[$value.'NoTime'] = 'No time selected';
                }
            }
        }
    }


    //display the confirmation of the page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render("views/confirmation.html");
    echo $view->render('views/includes/footer.html');
});

//Admin to be able to view recommended resource listings to update listings Status
$f3->route('GET|POST /admin', function ($f3) {
    //display the admin page
    $view = new Template();
    echo $view->render('views/includes/header.html');
    echo $view->render('views/adminView.html');
    echo $view->render('views/includes/footer.html');
});

//run Fat-free
$f3->run();