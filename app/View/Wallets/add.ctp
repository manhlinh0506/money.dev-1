<div class="wallets form">
<?php echo $this->Form->create('Wallet'); ?>
	<fieldset>
		<legend><?php echo __('Add Wallet'); ?></legend>
	<?php
		echo $this->Form->input('name', array('name'=>'name'));
		echo $this->Form->input('currency_id', array('name'=>'currency_id'));
		echo $this->Form->input('balance', array('name'=>'balance'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>