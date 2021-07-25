<?php
$tabul = '';
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$db = mysqli_connect('localhost', 'root', '', 'pink_pedals');
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
?>

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
      <label class="logo"><a href="index.html"><img src="Images/Pink_Pedals Big.png" alt="" style="width:auto; height:50px; display:inline-flexbox;"></a></label>
     
	 
	  <ul>
        <li><a  href="index.html">Home</a></li>
        <li><a href="Booking/index.html">Book Now</a></li>
        <li><a href="index.html#contact">Contact</a></li>
        <li><a class="call-section" href="#"><i class="fa fa-phone"></i>&nbsp +91-7229942277</a></li>
      </ul>
    </nav>
	
	<?php
$TXNID = 0;
$ORDERID = '';
$date = '';
$mid = '';
$txnamount;
$mode = '';
$status = '';
$gateway_name = '';
$banktxnid = '';
$bankname = '';


$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if ($isValidChecksum == "TRUE") {
	//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	?>
	<center>
		<br><br><br>
	
		
		<br><br><br><br><br><br>
		<br><br><br>
              <button class="button"><span><a href="index.html">Go Back To Home Page</a> </span></button></center>
              <br><br>
			  <?php

	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<center><br><br><b>Transaction status is success</b>" . "</center><br/><br><br><br>";
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	
	} else {
		echo "<b>Transaction status is failure</b>" . "<br/>";
	}
	if (isset($_POST) && count($_POST) > 0) {
		foreach ($_POST as $paramName => $paramValue) {
		
			?>


	
<?php		

			if ($paramName == 'ORDERID') {
				$ORDERID = $paramValue;
			}
			if ($paramName == 'MID') {
				$mid = $paramValue;
			}
			if ($paramName == 'TXNID') {
				$TXNID = $paramValue;
			}
			if ($paramName == 'TXNAMOUNT') {
				$txnamount = $paramValue;
			}
			if ($paramName == 'PAYMENTMODE') {
				$mode = $paramValue;
			}
			if ($paramName == 'STATUS') {
				$status = $paramValue;
			}
			if ($paramName == 'BANKTXNID') {
				$banktxnid = $paramValue;
			}
			if ($paramName == 'BANKNAME') {
				$bankname = $paramValue;
			}
			if ($paramName == 'GATEWAYNAME') {
				$gateway_name = $paramValue;
			}
		}
	}
	?>
</table>
<?php
	
	
	if ($status == 'TXN_SUCCESS') {
		$query = "INSERT INTO payment_details (orderid, mid, txnid, txnamount, payment_mode, status, gatewayname, banktxnid, bankname) 
		VALUES('$ORDERID','$mid','$TXNID', '$txnamount', '$mode', '$status','$gateway_name', '$banktxnid', '$bankname')";

		$result = mysqli_query($db, $query);
		if ($result == false) {
			//printf("error: %s\n", mysqli_error($db));
		}
	}
} else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>

	</body>
</html>