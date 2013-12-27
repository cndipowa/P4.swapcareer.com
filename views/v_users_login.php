<h2>Log In</h2>

<?php if(isset($success)): ?>
    	<div class='error'>
            <p>	<?php echo $success?> </p>
    	</div>
    	<br>
 <?php endif; ?>
        
<form method="POST" action="/users/p_login">
    <table>
      
        <tr><td>Email</td> <td><input type="text" name="email" required><br></td></tr>
      <tr><td>Password </td><td><input type="password" name="password" required><br></td></tr>
    
      <tr><td><input type="Submit" value="Log in"><br></td></tr>
    </table>
</form>
