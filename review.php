<?php

session_start();	
?>
<h2>Confirm your informations</h2>
<table>
	<tbody>
		<tr>
			<td>Name:
			<td><?php echo $lastName." ".$firstName ?>
		</tr>
		<tr>
			<td>Email:
			<td><?php echo $email ?>
		</tr>
		<tr>
			<td>Your payment:
			<td>$<?php echo $_SESSION["Payment_Amount"] ?>
		</tr>
	<tbody>
</table>
<form action='order.php' METHOD='POST'>
<input type="submit" value="Review"/>
</form>
