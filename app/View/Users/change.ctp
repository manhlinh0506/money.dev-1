<div class='col-md-4 '>
    <?php echo $this->Form->create('User',array('class'=>'well')); ?>
            <p class='panel-title text-center'>Change password</p>
            <?php echo $this->Session->flash(); ?>
           <?php 
        	echo $this->Form->input('old_password', array('label'=>'Old Password', 'name'=>'old_password', 'type'=>'password'));
                echo $this->Form->input('new_password', array('label'=>'New Password', 'name'=>'new_password', 'type'=>'password'));
                echo $this->Form->input('cf_password', array('label'=>'Confirm New Password', 'name'=>'cf_password', 'type'=>'password'));
             ?>
            <?php echo $this->Form->end(__('Change')); ?>
</div>