<div class="currencies view">
<h2><?php echo __('Currency'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($currency['Currency']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($currency['Currency']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Currency'), array('action' => 'edit', $currency['Currency']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Currency'), array('action' => 'delete', $currency['Currency']['id']), array(), __('Are you sure you want to delete # %s?', $currency['Currency']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Currencies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Currency'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Wallets'), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wallet'), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Wallets'); ?></h3>
	<?php if (!empty($currency['Wallet'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Currency Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Balance'); ?></th>
		<th><?php echo __('Delete Flag'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($currency['Wallet'] as $wallet): ?>
		<tr>
			<td><?php echo $wallet['id']; ?></td>
			<td><?php echo $wallet['name']; ?></td>
			<td><?php echo $wallet['currency_id']; ?></td>
			<td><?php echo $wallet['created']; ?></td>
			<td><?php echo $wallet['modified']; ?></td>
			<td><?php echo $wallet['user_id']; ?></td>
			<td><?php echo $wallet['balance']; ?></td>
			<td><?php echo $wallet['delete_flag']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'wallets', 'action' => 'view', $wallet['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'wallets', 'action' => 'edit', $wallet['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'wallets', 'action' => 'delete', $wallet['id']), array(), __('Are you sure you want to delete # %s?', $wallet['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Wallet'), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
