<div class="reports view">
<h2><?php echo __('Report'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($report['Report']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wallet'); ?></dt>
		<dd>
			<?php echo $this->Html->link($report['Wallet']['name'], array('controller' => 'wallets', 'action' => 'view', $report['Wallet']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Month'); ?></dt>
		<dd>
			<?php echo h($report['Report']['month']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Openning Balance'); ?></dt>
		<dd>
			<?php echo h($report['Report']['openning_balance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ending Balance'); ?></dt>
		<dd>
			<?php echo h($report['Report']['ending_balance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Net Income'); ?></dt>
		<dd>
			<?php echo h($report['Report']['net_income']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expense'); ?></dt>
		<dd>
			<?php echo h($report['Report']['expense']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Income'); ?></dt>
		<dd>
			<?php echo h($report['Report']['income']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Report'), array('action' => 'edit', $report['Report']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Report'), array('action' => 'delete', $report['Report']['id']), array(), __('Are you sure you want to delete # %s?', $report['Report']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Reports'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Report'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Wallets'), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wallet'), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
	</ul>
</div>
