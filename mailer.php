<?php
/* Set e-mail recipient */
$myemail = "ryan@euroglazeadelaide.com.au";
$myemail_alt = "admin@euroglazeadelaide.com.au";

/* Check all form inputs using check_input function */
$firstname = check_input($_POST['firstname'], "Enter your first name");
$lastname = check_input($_POST['lastname'], "Enter your last name");
$phone = check_input($_POST['phone'], "Enter a phone number");
$email = check_input($_POST['email']);
$street = check_input($_POST['street'], "Enter a street address");
$suburb = check_input($_POST['suburb'], "Enter a suburb");
$postcode = check_input($_POST['postcode'], "Enter a postcode");
$message = check_input($_POST['message'], "Write your message");
$contact_method_phone = check_input($_POST['contact_method_phone']);
$contact_method_email = check_input($_POST['contact_method_email']);

if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
    echo '<h2>Please check the the captcha form.</h2>';
    exit;
}
$secretKey = "6LdGvDYUAAAAAAb9JzmlFDlacwfJ_CjsH36uZY7c";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);
if(intval($responseKeys["success"]) !== 1) {
    echo '<h2>Sorry, something went wrong. Click back and try again.</h2>';
}

/* If e-mail is not valid show error message */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
    show_error("E-mail address not valid");
}
/* Let's prepare the message for the e-mail */
$message = "

    First Name: $firstname
    Last Name: $lastname
    E-mail: $email
    Phone: $phone
    Street: $street
    Suburb: $suburb
    Postcode: $postcode
    Contact Method: $contact_method_phone $contact_method_email

    Message:
    $message

    ";

/* Send the message using mail() function */
mail($myemail, "Euro Glaze Adelaide - Contact us", $message);
mail($myemail_alt, "Euro Glaze Adelaide - Contact us", $message);

/* Redirect visitor to the thank you page */
header('Location: thanks.html');
exit();

/* Functions we used */
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    /*if ($problem)
    {
        show_error($problem);
    }*/
    return $data;
}

function show_error($myError)
{
?>
<html>
<body>

<p>Please correct the following error:</p>
<strong><?php echo $myError; ?></strong>
<p>Hit the back button and try again</p>

</body>
</html>
<?php
    exit();
}
?>
