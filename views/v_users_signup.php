<h2>Sign Up</h2>

<form method="POST" action="/users/p_signup" enctype="multipart/form-data">
    <table>
       
        <tr><td>First Name</td><td><input type="text" name="firstname" required><br></td></tr>
    <tr> <td>Last Name </td><td><input type="text" name="lastname" required><br></td></tr>
    <tr><td>Email      </td><td><input type="email" name="email" required><br></td></tr>
    <tr><td> Password   </td><td><input type="password" name="password" required><br><br></td></tr>
    
    
     <tr><td>Upload a picture:</td> <td><input type="file" name="file" required><br></td></tr>
    
     <tr><td>Submit</td><td><input type="submit" value="Sign Up"><br></td></tr>
    </table>
</form>
<br>
