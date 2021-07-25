<?php
session_start();

$tabul = "package1";
// variable declaration
$username = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";
$database = 'pink_pedals';
// connect to database
$db = mysqli_connect('localhost', 'root', '', 'pink_pedals');


// REGISTER USER
if (isset($_POST['reg_user'])) {
	// receive all input values from the form

	$email = mysqli_real_escape_string($db, $_POST['email']);
	$fname = mysqli_real_escape_string($db, $_POST['fname']);
	$lname = mysqli_real_escape_string($db, $_POST['lname']);
	$phone = mysqli_real_escape_string($db, $_POST['phone']);
	$phone2 = mysqli_real_escape_string($db, $_POST['phone2']);
	$address = mysqli_real_escape_string($db, $_POST['address']);
	$delivery_address = mysqli_real_escape_string($db, $_POST['addrg']);
	$gender = mysqli_real_escape_string($db, $_POST['radiogroup1']);
	$id_type = mysqli_real_escape_string($db, $_POST['radiogroup2']);
	$id_num = mysqli_real_escape_string($db, $_POST['id_card']);
	$duration = mysqli_real_escape_string($db, $_POST['duration']);
	$ngear = mysqli_real_escape_string($db, $_POST['ngear']);
	$gear = mysqli_real_escape_string($db, $_POST['gear']);
	$tandem = mysqli_real_escape_string($db, $_POST['tandem']);

	// form validation: ensure that the form is correctly filled
	if (empty($fname)) {
		array_push($errors, "First Name is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($lname)) {
		array_push($errors, "Last Name is required");
	}
	if (empty($phone)) {
		array_push($errors, "Phone Number is required");
	}
	if (empty($gender)) {
		array_push($errors, "Gender is required");
	}
	if (empty($address)) {
		array_push($errors, "Address is required");
	}
	if (empty($id_num)) {
		array_push($errors, "ID Card Number is required");
	}
	if (empty($phone2)) {
		array_push($errors, "Alternate Number is required");
	}
	if (empty($id_type)) {
		array_push($errors, "Id Type is required");
	}


	function aadharValidation($aadharNumber) {
		/*...multiplication table...*/
		$multiplicationTable = [
			[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
			[1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
			[2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
			[3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
			[4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
			[5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
			[6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
			[7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
			[8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
			[9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
		];
		/*...permutation table...*/
		$permutationTable = [
			[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
			[1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
			[5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
			[8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
			[9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
			[4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
			[2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
			[7, 0, 4, 6, 9, 1, 3, 2, 5, 8],
		];
		/*...split aadhar number...*/
		$aadharNumberArr = str_split($aadharNumber);
		/*...check length of aadhar number...*/
		if (count($aadharNumberArr) == 12) {
			/*...reverse aadhar number...*/
			$aadharNumberArrRev = array_reverse($aadharNumberArr);
			$tableIndex         = 0;
			/*...validate...*/
			foreach ($aadharNumberArrRev as $aadharNumberArrKey => $aadharNumberDetail) {
				$tableIndex = $multiplicationTable[$tableIndex][$permutationTable[($aadharNumberArrKey % 8)][$aadharNumberDetail]];
			}
			return ($tableIndex === 0);
		}
		return false;
	}

	function validate_phone_number($phone_numz)
    {
      
         $filtered_phone_number = filter_var($phone_numz, FILTER_SANITIZE_NUMBER_INT);
       
         $phone_to_check = str_replace("-", "", $filtered_phone_number);
         
         if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
         } else {
           return true;
         }
    }

    if($phone!=''){
        $validit2= validate_phone_number($phone);
        if($validit2!=true){
            array_push($errors, "Incorrect Phone Number Format!");
        }
        }

	function validating($driving){

		if(preg_match('/^(([A-Z]{2}[0-9]{2})( )|([A-Z]{2}-[0-9]{2}))((19|20)[0-9][0-9])[0-9]{7}$/', $driving)) {
		
		return true;
		
		}else{
		
		return false;
		
		}
		
		}



	if($id_type=='Aadhar Number'){
	$validit= aadharValidation($id_num);
	if($validit!=true){
		array_push($errors, "Incorrect Aadhar Number Format!");
	}
	}
	elseif($id_type=='Driving License'){
		$validit= validating($id_num);
		if($validit!=true){
			array_push($errors, "Incorrect Driving License Number Format!");
		}
		}

	// register user if there are no errors in the form
	if (count($errors) == 0) {

		$query = "INSERT INTO package1 (Fname, Lname, phone, Address, gender, email, alternate_num, id_type, id_num, delivery_addr ,duration, nongear, gear, tandem) 
					  VALUES('$fname','$lname','$phone', '$address', '$gender', '$email', '$phone2', '$id_type', '$id_num', '$delivery_address', '$duration', '$ngear', '$gear', '$tandem' )";
		mysqli_query($db, $query);





		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You are now logged in";
		$_SESSION['tble_name'] = $tabul;
		$_SESSION['last_id'] = $lastid;
		header('location: register2payment.php');
	}
}
