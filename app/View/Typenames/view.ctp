<div class="typenames view">
<h2><?php echo __('Typename'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($typename['Typename']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Typename'); ?></dt>
		<dd>
			<?php echo h($typename['Typename']['typename']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Typename'), array('action' => 'edit', $typename['Typename']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Typename'), array('action' => 'delete', $typename['Typename']['id']), array(), __('Are you sure you want to delete # %s?', $typename['Typename']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Typenames'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Typename'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Categories'); ?></h3>
	<?php if (!empty($typename['Category'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Delete Flag'); ?></th>
		<th><?php echo __('Wallet Id'); ?></th>
		<th><?php echo __('Typename Id'); ?></th>
		<th><?php echo __('Special Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($typename['Category'] as $category): ?>
		<tr>
			<td><?php echo $category['id']; ?></td>
			<td><?php echo $category['name']; ?></td>
			<td><?php echo $category['created']; ?></td>
			<td><?php echo $category['modified']; ?></td>
			<td><?php echo $category['delete_flag']; ?></td>
			<td><?php echo $category['wallet_id']; ?></td>
			<td><?php echo $category['typename_id']; ?></td>
			<td><?php echo $category['special_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'categories', 'action' => 'view', $category['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'categories', 'action' => 'edit', $category['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'categories', 'action' => 'delete', $category['id']), array(), __('Are you sure you want to delete # %s?', $category['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
