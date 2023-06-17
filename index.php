<?php
include("includes/header.php");
?>

<div class="wrapper">
	
	<div class="content cv-align-contents">
		<div class="card" id="login">
			<h1>Login</h1>
			<form method="post" action="processLogin.php">
				<div class="fieldgroup">
					<label>Email</label>
					<input type="text" name="strEmail" placeholder="Enter your Email"/>
				</div>

				<div class="fieldgroup">
					<label>Password</label>
					<input type="password" name="strPassword" placeholder="Enter your Password" />
				</div>

				<div class="fieldgroup">
					<input type="submit" value="Login" class="btn-primary" />
				</div>
			</form>

			<p>Need an account? <strong><a href="register.php">Register</a></strong></p>
		</div>	
	</div>  <!-- end of contents -->

	

</div> <!-- end of wrapper -->




</body>
</html>