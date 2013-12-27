<!--Upload avatar-->
<h3>Upload avatar of <?= $user->firstname ?> </h3>
<br><br>

<!--Upload files-->
<form method='POST' enctype="multipart/form-data" action='/users/p_upload_avatar/'>

	<input type='file' name='avatar'>
	<input type='submit'>

</form>