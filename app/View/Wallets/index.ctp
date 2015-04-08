<div class="wallets index">
    <h2><?php echo __('Wallets'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('currency_id'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th><?php echo $this->Paginator->sort('balance'); ?></th>
                <th class="actions text-center"><?php echo __('Actions'); ?></th>
                <th><?php echo __('Current Wallet');?></th>
                <th><?php echo __('Transfer'); ?></th>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($wallets as $wallet): ?>
            <tr>
                <td><?php echo h($wallet['Wallet']['name']); ?>&nbsp;</td>
                <td>
                    <?php echo h($wallet['Currency']['name']); ?>&nbsp;
                </td>
                <td><?php echo h($wallet['Wallet']['created']); ?>&nbsp;</td>
                <td><?php echo h($wallet['Wallet']['balance']); ?>&nbsp;</td>
                <td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $wallet['Wallet']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $wallet['Wallet']['id']), 
                                array('confirm' => __('Are you sure you want to delete # %s?', $wallet['Wallet']['id']))); ?>
                </td>
                <td>
                    <?php if((($this->Session->read('Current_Wallet') != null) 
                                        && ($this->Session->read('Current_Wallet') == h($wallet['Wallet']['id']))) ){
                        echo __('Current Wallet');
                    } else {
                        echo $this->Html->link(__('Change wallet'), array('action' => 'changeWallet', $wallet['Wallet']['id'])); 
                    }
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(__('Tranfer'), array('action' => 'tranfer', $wallet['Wallet']['id'])); ?>
                </td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
    <div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
    </div>
</div>