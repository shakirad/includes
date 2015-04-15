<?php
//OLD NOT USED, THIS PIECE OF SCRIPT CAN NOW BE FOUND AT THE BOTTOM OF ARTICLE.PHP
$commenti = "SELECT * FROM comment WHERE article_idarticle = '$id' ORDER BY time DESC";
$results = $conn->query($commenti);


	while($rowi = $results->fetch_assoc()) {
        echo "<div>".
		$rowi["date"]. " ". $rowi["time"]. "<br>".
		$rowi["user_username"]. "<br>".
		$rowi["content"]. "<br>".
		"</div>";
		
		
    }


?>