<?php
//creates the session in the browser, created using lynda.com tutoria; that can be found at:
//http://www.lynda.com/MySQL-tutorials/Creating-login-system/119003/137056-4.html
	session_start();
	
	function message() {
		if (isset($_SESSION["message"])) {
			$output = "<div class=\"message\">";
			$output .= htmlentities($_SESSION["message"]);
			$output .= "</div>";
			
			// clear message after use
			$_SESSION["message"] = null;
			
			return $output;
		}
	}

	function errors() {
		if (isset($_SESSION["errors"])) {
			$errors = $_SESSION["errors"];
			
			// clear message after use
			$_SESSION["errors"] = null;
			
			return $errors;
		}
	}
	
?>