<div class='col-md-4 '>
    <form class='well' action='<?php echo Router::url('/users/login', true); ?>' method="post">
            <p class='panel-title text-center'>Login</p>
            <?php echo $this->Session->flash(); ?>
            <label for='email'>Email:</label>
            <input name='username' class='form-control' id ='username' value='' type="text" >    
            <label for='password'>Password:</label>
            <input name="password" class='form-control' id='password' type="password">
            <button type="submit" name='submit' class='btn btn-primary margin-top-10'>Submit</button>
    </form>
</div>
