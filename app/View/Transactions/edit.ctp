<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
    <fieldset>
        <legend><?php echo __('Edit Transaction'); ?></legend>
	<?php
		echo $this->Form->input('id', array('name'=>'id'));
		echo $this->Form->input('name',array('name'=>'name'));
		echo $this->Form->input('transaction_value',array('name'=>'transaction_value'));
		echo $this->Form->input('category_id',array('name'=>'category_id','id'=>'category_id'));
        ?>
        <div class='input' id ='checkbox' <?php if(!(count($trans)>0)): ?> style='display:none' <?php endif; ?>>
            <label id = 'return' for="return" >Return/pay:</label>
        <?php
        if($this->request->data('Transaction')['parent_transaction'] == null ||
                $this->request->data('Transaction')['parent_transaction'] == ''):
        echo $this->Form->checkbox('published', array('name'=>'published',
                'id'=>'check', 'onchange'=>'checkCheckbox()'));  
        else :
        echo $this->Form->checkbox('published', array('name'=>'published',
                'id'=>'check', 'onchange'=>'checkCheckbox()','checked'=>'checked'));
        endif; ?>
        </div>
        <div class='input' id ='special_id'  style=<?php if($this->request->data('Transaction')['parent_transaction'] == null ||
                $this->request->data('Transaction')['parent_transaction'] == '') :?>'display:none' <?php endif; ?>>
            <label id = 'label_loan' for="loan">For</label>
            <select id ='loan'   name ='loan'>
            <?php foreach ($trans as $tran): ?>
                <option <?php if($this->request->data('Transaction')['parent_transaction'] == $tran['id']): ?> selected="" <?php endif; ?> 
                    value="<?php echo $tran['id']; ?>" ><?php echo $tran['name']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <?php
		echo $this->Form->input('date_of_execution');
	?>
        <script>
            function checkCheckbox() {
                var check = document.getElementById('check');
                if (check.checked == true) {
                    document.getElementById('special_id').style.display = 'block';
                } else {
                    document.getElementById('special_id').style.display = 'none';
                }
            }
            $(document).ready(function () {
                $('#category_id').on('change', function () {
                    var check = document.getElementById('check');
                    var checkbox = document.getElementById('checkbox');
                    var special_id = document.getElementById('special_id');
                    var loan = document.getElementById('loan');
                    loan.options.length = 0;
                    var select_box = document.getElementById('category_id').value;
                    var id = <?php echo $this->request->data('Transaction')['id']; ?>;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->Html->url(array('controller'=>'transactions', 'action'=>'getcheckbox')); ?>',
                        data: {text: select_box, id: id},
                        dataType: 'json',
                        success: function (data) {
                            if (data != null && data != '') {
                                checkbox.style.display = 'block';
                                if (check.checked == true) {
                                    special_id.style.display = 'block';
                                }
                                for (var i = 0; i < data.length; i++) {
                                    var option = document.createElement('option');
                                    option.value = data[i]['transactions']['id'];
                                    option.text = data[i]['transactions']['name'];
                                    <?php if($this->request->data('Transaction')['parent_transaction'] != null && $this->request->data('Transaction')['parent_transaction'] != ''): ?>
                                    if(data[i]['transactions']['id'] == <?php echo $this->request->data('Transaction')['parent_transaction']; ?> ) {
                                        option.selected = true;
                                    }
                                    <?php endif; ?>
                                    loan.add(option);
                                }
                            } else {
                                checkbox.style.display = 'none';
                                special_id.style.display = 'none';
                            }
                        },
                        error: function () {
                            alert('Error occurring. Please try again.');
                        }
                    });
                });
            });
        </script>
    </fieldset>
<?php echo $this->Form->end(__('Change')); ?>
</div>
