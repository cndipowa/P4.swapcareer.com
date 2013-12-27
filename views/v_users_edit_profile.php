<h3>Edit the profile of <?= $user->firstname ?> </h3>
<br><br>
<h4>Name: <?= $user->firstname ?> <?= $user->lastname ?></h4>
<br />
<h4>Tell us about yourself : </h4>

<?php $form->open($name = 'form', $action = '/users/p_edit_profile/', $html = NULL, $method = 'post'); ?>

	<?=$form->textarea('bio'); ?><br />
	
	<input type='submit'>

</form>

<br /><br />
	
<img src = "<?='/'.$user->imagepath;?>" class="avatar" alt="<?= $user->firstname ?>">
	