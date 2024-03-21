<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'nav-top.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">               
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'user-image', 'alt' => 'User Image')); ?>
          <?php
          $session = $this->request->getSession(); // less than 3.5
          // $session = $this->request->getSession(); // 3.5 or more
          $user_data = $session->read('Auth.User');
          $nombre = "";
          if(!empty($user_data)){
                    $nombre = $user_data['first_name']." ".$user_data['last_name'];
          }else{
              $nombre = $this->Html->link(__('login'), 
                          array ( 'plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'login', '_ext' => NULL, )
                      );
          }   
         ?>   
          <span class="hidden-xs"><?php echo $nombre; ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
             <?php echo $nombre; ?>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <div class="row">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="<?php echo $this->Url->build('/users/users/profile'); ?>" class="btn btn-default btn-flat"> Profile</a>
            </div>
            <div class="pull-right">
              <a href="<?php echo $this->Url->build('/users/users/logout'); ?>" class="btn btn-default btn-flat"> Salir</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li>
    </ul>
  </div>
</nav>
<?php
}
?>
