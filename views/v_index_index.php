<?php if($user): ?>
<h3>Hello <?=$user->firstname; 
?></h3> <img src = "<?='/'.$user->imagepath;?>" alt="Smiley face" width="80" height="80">
<?php else:?>

<h3>Please sign up or login, thanks.</h3>

 <!--If errors - display message-->
    <?php if(isset($loginError)): ?>
    	<div class='error'>
    		<p> Login failed! Please check your credentials and try again.</p>
    	</div>
    	<br>
    <?php endif; ?>

<?php endif; ?>

<h2>Additional Notes</h2>
<ol>
<li>This app allows users to log in and follow persons of their choosing.</li>
<li>You can only see the posts of persons you choose to follow.</li>
<li>Profile management is implemented and users can freely change avatars. </li>
<li>The table sorter was intentionally used not as a display tool  but to give users the ability to quickly sort site users based on table heading parameters if there are too many users. </li>
<li>Validations of various types are also implemented across the app.</li>
<li>Time of last update of the site implemented in the footer. </li>
</ol>  
