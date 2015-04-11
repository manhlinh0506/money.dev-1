<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
	<?php echo $this->Html->charset(); ?>
        <?php
            echo $this->Html->css('bootstrap.css');
            echo $this->Html->css('bootstrap-theme.min.css');
            echo $this->Html->css('styles.css');
            echo $this->Html->script('jquery.min.js'); 

          ?>
        <title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
        </title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    </head>
    <body>
        <div id="container">
            <nav class="navbar navbar-inverse border-radius">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Money Lover</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Wallets<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?php echo $this->Html->link(__('List wallets'), array('controller' => 'wallets', 'action' => 'index')); ?></li>
                                    <li><?php echo $this->Html->link(__('Add wallets'), array('controller' => 'wallets', 'action' => 'add')); ?></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Categories<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?php echo $this->Html->link(__('List categories'), array('controller' => 'categories', 'action' => 'index')); ?></li>
                                    <li><?php echo $this->Html->link(__('Add categories'), array('controller' => 'categories', 'action' => 'add')); ?></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Transactions<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?php echo $this->Html->link(__('List transactions'), array('controller' => 'transactions', 'action' => 'index')); ?></li>
                                    <li><?php echo $this->Html->link(__('Add transactions'), array('controller' => 'transactions', 'action' => 'add')); ?></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><?php echo $this->Html->link('English', array('language'=>'eng')); ?> </li>
                            <li><?php echo $this->Html->link('Vietnamese', array('language'=>'vie')); ?></li>
                            <li><?php echo $this->Html->link(__('Monthly Report'), array('controller' => 'reports', 'action' => 'index')); ?></li>
                            <li class="dropdown">
                                    <?php 
                                        if($users_username == null || $users_username =='') :
                                    ?>
                                <?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login')); ?>
                                    <?php else: ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $users_username; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?php echo $this->Html->link(__('Change password'), array('controller' => 'users', 'action' => 'change')); ?></li>
                                    <li><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')); ?></li>
                                </ul>
                            </li>
                                    <?php endif;?>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>  
            <div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <p>
				<?php  echo $cakeVersion; ?>
                </p>
            </div>
        <?php
            echo $this->Html->script('bootstrap.min.js');
            echo $this->element('sql_dump');
        ?>
        </div>
    </body>
</html>
