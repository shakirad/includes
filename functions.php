<?php
ob_start();
//created using lynda.com tutorial that can be found at: http://www.lynda.com/MySQL-tutorials/Creating-login-system/119003/137056-4.html
function redirect_to($new_location) {
header("Location: " . $new_location);
exit;
	}

//escapes strings posted to database in new_admin.php
function mysql_prep($string) {
		global $conn;
		
		$escaped_string = mysqli_real_escape_string($conn, $string);
		return $escaped_string;
	}
	

//If the result set is empty display 'database query failed error'	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

//Form errors and validation
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	
	/*function find_admin_by_username($username) {
		global $conn;
		
		$safe_username = mysqli_real_escape_string($conn, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM user ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($conn, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}*/

/*Edited the above function to log in using an email address Instead of the display name as I feel
this is more user friendly*/
	function find_admin_by_email($email) {
		global $conn;
		
		$safe_email = mysqli_real_escape_string($conn, $email);
		
		$query  = "SELECT * ";
		$query .= "FROM user ";
		$query .= "WHERE email = '{$safe_email}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($conn, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	//Salts the password. I decided to implement the less complicated version shown in the tutorial. 

	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = "Salt22CharactersOrMore";
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
	  return $hash;
	}
	
	
	//Checks the password entered in login.php matches the one in the db
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	//Attempts the log in by finding email and password and checking them against the entered values
	function attempt_login($email, $password) {
		$admin = find_admin_by_email($email);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}

	//when logged in return session values so they can be used elsewhere within the document. 
	//E.g. echoed out under the comments & on user dash
	function logged_in() {
		return isset($_SESSION['admin_id']);
		return isset($_SESSION['username']);
	}
	
	//if not logged in then redirect to the log in page. 
	//For pages that can only be seen by users that are logged in like the user dash.
	function confirm_logged_in() {
		if (!logged_in()) {
		redirect_to('login.php');	
		}
	}

	?>
