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
                            <li class="active"><?php echo $this->Html->link(__('Wallets'), array('controller' => 'wallets', 'action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link(__('Categories'), array('controller' => 'categories', 'action' => 'index')); ?></li>
                            <li>
                                <?php echo $this->Html->link(__('Transactions'), array('controller' => 'transactions', 'action' => 'index')); ?>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Monthly Report</a></li>
                            <li class="dropdown">
                                    <?php 
                                        $username = $this->Session->read('user');
                                        if($username == null && $username =='') :
                                    ?>
                                <?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login')); ?>
                                    <?php else: ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->Session->read('user'); ?><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
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
            <footer class='footer'>
                <div class='row'>
                    <div class='col-md-12 text-center'>
                        <p>le manh linh</p>
                    </div>
                </div>
            </footer>
<!--		<div id="footer">
			<?php // echo $this->Html->link(
//					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
//					'http://www.cakephp.org/',
//					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
//				);
			?>
			<p>
				<?php // echo $cakeVersion; ?>
			</p>
		</div>-->
        <?php
            //echo $this->Html->script('jquery.min.js'); 
            //echo $this->Html->script('bootstrap.min.js');  
        ?>
	</div>
	<?php // echo $this->element('sql_dump'); ?>
</body>
</html>
