<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
    <fieldset>
        <legend><?php echo __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('name', array('name'=>'name'));
        ?>
        <div class='input select required'>
            <label>Wallet</label>
            <select name='wallet_id'>
                <?php foreach ($wallets as $key => $wallet): ?>
                <option <?php if($current_wallet[0]['users']['current_wallet'] == $key): ?>
                    selected <?php endif;?> value='<?php echo $key; ?>'><?php echo $wallet; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
		echo $this->Form->input('typename_id', array('name'=>'typename_id', 'id'=>'typename_id', 'onchange'=>'getSpecial_type()'));
                echo $this->Form->label('Use specials type:');
                echo $this->Form->checkbox('published', array('name'=>'published',
                    'id'=>'check', 'onchange'=>'checkCheckbox()','checked'=>'checked'));
		echo $this->Form->input('special_id', 
                        array('name'=>'special_id','id'=>'special_id','label'=>false));
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
        function getSpecial_type() {
            var typename_id = document.getElementById('typename_id');
            var type_value = typename_id.value;
            var special_id = document.getElementById('special_id');
            special_id.options.length = 0;
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('controller'=>'categories', 'action'=>'getSpecial')); ?>',
                data: {type: type_value},
                dataType: 'json',
                success: function(data) {
                                    var option = document.createElement('option');
                                    option.value = data['Special']['id'];
                                    option.text = data['Special']['name'];
                                    special_id.add(option);
                },
                error: function() {
                    alert('Error occurring. Please try again.');
                }
            });
        }
    </script>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
