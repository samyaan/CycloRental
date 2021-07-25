
<html>
	<head>
		<title>
			Transaction Page
		</title>
		<link rel="stylesheet" href="css/book2.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/book2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<style>
    body, html {
      height: 100%;
      font-family: "Inconsolata", sans-serif;
    }
    
    .bgimg {
      background-position: center;
      background-size: cover;
      background-image: url("/w3images/coffeehouse.jpg");
      min-height: 75%;
    }
    
    .menu {
      display: none;
    }
    .button {
  padding: 15px 25px;
  font-size: 24px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  background-color: #04AA6D;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;
}

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
table {
  border-radius: 10px;
  float: left;
  width: 70%;
  height: 80px;

  margin-left: 15%;
  margin-right: 15%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s; 
  background-color: white;
}
h3 {
  text-align: center;
}

table:hover {
  box-shadow: 0 8px 16px 0 rgba(19, 4, 4, 0.2);
}

td {
  padding: 15px;
  margin: auto;
  width: 50%;
  text-align: center;
}

#tags {
  align-content: center;
  text-decoration: none;
}


    </style>
	</head>
	<body >
	<nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">Pink-Pedals</label>
      <ul>
        <li><a  href="index.html">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Feedback</a></li>
      </ul>
    </nav>
    <center>
    <br><br><br><br><br><br>
		<br><br><br>
              <button class="button"><span><a href="index.html">Go Back To Home Page</a> </span></button></center>
              <br><br></center>
	<?php
if (isset($_POST['Email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "yuvrajomc@gmail.com";
    $email_subject = "Contact for Support";

    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $subject = $_POST['subject']; // required
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br>';
    }

    if (strlen($subject) < 2) {
        $error_message .= 'The Subject you entered do not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Contact Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "name: " . clean_string($name) . "\n";
    $email_message .= "email: " . clean_string($email) . "\n";
    $email_message .= "subject: " . clean_string($subject) . "\n";
    $email_message .= "message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- include your success message below -->

    Thank you for contacting us. We will be in touch with you very soon.

<?php
}
?>


	</body>
</html>