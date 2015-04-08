<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
    <fieldset>
        <legend><?php echo __('Edit Category'); ?></legend>
	<?php
		echo $this->Form->input('id', array('name'=>'id'));
		echo $this->Form->input('name', array('name'=>'name'));
		echo $this->Form->input('wallet_id', array('name'=>'wallet_id'));
		echo $this->Form->input('typename_id', array('name'=>'typename_id'));
                echo $this->Form->label('Use specials type:');
                if($this->request->data('Category')['special_id'] == null) {
                    echo $this->Form->checkbox('published', 
                        array('name'=>'published','id'=>'check', 
                            'onchange'=>'checkCheckbox()','checked'=>''));
                        echo $this->Form->input('special_id', 
                            array('name'=>'special_id','id'=>'special_id','label'=>false,'style'=>'display:none'));
                } else {
                        echo $this->Form->checkbox('published', 
                        array('name'=>'published','id'=>'check', 
                            'onchange'=>'checkCheckbox()','checked'=>'checked'));
                        echo $this->Form->input('special_id', 
                        array('name'=>'special_id','id'=>'special_id','label'=>false));
                }
                
	?>
    </fieldset>
    <script>
        function checkCheckbox() {
            var check = document.getElementById('check');
            if (check.checked == true) {
                document.getElementById('special_id').style.display = 'block';
            } else {
                document.getElementById('special_id').style.display = 'none';
            }
        }
    </script>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

