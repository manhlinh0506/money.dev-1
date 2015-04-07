<div class='col-md-4 '>
    <?php echo $this->Form->create('User',array('class'=>'well')); ?>
            <p class='panel-title text-center'>Login</p>
            <?php echo $this->Session->flash(); ?>
    <!--       <label for='email'>Email:</label>
            <input name='username' class='form-control' id ='username' value='' type="text" >    
            <label for='password'>Password:</label>
            <input name="password" class='form-control' id='password' type="password"> -->
           <?php echo $this->Form->input('username', array('label' => 'Email'));
        	echo $this->Form->input('password'); ?>
            <?php echo $this->Form->end(__('Submit')); ?>
       <a href='<?php echo Router::url('/users/add', true); ?>'> Register</a>
       <a href='<?php echo Router::url('/users/forgot', true); ?>'>Forgot password?</a>
</div>
