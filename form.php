<!DOCTYPE html>
<html>
<head>
<!--COMMENT FORM-->
<title> Comment prototype </title> 
<!--JQUERY that makes the comment box expans as the user types. Added for better UX. -->
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'></script>
		<script src='../js/jquery.autosize.js'></script>
		<script>
			$(function(){
				$('.normal').autosize();
				$('.animated').autosize();
			});
		</script>
</head>

<body>

<form id="form" action="formsend.php" method="post">
<!--Uses the formsend.php in the pages folder to send the article to the database-->

<div id="discussion">Start a new thread:</div>

 <textarea name='comment' class='animated'></textarea><br />

<input type='hidden' name='articleid' id='articleid' value='<?php echo $_GET["id"]; ?>' />
 <input type='submit' name='submitted' value='Post comment' />  
</form>


</body>

</html>