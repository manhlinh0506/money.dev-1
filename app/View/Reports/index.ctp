<div class="reports index">
	<h2><?php echo __('Reports'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('wallet_id'); ?></th>
			<th><?php echo $this->Paginator->sort('month'); ?></th>
			<th><?php echo $this->Paginator->sort('openning_balance'); ?></th>
			<th><?php echo $this->Paginator->sort('ending_balance'); ?></th>
			<th><?php echo $this->Paginator->sort('net_income'); ?></th>
			<th><?php echo $this->Paginator->sort('expense'); ?></th>
			<th><?php echo $this->Paginator->sort('income'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($reports as $report): ?>
	<tr>
		<td><?php echo h($report['Report']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($report['Wallet']['name'], array('controller' => 'wallets', 'action' => 'view', $report['Wallet']['id'])); ?>
		</td>
		<td><?php echo h($report['Report']['month']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['openning_balance']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['ending_balance']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['net_income']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['expense']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['income']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $report['Report']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $report['Report']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $report['Report']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $report['Report']['id']))); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Report'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Wallets'), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wallet'), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
	</ul>
</div>
