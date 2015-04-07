<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username', array('label' => 'Email'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Register')); ?>
</div>

