<?php
session_start();

$role	= $_SESSION['role'];
$user	= "";
$$kegiatan = "";
$home = "";

if($_REQUEST['page']=='user')
	$user = "class='active'";
if($_REQUEST['page']=='detail_user')
	$detail_user = "class='active'";
else if($_REQUEST['page']=='$kegiatan')
	$kegiatan = "class='active'";
else if($_REQUEST['page']=='home')
	$home = "class='active'";
else if(empty($_REQUEST['page']))
	$home = "class='active'";
	?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Dewan </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="proses/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a <?php echo $home;?> href="index.php?page=home"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a <?php echo $detail_user;?> href="index.php?page=detail_user&id=<?=$_SESSION['user_id'];?>"><i class="fa fa-files-o fa-fw"></i> Detail User</a>
                        </li>
                        <?php
                        if($role==1)
						{?>
                        <li>
                            <a <?php echo $user;?> href="index.php?page=user"><i class="fa fa-table fa-fw"></i> Daftar User</a>
                        </li>
                        <?php
                        }?>
                        <li>
                            <a <?php echo $kegiatan;?> href="index.php?page=kegiatan"><i class="fa fa-edit fa-fw"></i> Kegiatan</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>