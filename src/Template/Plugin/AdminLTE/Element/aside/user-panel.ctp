<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'user-panel.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<div class="user-panel">
    <!--<div class="pull-left image">
        <?php echo $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
    </div>-->
     <div class="pull-left info" style="position: initial;">
    <?php
        $session = $this->request->getSession(); // less than 3.5
        // $session = $this->request->getSession(); // 3.5 or more
        $user_data = $session->read('Auth.User');
        if(!empty($user_data)){
            ?>
                <p><?php
               echo $user_data['first_name']." ".$user_data['last_name'];
                ?></p>
            <?php
        }else{
            echo $this->Html->link(__('login'), 
                        array ( 'plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'login', '_ext' => NULL, )
                    );
        }   
    ?>
   </div>
</div>
<?php } ?>
