<div class="categories view">
<h2><?php echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($category['Category']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($category['Category']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delete Flag'); ?></dt>
		<dd>
			<?php echo h($category['Category']['delete_flag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wallet'); ?></dt>
		<dd>
			<?php echo $this->Html->link($category['Wallet']['name'], array('controller' => 'wallets', 'action' => 'view', $category['Wallet']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Typename'); ?></dt>
		<dd>
			<?php echo $this->Html->link($category['Typename']['id'], array('controller' => 'typenames', 'action' => 'view', $category['Typename']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Special'); ?></dt>
		<dd>
			<?php echo $this->Html->link($category['Special']['name'], array('controller' => 'specials', 'action' => 'view', $category['Special']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), array(), __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Wallets'), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wallet'), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specials'), array('controller' => 'specials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Special'), array('controller' => 'specials', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Transactions'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Transactions'); ?></h3>
	<?php if (!empty($category['Transaction'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Transaction Value'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Delete Flag'); ?></th>
		<th><?php echo __('Date Of Execution'); ?></th>
		<th><?php echo __('Parent Transaction'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($category['Transaction'] as $transaction): ?>
		<tr>
			<td><?php echo $transaction['id']; ?></td>
			<td><?php echo $transaction['name']; ?></td>
			<td><?php echo $transaction['transaction_value']; ?></td>
			<td><?php echo $transaction['created']; ?></td>
			<td><?php echo $transaction['modified']; ?></td>
			<td><?php echo $transaction['category_id']; ?></td>
			<td><?php echo $transaction['delete_flag']; ?></td>
			<td><?php echo $transaction['date_of_execution']; ?></td>
			<td><?php echo $transaction['parent_transaction']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'transactions', 'action' => 'view', $transaction['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'transactions', 'action' => 'edit', $transaction['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'transactions', 'action' => 'delete', $transaction['id']), array(), __('Are you sure you want to delete # %s?', $transaction['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
