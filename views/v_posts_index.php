</br>
<?php if(isset($successMsg)): ?>
    	<div class='error'>
            <p>	<?php echo $successMsg?> </p>
    	</div>
    	<br>
 <?php endif; ?>
<?php if(isset($posts)): ?>
      
    <?php foreach ($posts as $post): ?>
    <div><img src = "<?='/'.$post['imagepath']?>" alt="Smiley face" width="80" height="80"><strong><?=$post['firstname']?></strong> <strong><?=$post['lastname']?></strong><br></div>
    <?=$post['content']?> <br><br>
    <?php endforeach;?>
    
<?php endif; ?>
