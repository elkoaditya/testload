<?php 
	$session_user = $this->session->userdata('user');
	
	foreach($menu as $m){
		if($m->menu_name_eng=='user')
		{ 
			$title_eng		= $m->menu_name_eng;
			$title_ind		= $m->menu_name_ind;
			$title_class	= $m->menu_class;
		}
    }
	
	
?>
<div id="page-wrapper">
	<div class="row">
      <div class="col-lg-12">
        <h1>Profile <?=$title_ind;?><small> Statistics Overview</small></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo site_url("/core");?>"><i class="fa fa-file"></i> Home</a></li>
          <li class="active"><i class="<?=$title_class;?>"></i> <?=$title_ind;?></li>
        </ol> 
      </div>
    </div><!-- /.row -->
    
	<label>Menu </label>
	<div class="row">
      <div class="col-lg-6">
          <div class="form-group">
            
		   <form action="<?php echo site_url("/".$title_eng."/form_profile/update/".$session_user->user_id);?>" method="post">
            &nbsp;&nbsp;<button name="tambah" type="submit" class="btn btn-primary btn-sm"> Ubah Profile <?=$title_ind;?></button>
           </form>
          </div>
       </div>
     </div>

    <div class="row">
      <div class="col-lg-5">
    <?php
	$no=0;
	foreach($user as $u)
	{ 
		$no++;
	?>	
        <div class="form-group">
            <label>Nama</label>
            <p><?=$u->user_name;?></p>
          </div>
          
        <div class="form-group">
            <label>Jabatan</label>
            <p><?=$u->user_position_name;?></p>
          </div>
      	
        <div class="form-group">
            <label>No.Hp</label>
            <p><?=$u->user_phone;?></p>
          </div>
        
        <div class="form-group">
            <label>Email</label>
            <p><?=$u->user_email;?></p>
          </div>
      
      </div>
      <div class="col-lg-5">    
      
        <div class="form-group">
            <label>Pin BB</label>
            <p><?=$u->user_BB;?></p>
          </div> 
          
        <div class="form-group">
            <label>Alamat</label>
            <p><?=$u->user_address;?></p>
          </div> 
	<?php
	}
	?>
	 </div>
    </div>     
    
</div>
