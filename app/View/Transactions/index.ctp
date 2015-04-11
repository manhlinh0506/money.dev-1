<div class="transactions index">
    <h2><?php echo __('Transactions'); ?></h2>
 <?php     $current_year = date('Y');
                    $current_month = date('m');
                    $current_day = date('d');
    echo $this->Form->input('ShowTransactions', array(
        'type'=>'date', 'selected'=>array(
            'day'=>''.$current_day.'','month'=>''.$current_month.'','year'=>''.$current_year.''),
        'empty'=>true, 'minYear'=>2009, 'maxYear'=>$current_year+10));
    echo $this->Form->button('Show',array('name'=>'show', 'onclick'=>'showByDateTime()'));
?>
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('transaction_value'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th><?php echo $this->Paginator->sort('category_id'); ?></th>
                <th><?php echo $this->Paginator->sort('date_of_execution'); ?></th>
                <th><?php echo $this->Paginator->sort('parent_transaction'); ?></th>
                <th id='remove' class="actions text-center"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody id = 'tbody'>
	<?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Transaction']['name']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Transaction']['transaction_value']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Transaction']['modified']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Category']['name']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Transaction']['date_of_execution']); ?>&nbsp;</td>
                <td><?php echo h($transaction['Transaction']['parent_transaction']); ?>&nbsp;</td>
                <td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $transaction['Transaction']['id']))); ?>
                </td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    
    <p id = 'number'>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
    <div id = 'paging' class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
    </div>
    <script>
        function showByDateTime() {
            var date = document.getElementById('ShowTransactionsDay');
            var month = document.getElementById('ShowTransactionsMonth');
            var year = document.getElementById('ShowTransactionsYear');
            var date_value = date.value;
            var month_value = month.value;
            var year_value = year.value;
            var table = document.getElementById('tbody');
            while(table.childNodes.length>1){table.removeChild(table.lastChild);}
            $('#remove').remove();
            $('#number').remove();
            $('#paging').remove();
            $.ajax({
               type: 'POST' ,
               url: '<?php echo $this->Html->url(array('controller'=>'transactions', 'action'=>'showbydate')); ?>',
               data: {date:date_value, month:month_value, year:year_value},
               dataType: 'json',
               success: function (data) {
                   if(data != null && data != '') {
                      for(var i =0; i < data.length; i++) {
                          var newtr = document.createElement('tr');
                          var newid = document.createElement('td');
                          var newname = document.createElement('td');
                          var newtransaction_value = document.createElement('td');
                          var newcreated = document.createElement('td');
                          var newmodified = document.createElement('td');
                          var newcategory = document.createElement('td');
                          var newdate = document.createElement('td');
                          var newparent = document.createElement('td');
                          newid.innerHTML = data[i]['transactions']['id'];
                          newname.innerHTML = data[i]['transactions']['name'];
                          newtransaction_value.innerHTML = data[i]['transactions']['transaction_value'];
                          newcreated.innerHTML = data[i]['transactions']['created'];
                          newmodified.innerHTML = data[i]['transactions']['modified'];
                          newcategory.innerHTML = data[i]['categories']['name'];
                          newdate.innerHTML = data[i]['transactions']['date_of_execution'];
                          newparent.innerHTML = data[i]['transactions']['parent_transaction'];
                          newtr.appendChild(newid);
                          newtr.appendChild(newname);
                          newtr.appendChild(newtransaction_value);
                          newtr.appendChild(newcreated);
                          newtr.appendChild(newmodified);
                          newtr.appendChild(newcategory);
                          newtr.appendChild(newdate);
                          newtr.appendChild(newparent);
                          table.appendChild(newtr);
                      }
                   }
               }
            });
        }
       </script>
</div>