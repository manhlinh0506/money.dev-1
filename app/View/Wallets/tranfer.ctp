<div class="wallets form">
<?php echo $this->Form->create('Wallet'); ?>
	<fieldset>
		<legend><?php echo __('Tranfer money'); ?></legend>
	<?php
                echo __('From:');
                echo $this->Form->input('wallet_name', array(
                                                    'type' => 'select',
'options'=>$wallets,
'empty'=>false,
                    )
                );
                echo $this->Form->input('currency_id', array('name'=>'currency_id'));
		echo $this->Form->input('balance', array('name'=>'balance'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>