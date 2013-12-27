
<h3>This is the profile of <?= $user->firstname ?> </h3>

<h4>Name: <?= $user->firstname ?> <?= $user->lastname ?></h4>
<i>Who joined us on: <?= Time::display($user->created) ?></i>

<?php if(!empty($user->bio)): ?>
	<div class="bio">
		<p><?= $user->bio ?></p>
	</div>
<?php endif; ?>

<br /><br />

<img src = "<?= '/'.$user->imagepath;?>" alt="<?= $user->firstname ?>" />

<br /><br />

<div class="Personprofile">
    <h3><a href='/users/upload_avatar'>Upload new photo</a> &nbsp&nbsp
        <a href='/users/edit_profile'>Edit your profile</a></h3>
</div>
	