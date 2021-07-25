<?php
session_start();
$dur1;
$dur2;
$dur3;
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
	switch ($_GET["action"]) {
		case "add":
			if (!empty($_POST["quantity"])) {
				$productByCode = $db_handle->runQuery("SELECT * FROM cycle_rental WHERE id='" . $_GET["id"] . "'");
				$itemArray = array($productByCode[0]["id"] => array('name' => $productByCode[0]["name"], 'id' => $productByCode[0]["id"], 'quantity' => $_POST["quantity"], 'amount' => $productByCode[0]["amount"], 'amount2' => $productByCode[0]["amount2"], 'amount3' => $productByCode[0]["amount3"], 'img' => $productByCode[0]["img"],  'link' => $productByCode[0]["link"]));

				if (!empty($_SESSION["cart_item"])) {
					if (in_array($productByCode[0]["id"], array_keys($_SESSION["cart_item"]))) {
						foreach ($_SESSION["cart_item"] as $k => $v) {
							if ($productByCode[0]["id"] == $k) {
								if (empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}
			break;
		case "remove":
			if (!empty($_SESSION["cart_item"])) {
				foreach ($_SESSION["cart_item"] as $k => $v) {
					if ($_GET["id"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if (empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
				}
			}
			break;
		case "empty":
			unset($_SESSION["cart_item"]);
			break;
	}
}
?>

<html>

<head>
	<meta charset="utf-8">
	<TITLE>Rentals Selection</TITLE>
	<link href="style.css" type="text/css" rel="stylesheet" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="book.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		table {
			border-radius: 10px;
			float: left;
			width: 70%;
			height: 80px;
			margin-top: 20px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
			transition: 0.3s;
			margin-bottom: 40px;
			background-color: white;

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
			
		 	label.logo{
			padding: 10px;
		}

		#tags {
			align-content: center;
			text-decoration: none;
		}
		.btn{
  background-color:#ff75a0;
  border: 0px;
}
.btn:hover{
background-color: white;
color: #ff75a0;
box-shadow: 
0 8px 16px 0 rgba(0,0,0,0.2);
border: 0px;
}
.thumbnail{
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
}
.thumbnail:hover {
  box-shadow: 
0 8px 16px 0 rgba(0,0,0,0.2);
}
.select {

  grid-template-areas: "select";
}

select,
.select:after {
  grid-area: select;
}
	</style>

</head>


<body style="background-image: none;">
	<nav style="width: 100%;">
		<input type="checkbox" id="check">
		<label for="check" class="checkbtn">
			<i class="fas fa-bars"></i>
		</label>
		<label class="logo"><img src="Images/Cycle Rental-3.png" alt="" style="width:auto; height:60px; display:inline-flexbox;"></label>
		<ul>
		<li><a  href="index.html">Home</a></li>
		  <li><a href="book.html">Book Now</a></li>
        <li><a href="gallery.html">Gallery</a></li>
        <li><a href="index.html#contact">Contact</a></li>
        <li><a class="call-section" href="tel:+917229942277"><i class="fa fa-phone"></i>&nbsp +91-7229942277</a></li>
		</ul>
	</nav>
	<div class="slider">
		<div class="Modern-Slider content-section" id="top">
			<!-- Item -->
			<div class="item item-1">
				<div class="img-fill">
					<div class="image"></div>
					<div class="info">
						<div>
							<img src="img/renew.jpg" width="100%" height="80%" id="slid-mage">
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
	</script>

	<script src="js/vendor/bootstrap.min.js"></script>

	<script src="js/plugins.js"></script>





	<div id="shopping-cart">
		<div class="txt-heading">
			<p><Strong>**</Strong>Please Select cycle for only One Duration. Multiple Duration Booking will not be Entertained.</p>
		</div>

		<a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
		<?php
		if (isset($_SESSION["cart_item"])) {
			$total_quantity = 0;
			$total_price = 0;
			$security = 1000;


			if (isset($_POST['duration'])) {
				echo "Selected Duration:" . $_SESSION['duration'];
			}

		?>
			<table class="tbl-cart" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<th style="text-align:left;">Name</th>

						<th style="text-align:left;">Code</th>
						<th style="text-align:left;">Duration</th>
						<th style="text-align:right;" width="5%">Quantity</th>
						<th style="text-align:right;" width="10%">Unit Price</th>
						<th style="text-align:right;" width="10%">Price</th>
						<th style="text-align:center;" width="5%">Remove</th>
					</tr>
					<?php

					foreach ($_SESSION["cart_item"] as $item) {

						if (isset($_SESSION["duration"])) {
							if ($_SESSION['duration'] == 'Weekly' || $_SESSION['duration'] == '2 Days') {
								$item_price = $item["quantity"] * $item["amount"];
							} elseif ($_SESSION['duration'] == '15 Days' || $_SESSION['duration'] == '3 Days') {
								$item_price = $item["quantity"] * $item["amount2"];
							} elseif ($_SESSION['duration'] == 'Monthly') {
								$item_price = $item["quantity"] * $item["amount3"];
							}
						}
					?>
						<tr>
							<td><?php echo $item["name"]; ?></td>
							<td><?php echo $item["id"]; ?></td>
							<td></td>
							<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
							<?php
							if (isset($_SESSION["duration"])) {
								if ($_SESSION['duration'] == 'Weekly' || $_SESSION['duration'] == '2 Days') {
									echo "<td style='text-align:right;'> Rs" . $item['amount'] . "</td>";
								} elseif ($_SESSION['duration'] == '15 Days' || $_SESSION['duration'] == '3 Days') {
									echo "<td style='text-align:right;'> Rs" . $item['amount2'] . "</td>";
								} elseif ($_SESSION['duration'] == 'Monthly') {
									echo "<td style='text-align:right;'> Rs" . $item['amount3'] . "</td>";
								}
							}

							?>
							<td style="text-align:right;"><?php echo "Rs " . number_format($item_price, 2); ?></td>
							<td style="text-align:center;"><a href="index.php?action=remove&id=<?php echo $item["id"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
						</tr>
					<?php
						$total_quantity += $item["quantity"];
						if (isset($_SESSION["duration"])) {
							if ($_SESSION['duration'] == 'Weekly' || $_SESSION['duration'] == '2 Days') {
								$total_price += ($item["amount"] * $item["quantity"]);
							} elseif ($_SESSION['duration'] == '15 Days' || $_SESSION['duration'] == '3 Days') {
								$total_price += ($item["amount2"] * $item["quantity"]);
							} elseif ($_SESSION['duration'] == 'Monthly') {
								$total_price += ($item["amount3"] * $item["quantity"]);
							}
						}
					}
					?>
					<tr>
						<form method="post" action="index.php">
							<td>Delivery Charges</td>
							<td>
								<div class="custom-select">
									<select name="addr" style="width: 40%;" class="select">
									<option value="Self Pickup Jawahar Circle">--|Select|--</option>
										<option value="Self Pickup Jawahar Circle">Self Pickup Jawahar Circle</option>
										<option value="Vaishali Nagar">Vaishali Nagar</option>
										<option value="Vidhyadhar Nagar"> Vidhyadhar Nagar</option>
										<option value="Nemi Nagar">Nemi Nagar</option>
										<option value="Chitrakoot"> Chitrakoot</option>
										<option value="Jothwara">Jothwara</option>
										<option value="Railway station">Railway station</option>
										<option value="Gurjar Ki Thadi">Gurjar Ki Thadi</option>
										<option value="Sodala">Sodala</option>
										<option value="22 Godam"> 22 Godam</option>
										<option value="C-Scheme"> C-Scheme</option>
										<option value="Raja Park">Raja Park</option>
										<option value="Adarsh Nagar">Adarsh Nagar</option>
										<option value="Aatish Market"> Aatish Market</option>
										<option value="Ridhi Sidhi"> Ridhi Sidhi</option>
										<option value="Jagatpura">Jagatpura</option>
										<option value="Mansarovar">Mansarovar</option>
										<option value="Pratap Nagar"> Pratap Nagar</option>
										<option value="Mahaveer Nagar">Mahaveer Nagar</option>
										<option value="Gopalpura"> Gopalpura</option>
										<option value="Tonk Phatak"> Tonk Phatak</option>
										<option value="Mahesh Nagar">Mahesh Nagar</option>
										<option value="Malviya Nagar">Malviya Nagar</option>


									</select>
									<input type="submit" value="Select Address" class="btnAddAction btn" style="width: auto;" />
								</div>
							</td>
							<td>

							</td>
							<td></td>
						</form>
						<?php
						if (isset($_POST['addr'])) {
							$_SESSION['addrg'] = $_POST['addr'];
						} else {
							$_SESSION['addrg'] = 1;
						}
						?>
						<?php
						$pay = 0;
						if (isset($_SESSION['duration'])) {

							if ($_SESSION['duration'] == '2 Days' || $_SESSION['duration'] == '3 Days') {
								if (isset($_POST['addr'])) {
									if ($_POST['addr'] == 'Self Pickup Jawahar Circle') {
										$pay = 0;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									} elseif ($_POST['addr'] == 'Vaishali Nagar' || $_POST['addr'] == 'Vidhyadhar Nagar' || $_POST['addr'] == 'Nemi Nagar' || $_POST['addr'] == 'Chitrakoot' || $_POST['addr'] == 'Jothwara' || $_POST['addr'] == 'Railway station') {
										$pay = 700;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									} elseif ($_POST['addr'] == 'Gurjar Ki Thadi' || $_POST['addr'] == 'Sodala'  || $_POST['addr'] ==  '22 Godam'  || $_POST['addr'] == 'C-Scheme' || $_POST['addr'] == 'Raja Park' || $_POST['addr'] == 'Adarsh Nagar' || $_POST['addr'] == 'Aatish Market' || $_POST['addr'] == 'Ridhi Sidhi' || $_POST['addr'] == 'Jagatpura' || $_POST['addr'] == 'Mansarovar' || $_POST['addr'] == 'Pratap Nagar') {
										$pay = 550;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									} elseif ($_POST['addr'] == 'Mahaveer Nagar' || $_POST['addr'] == 'Gopalpura' || $_POST['addr'] == 'Tonk Phatak' || $_POST['addr'] == 'Mahesh Nagar' || $_POST['addr'] == 'Malviya Nagar') {
										$pay = 350;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									}
								}
							} else {
								if (isset($_POST['addr'])) {
									if ($_POST['addr'] == 'Self Pickup Jawahar Circle') {
										$pay = 0;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									} elseif ($_POST['addr'] == 'Vaishali Nagar' || $_POST['addr'] == 'Vidhyadhar Nagar' || $_POST['addr'] == 'Nemi Nagar' || $_POST['addr'] == 'Chitrakoot' || $_POST['addr'] == 'Jothwara' || $_POST['addr'] == 'Railway station') {
										$pay = 350;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									} elseif ($_POST['addr'] == 'Gurjar Ki Thadi' || $_POST['addr'] == 'Sodala'  || $_POST['addr'] ==  '22 Godam'  || $_POST['addr'] == 'C-Scheme' || $_POST['addr'] == 'Raja Park' || $_POST['addr'] == 'Adarsh Nagar' || $_POST['addr'] == 'Aatish Market' || $_POST['addr'] == 'Ridhi Sidhi' || $_POST['addr'] == 'Jagatpura' || $_POST['addr'] == 'Mansarovar' || $_POST['addr'] == 'Pratap Nagar') {
										$pay = 250;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									} elseif ($_POST['addr'] == 'Mahaveer Nagar' || $_POST['addr'] == 'Gopalpura' || $_POST['addr'] == 'Tonk Phatak' || $_POST['addr'] == 'Mahesh Nagar' || $_POST['addr'] == 'Malviya Nagar') {
										$pay = 150;
										echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
									}
								}
							}
						}



						?>
						<td style="text-align:right;"><?php echo "Rs " . number_format($pay, 2); ?></td>
						<td style="text-align:center;"></td>
					</tr>
					<tr>
						<td>Selected Address:</td>
						<td><?php
							if (isset($_POST['addr']))
								echo $_POST['addr'];
							else
								echo "Self Pickup Jawahar Circle";
							?>
						</td>
						<td></td>
						<td></td>
						<td style="text-align:right;"></td>
						<td style="text-align:center;"></td>
						<td></td>
					</tr>
					<tr>
						<td>Security Deposit</td>
						<td></td>
						<td></td>
						<td></td>
						<?php
						echo "<td style='text-align:right;'> Rs" . $security . "</td>";
						?>

						<td style="text-align:right;"><?php echo "Rs " . number_format($security, 2); ?></td>
						<td style="text-align:center;"></td>

					</tr>
					<?php


					$total_price += $pay;
					?>

					<tr>
						<td colspan="2" align="right">Total:</td>
						<td></td>
						<td align="right"><?php echo $total_quantity; ?></td>

						<?php
						$total_price += $security;
						?>
						<td align="right" colspan="2"><strong><?php echo "Rs " . number_format($total_price, 2); ?></strong></td>
						<td></td>
						<?php $_SESSION['total_price'] = $total_price; ?>

					</tr>
					<form action="register.php" method="POST">
						<tr>
							<td colspan="2" align="right"></td>
							<td align="right">
								<center>
									<input type="submit" value="Book Now!" class="btn" />
								</center>
							</td>

							<td align=" right" colspan="2"></td>
							<td></td>
						</tr>

					</form>
				</tbody>
			</table>
			<?php $_SESSION['total_price'] = $total_price; ?>
			<br><br>

		<?php
		} else {
		?>
			<div class="no-records">Your Cart is Empty</div>
		<?php
		}
		?>
	</div>


	<form method="post" action="index.php">

		<br><br>
		<div id="product-grid-2" style="margin: 20px;">
			<div class="txt-heading">Duration</div>

			<div class="product-item">

				<div class="custom-select" style="border: 0px;">
					<select name="duration" style="border: 0px;" class="select">

						<option value="Select Duration">Select Duration</option>
						<option value="2 Days">2 Days</option>
						<option value="3 Days">3 Days</option>
						<option value="Weekly">Weekly</option>
						<option value="15 Days">15 Days</option>
						<option value="Monthly">Monthly</option>
					</select>

					<input type="submit" value="Search Bicycles" style="width: auto;" class="btnAddAction btn" />

				</div>


			</div>

		</div>
	</form>
	<br>
	<br><br>
	<div id="product-grid">
		<div class="txt-heading">Cycle Available</div>
		<?php

		if (isset($_POST['duration'])) {
			$_SESSION['duration'] = $_POST['duration'];
			if ($_POST['duration'] == 'Select Duration') {
				echo "Select Duration<br>";
			} elseif ($_POST['duration'] == '2 Days') {
				echo "Selected Duration : 2 Days<br>";
				$dur = '2 Days';
			} elseif ($_POST['duration'] == '3 Days') {
				echo "Selected Duration : 3 Days<br>";
				$dur = '3 Days';
			} elseif ($_POST['duration'] == 'Weekly') {
				echo "Selected Duration : Weekly<br>";
				$dur = 'Weekly';
			} elseif ($_POST['duration'] == '15 Days') {
				echo "Selected Duration : 15 Days<br>";
				$dur = '15 Days';
			} elseif ($_POST['duration'] == 'Monthly') {
				echo "Selected Duration : Monthly<br>";
				$dur = 'Monthly';
			}
		}
		$num = '';
		if (isset($_POST['duration']))
			$num = $_POST['duration'];
		if ($num && $num != 'Select Duration') {

			$query1 = "SELECT * FROM cycle_rental ORDER BY id ASC";
			$query2 = "SELECT * FROM cycle_rental Where id!=3";
			$query3 = "SELECT * FROM cycle_rental Where id=3";

			if ($num == 'Select Duration') {
				$product_array = $db_handle->runQuery($query1);
			} elseif ($num == '2 Days' || $num == '3 Days') {
				$product_array = $db_handle->runQuery($query3);
			} else {
				$product_array = $db_handle->runQuery($query2);
			}

			if (!empty($product_array)) {
				foreach ($product_array as $key => $value) {
		?>
		</div>
					<div class="product-item thumbnail" >
						<form method="post" action="index.php?action=add&id=<?php echo $product_array[$key]["id"]; ?>">
							<div class="product-image"><img src="<?php echo $product_array[$key]["img"]; ?>" style="width: 250px; height: 150px;"></div>
							<div class="product-tile-footer">
								<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
								<div class="product-title"><a href="<?php echo $product_array[$key]["link"]; ?>">
										Details </a></div>

								<?php
								if (isset($_SESSION["duration"])) {
									if ($_SESSION['duration'] == 'Weekly' || $_SESSION['duration'] == '2 Days') {
										echo "Rs" . $product_array[$key]["amount"];
									} elseif ($_SESSION['duration'] == '15 Days' || $_SESSION['duration'] == '3 Days') {
										echo "Rs" . $product_array[$key]["amount2"];
									} elseif ($_SESSION['duration'] == 'Monthly') {
										echo "Rs" . $product_array[$key]["amount3"];
									}
								}
								?>
							</div>
							<div class="cart-action"><input type="number" class="product-quantity" name="quantity" value="1" size="2" min="1" max="8" /><input type="submit" value="Add to Cart" class="btnAddAction btn" /></div>
					</div>
					</form>
	
<?php
				}
			}
		}
?>


</div>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<script>
	var myDate = new Date();
	var hrs = myDate.getHours();

	var greet;


	if ((hrs >= 19 && hrs <= 24) || (hrs >= 0 && hrs <= 8)) {
		greet = 'Hello customer!';
		document.getElementById('product-grid').innerHTML =
			'<b>' + greet + '</b> The booking currently closed now!, Booking will Resume from 8 A.M.';
	}
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootshape.js"></script>
</BODY>

</html>