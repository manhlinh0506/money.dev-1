<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
    <fieldset>
        <legend><?php echo __('Edit Transaction'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('name'=>'name'));
		echo $this->Form->input('transaction_value',array('transaction_value'=>'transaction_value'));
		echo $this->Form->input('category_id',array('name'=>'category_id','id'=>'category_id'));
        ?>
        <div class='input' id ='checkbox' <?php if(!(count($trans)>0)): ?> style='display:none' <?php endif; ?>>
            <label id = 'return' for="return" >Return/pay:</label>
        <?php echo $this->Form->checkbox('published', array('name'=>'published',
                    'id'=>'check', 'onchange'=>'checkCheckbox()','checked'=>'')); ?>
        </div>
        <?php
		echo $this->Form->input('date_of_execution');
	?>
    </fieldset>
<?php echo $this->Form->end(__('Change')); ?>
</div>
