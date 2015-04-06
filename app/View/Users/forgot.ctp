<div class="users form">
<?php echo $this->Form->create('User',array('controller' => 'users', 'action' => 'forgot')); ?>
	<fieldset>
                <?php echo $this->Session->flash(); ?>
		<legend><?php echo __('Forgot password'); ?></legend>
	<?php
		echo $this->Form->input('username', array('label' => 'Email','name'=>'username'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Send')); ?>
</div>

