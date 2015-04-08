<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
		<legend><?php echo __('Add Transaction'); ?></legend>
	<?php
		echo $this->Form->input('name', array('name'=>'name'));
		echo $this->Form->input('transaction_value', array('name'=>'transaction_value'));
		echo $this->Form->input('category_id', array('name'=>'category_id','id'=>'category_id'));
		echo $this->Form->input('date_of_execution', array('name'=>'date_of_execution'));
	?>
                <script>
                    $(document).ready(function(){
                       $("#category_id").change(function(){
                          alert('gin'); 
                       });
                    });
                </script>
	</fieldset>
<?php echo $this->Form->end(__('Add')); ?>
</div>