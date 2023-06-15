<?php
include("includes/header.php");
?>


<div class="wrapper">

	<div class="content cv-align-contents">
		<div class="card" id="login">
			<h1>New Users</h1>
			<p>Complete the register today and find you match</p>
			<form method="post" action="processRegistration.php">
				<div class="fieldgroup">
					<label>Email</label>
					<input type="text" name="strEmail" placeholder="Enter your Email" />
				</div> <!-- end of  fieldgroup -->

				<div class="fieldgroup">
					<label>Password</label>
					<input type="password" name="strPassword" placeholder="Enter your Password" />
				</div> <!-- end of  fieldgroup -->

				<div class="fieldgroup">
					<label>Your Country!</label>
					<input class="magicInput" data-tbl="countries" name="strLocation" placeholder="Search..">
					<div class=" magicList"></div>
				</div><!-- end of  fieldgroup -->


				<div class="fieldgroup">
					<input type="submit" value="Register" class="btn-primary" />

				</div> <!-- end of  fieldgroup -->
			</form>

			<p>Have an account? <strong><a href="index.php">Login Now</a></strong></p>
		</div>
	</div>  <!-- end of contents --> 

</div> <!-- end of wrapper -->

</body>

</html>