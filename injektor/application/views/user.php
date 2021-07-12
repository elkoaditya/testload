<?php 
	$session_user = $this->session->userdata('user');
	
?>
	<ul class="nav navbar-nav navbar-right navbar-user">
        <li class="dropdown user-dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$session_user->user_name;?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url("/user/profile");?>"><i class="fa fa-user"></i> Profile</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url("/login/logout");?>"><i class="fa fa-power-off"></i> Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </nav>