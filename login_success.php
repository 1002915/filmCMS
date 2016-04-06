<?php session_start();

if(!isset($_SESSION['email'])){

	$_SESSION['email']="email";

    header("location:index.php");
}

else{

   $email=$_SESSION['email'];

include('index.php');

} 

?>
<div class="block" style="background-color:#<?php echo $row["bgcolour"];?>">
	<div class="title" style="color:#<?php echo $row["textcolour"];?>"><?php echo $row["title"]; ?></div>
	<div class="bodytext" style="color:#<?php echo $row["textcolour"];?>"><?php echo $row["body"]; ?></div>	
		<form name="editbutton" method="post" action="edit.php">
			<input type="hidden" name="edit" value="<?php echo $row["id"];?>">
			<input type="submit" name="submit" value="edit">
		</form>
		<form name="deletebutton" method="post" action="delete.php">
			<input type="hidden" name="delete" value="<?php echo $row["id"];?>">
			<input type="submit" name="deletebutton" value="DELETE">
		</form>
</div>
		
</div>
<?php mysqli_close($connection);?>

<h1 style="color:<?php echo $pageData[2];?>"> 
<P style="color:<?php echo $pageData[2];?>">
<body style="background-color:<?php echo $pageData[3];?>">	