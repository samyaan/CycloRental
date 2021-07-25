<?php include('server2.php');
$total_price = 0;

$q1 = 0;
$q2 = 0;
$q3 = 0;
$q4 = 0;
$pass = 0;

if (isset($_POST['quant1'])) {
    $q1 = $_POST['quant1'];
    $pass = $q1;
}
if (isset($_POST['quant2'])) {
    $q2 = $_POST['quant2'];
    $pass = $q2;
}
if (isset($_POST['quant3'])) {
    $q3 = $_POST['quant3'];
    $pass = $q3;
}
if (isset($_POST['quant4'])) {
    $q4 = $_POST['quant4'];
    $pass = $q4;
}
if ($q1 != 0) {
    if ($q1 <= 5) {
        $total_price = 1300 * $q1;
        $_SESSION['total_price2'] = $total_price;
    } elseif ($q1 > 5 && $q1 <= 10) {
        $total_price = 1100 * $q1;
        $_SESSION['total_price2'] = $total_price;
    }
}

if ($q2 != 0) {
    if ($q2 <= 5) {
        $total_price = 1500 * $q2;
        $_SESSION['total_price2'] = $total_price;
    } elseif ($q2 > 5 && $q2 <= 10) {
        $total_price = 1300 * $q2;
        $_SESSION['total_price2'] = $total_price;
    }
}


if ($q3 != 0) {
    if ($q3 <= 5) {
        $total_price = 1500 * $q3;
        $_SESSION['total_price2'] = $total_price;
    } elseif ($q3 > 5 && $q3 <= 10) {
        $total_price = 1300 * $q3;
        $_SESSION['total_price2'] = $total_price;
    }
}

if ($q4 != 0) {
    if ($q4 <= 5) {
        $total_price = 4000 * $q4;
        $_SESSION['total_price2'] = $total_price;
    } elseif ($q4 > 5 && $q4 <= 10) {
        $total_price = 3500 * $q4;
        $_SESSION['total_price2'] = $total_price;
    }
}

?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>
        Booking Details
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="form_wrapper" id="register_form">
        <div class="form_container">
            <div class="title_container">
                <h2>Registration Form</h2>
            </div>
            <div class="row clearfix">
                <div class="">
                    <form method="POST" action="register2.php">
                        <?php include('errors.php'); ?>
                        <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                            <input type="email" name="email" placeholder="Email" required />
                        </div>
                        <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
                            <input type="text" name="phone" placeholder="Mobile Number" required />
                        </div>
                        <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
                            <input type="text" name="phone2" placeholder="Alternate Mobile Number" />
                        </div>
                        <h4>Select Tour Date</h4>

                        <div class="input_field">
                            <input type="date" name="date" placeholder="Tour Date" required style="width: 98%;" />
                        </div>

                        <?php
                        if ($q1 != 0) {
                            echo '<h4>Number of Tourist in the Selected Pink Aura Tour Package:</h4>
                            <div class="input_field">
                            <input type="text" name="pinkaura" value="' . $q1 . '" required readonly />
                            </div>';
                        }
                        ?>

                        <?php
                        if ($q2 != 0) {
                            echo ' <h4>Number of Tourist in the Selected Heritage Classics Tour Package :</h4>
                            <div class="input_field">
                                <input type="text" name="heritage" value="' . $q2 . '" required readonly />
                            </div>';
                        }
                        ?>

                        <?php
                        if ($q3 != 0) {
                            echo '<h4>Number of Tourist in the SelectedPink Leagacy Tour Package :</h4>
                            <div class="input_field">
                                <input type="text" name="pinkleagacy" value="' . $q3 . '" required readonly />
                            </div>';
                        }
                        ?>

                        <?php
                        if ($q4 != 0) {
                            echo '<h4>Number of Tourist in the Selected OhMyJaipur Tour Package:</h4>
                            <div class="input_field">
                                <input type="text" name="ohmyjaipur" value="' . $q4 . '" required readonly />
                            </div>';
                        }
                        ?>


                        <h4>Personal Details</h4>
                        <h4>Head</h4>
                        <div class="row clearfix">
                            <div class="col_half">
                                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                    <input type="text" name="fname" placeholder="First Name" />
                                </div>
                            </div>
                            <div class="col_half">
                                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                    <input type="text" name="lname" placeholder="Last Name" required />
                                </div>
                            </div>
                        </div>
                        <div class="input_field">
                            <textarea style="width: 100%;" name="address" placeholder="Addresss"></textarea>

                        </div>
                        <div class="input_field radio_option">
                            <input type="radio" name="radiogroup" id="rd12" value="Male">
                            <label for="rd12">Male</label>
                            <input type="radio" name="radiogroup" id="rd13" value="Female">
                            <label for="rd13">Female</label>
                        </div>
                        <div class="input_field">
                            <input type="number" name="age" placeholder="Age" required style="width: 98%;" min="0" />
                        </div>
                        <?php

                        for ($i = 0; $i < $pass - 1; $i++) {
                            echo 'Co -Tourist: ' . $i + 1;
                            echo '<div class="row clearfix">
                            <div class="col_half">
                                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                    <input type="text" name="pfname' . $i . '" placeholder=" Name" required />
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="input_field radio_option">
                        <input type="radio" name="radiogroup' . $i . '" id="rd' . $i . '" value="Male">
                        <label for="rd' . $i . '">Male</label>
                        <input type="radio" name="radiogroup' . $i . '" id="rd11' . $i . '" value="Female">
                        <label for="rd11' . $i . '">Female</label>
                      </div>                      
                      <div class="input_field">
                      <input type="number" name="age' . $i . '" placeholder="Age" required style="width: 98%;"  min="0" required/>
                  </div>
                      
                      ';
                        }

                        ?>

                        <div class="input_field radio_option">
                            <h4>Select ID</h4>
                            <input type="radio" name="radiogroupgg" id="rd3" value="Voter ID">
                            <label for="rd3">Voter ID</label>
                            <input type="radio" name="radiogroupgg" id="rd4" value="Aadhar Number">
                            <label for="rd4">Aadhar Number</label>
                            <input type="radio" name="radiogroupgg" id="rd5" value="Driving License">
                            <label for="rd5">Driving License</label>
                        </div>
                        <div class="input_field"> <span><i aria-hidden="true" class="fa fa-id-card"></i></span>
                            <input type="text" name="id_card" placeholder="Id Number" required />
                        </div>

                        <div class="input_field checkbox_option">
                            <input type="checkbox" id="cb1" required>
                           <label for="cb1">I agree with <a href="#terms" data-toggle="modal" data-target="#terms" onClick="show()">Terms and Conditions</a></label>
                        </div>
                        <div class="input_field">
                            <label>Total Price to be Paid</label>
                            <input type="text" name="amt" id="amt" value="Rs. <?php echo $total_price; ?>" readonly>
                        </div>

                        <input class="button" type="submit" name="reg_user" value="Register Yourself" onclick="change()" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <p class="credit">&copy; The Bike rent Private Ltd.</p>

<!-- Modal -->
            <div class="modal fade" id="terms" tabindex="-1" role="dialog" style= "margin: 0 80px 60px 80px;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Terms & Condition</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list">
                                    <li>Mandatory Security deposit for every booking:- Any original Photo Address Proof or 1000 Rs.  Will be returned once the cycles are handed over.
                                    </li>
                                    <li>Photo Address Proof  means Original proof of address and identity. (No photocopies will be accepted)</li>
                                    <li>Min fix rental should be paid in advance.</li>
                                    <li>
                                        <h6>RESPONSIBILITY FOR DAMAGE OR LOSS:-</h6>
                                        We expect that Customer agrees to the fact that he/she will return the cycle and other equipments rented in the same good condition as when received, and to repair and replace, lost or stolen, damaged or broken cycles or parts to reimburse Bike Rent for said equipment. Hence regardless of the party at fault, customer agrees and understands his responsibility  for the theft or damage to said cycle and other equipments given on rent.
                                    </li>
                                    <li>
                                        <h6>No SUB-LEASING ALLOWED:-</h6>
                                        Customer understands and agrees that any subleasing of rental equipments from us is prohibited and if customer found subleasing then it will immediately cause termination and cancellation of this contract and other legal action will be held.

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>