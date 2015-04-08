<div class="wallets form">
<?php echo $this->Form->create('Wallet'); ?>
    <fieldset>
        <legend><?php echo __('Transfer money'); ?></legend>
	<?php
                echo __('From:   ');
                echo $this->request->data('Wallet')['name'];
                echo $this->Form->input('To', array(
                                                    'type' => 'select',
                                                    'options'=>$wallets,
                                                    'empty'=>false,
                                                    )
                                                );
		echo $this->Form->input('balance', array('name'=>'balance'));
	?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>