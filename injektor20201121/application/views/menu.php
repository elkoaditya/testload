<?php
$daftar[0]="";

$no=1;
foreach($menu as $m){
	$daftar[$no]="";
	if(($this->uri->segment(1)==$m->menu_name_eng)&&($this->uri->segment(2)!='profile')&&($this->uri->segment(2)!='form_profile'))
	{	$daftar[$no] = "class='active'";	}
	$no++;
}

if($this->uri->segment(1)=="core")
{	$daftar[0] = "class='active'";	}

$no=0;
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <img width="140px" src=<?php echo base_url("public/img/Logo_ori2.png");?> />
                    
                </div>
                <!-- /input-group -->
            </li>
        <li <?php echo $daftar[0];?>>	<a href="<?php echo site_url("/core");?>">						<i class="fa fa-file fa-fw">		</i> Home</a></li>
        <?php 
        foreach($menu as $m){ 
			if($m->menu_position==1)
			{
				$no2=0;
            	$no++;
        ?>
        <li <?php echo $daftar[$no];?>>	
        <?php
				foreach($menu as $m2){
					if(($m2->menu_position==2)&&($m2->menu_sub_id==$m->menu_id))
					{
						$no++;
						$no2++;
						if($no2==1)
						{
							?>
                            <a href="">	<i class="<?=$m->menu_class;?>"></i> <?=$m->menu_name_ind;?> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                        	<?php
						}
					?>
                    	<li <?php echo $daftar[$no];?>>	
                        <a href="<?php echo site_url("/".$m->menu_name_eng."/".$m2->menu_name_eng);?>">	
                        <i class="<?=$m2->menu_class;?>"></i> <?=$m2->menu_name_ind;?></a></li>
        
					<?php
					}
				}
				if($no2>=1)
				{
					?>
					</ul>
					<?php
				}
				else
				{
					?>
					<a href="<?php echo site_url("/".$m->menu_name_eng."/home");?>">	<i class="<?=$m->menu_class;?>"></i> <?=$m->menu_name_ind;?></a>
                            
					<?php
				}
				?>
                </li><?php
				
			} 
		} ?>
      </ul>
     </div>
                <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
          

      
