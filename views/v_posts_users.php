</br></br><table id="myTable" class="tablesorter" width="200"> 
<thead> 
    <tr> 
    <th>First Name</th> 
    <th>Last Name</th> 
    <th>Follow/Unfollow</th> 
    </tr> 
</thead> 
<tbody> 
<?php foreach ($users as $user): ?>

<tr><td><img src="<?="/".$user['imagepath']?>" alt="Smiley face" width="80" height="80"><?=$user['firstname']?> </td><td><?=$user['lastname']?></td>

<?php if (isset($connections[$user['user_id']])):?>

<td><a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a></td></tr>
        
<?php else:?>

<td><a href='/posts/follow/<?=$user['user_id']?>'>Follow</a></td></tr>

<?php endif;?>

<?php endforeach;?>

</tbody> 
</table> 

