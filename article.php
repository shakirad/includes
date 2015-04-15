<?php
//This page get's the article info from the database. 

 
//ARTICLES
//old SQL below
//$sql = "SELECT * FROM article WHERE idarticle ='$id'";

//Inner join used to get the profile picture from the user table too. 
//pulling the article from the database if the ID in the URL matches. 
$sql = "SELECT * FROM article LEFT JOIN user on article.user_userid = user.userid WHERE idarticle ='$id'";

$result = $conn->query($sql);


//Converts the numbers stored intp the databse into an image. 
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {

		$rating=$row["rating"];

		if($rating==5){
			$converted ='<img class="rating" src="../pages/images/5stars.png" alt=""/>';
		}
		elseif($rating==4){
			$converted ='<img class="rating" src="../pages/images/4stars.png" alt=""/>';
		}
		elseif ($rating==3) {
			$converted ='<img class="rating" src="../pages/images/3stars.png" alt=""/>';
		}
		elseif ($rating==2) {
			$converted ='<img class="rating" src="../pages/images/2stars.png" alt=""/>';
		}

		elseif ($rating==1){
			$converted ='<img class="rating" src="../pages/images/1star.png" alt=""/>';
		}

		//Echoing out the main body of the article. 
        echo 
		"<section class='main'>

		<h1>".$row["headline"]. "</h1>
		<div id='articledata'>" . 

		$row["datePosted"] . "<br />". $converted. 
		"</div> <div class='tint'> <img src='".$row["image"]."' alt=''/></div>".
		$row["content"] . 

		"<div id='enddata'>
			<span id='author'> Author: " . $row["username"]. "</span> 
			<span id='rate'> Rate this article <img id='emptyrating' src='../pages/images/rating.png' alt=''/> </span>
		 	<div id='discuss'><span id='discusstext'> Discuss with </span> <img class='discuss_icon facebook' src='../pages/images/facebook.png' alt=''/>
		 	<img class='discuss_icon twitter' src='../pages/images/twitter.png' alt=''/>
		 	</div>
		 </div>



		</section>".


		//Echoing out the sidebar, profile pic, top comment (which is currently static) tags etc. 
		"<section id='aside'> 

		<div id='author'>
		<img src='".$row["profilepic"]."'/><span>"
		.$row["username"].
		"</span><img id='favourite' src='../pages/images/1star.png' alt=''/></div>

		  <div id='topComment'>
                <h3>Top comment</h3>

                <img src='../pages/images/commentavatar.jpg'/>
                <div class='stats'>
                    <span class='author'>Commenter</span>
                    <div class='votes'><span class='upvoteno'>75</span><img class='upvote' src='../pages/images/upvote.png' alt=''/></div>
                    <span class='date'>3d ago</span>
                 </div>   
            
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus
                 accumsan et viverra justo commodo. Proin sodales pulvinar tempor. 
                 Cum sociis natoque penatibus et magnis dis parturient montes, nascetur 
                 ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis 
                 tellus mollis orci, sed rhoncus sapien nunc eget odio.</p>
            <span class='thread'><a href='#'>View thread</a></span>

        </div>";

        //SQL query to get all the sources where the article ID matches. 
        //It then loops through and echoes each one out. 
        $sqlsource = "SELECT link FROM sources WHERE sources.article_idarticle = '$id'";

		echo "<div id='tags'> 
		<h4> References: </h4>";

		$sourceresult = mysqli_query($conn, $sqlsource) or die(mysql_error());
		
			while($row = mysqli_fetch_array($sourceresult)) {
				
				echo "<div class='reference'>
						<a href='". $row["link"] ."'>" . $row["link"] . "</a>
						<span class='cite'>Cite</span>
					</div>";
		
			}

		echo "<h4> Tags: </h4>";

		// SQL query joining the tag nromalisation table onto the tag table and gets the tag name where the article ID matches. 
		$sqltag="SELECT * FROM tag_article_match LEFT JOIN tag on tag_article_match.tag_idtag = tag.idtag WHERE tag_article_match.article_idarticle = '$id'";

		$tagresult = mysqli_query($conn, $sqltag) or die(mysql_error());
		
			while($row = mysqli_fetch_array($tagresult)) {
				
				echo "<span class='tag'>" . $row["tag_name"] . "</span>";
			
			}

		echo "</div>

		</section>";
				

		
		//SQL query getting the discussion points. 
		$sqldiscussion = "SELECT discussion_point FROM discussion_points WHERE  discussion_points.article_idarticle = '$id'";

		echo "<section class='main'><h4>Join the conversation</h4>
		<h5> Discussion Points:</h5> <ul>";

		$discussionresult = mysqli_query($conn, $sqldiscussion) or die(mysql_error());
		
			while($row = mysqli_fetch_array($discussionresult)) {

		echo
		
			"<li>". $row["discussion_point"] ."</li>"; }

		echo "</ul>";

		//COMMENT FORM
		include('../includes/form.php');
		//Included the form underneath the article. Then whole lot is included in the index. 
		echo "</section> ";
    }

	}
	else {
	echo "Whoops, I don't exist yet.";
	}

//COMMENT RESULTS
//SQL order by ensures the latest comment is always at the top. 
$commenti = "SELECT * FROM comment LEFT JOIN user on comment.user_userid = user.userid WHERE article_idarticle = '$id' ORDER BY date DESC, time DESC";
$results = $conn->query($commenti);
	//Selecting the comments from the database where the ID in the URL matches. 
	while($rowi = $results->fetch_assoc()) {
        echo "<div class='comments'><span class='date'>" . $rowi["date"]. "</span><span class='time'>".
        $rowi["time"]."</span><span class='username'>".
		$rowi["username"]."</span><p class='content'>".
		$rowi["content"] ."</p>

		<a href='#'>Reply</a>

		</div>"
		;

	
    }



?>