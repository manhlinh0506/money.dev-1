<div class="transactions index">
	<h2><?php echo __('Transactions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
                        <th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('transaction_value'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('date_of_execution'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_transaction'); ?></th>
			<th class="actions text-center"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($transactions as $transaction): ?>
	<tr>
                <td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['name']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['transaction_value']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['modified']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Category']['name']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['date_of_execution']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['parent_transaction']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $transaction['Transaction']['id']))); ?>
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