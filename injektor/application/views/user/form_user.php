<?php

foreach($menu as $m){
	if($m->menu_name_eng=='user')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
}

if($action=='update')
{
	foreach($user as $u)
	{
		//$data		= $u;
		$data['user_id']			= $u->user_id;
		$data['user_branch']		= $u->user_branch;
		$data['user_name']			= $u->user_name;
		$data['user_position_id']	= $u->user_position_id;
		$data['user_phone']			= $u->user_phone;
		$data['user_email']			= $u->user_email;
		$data['user_BB']			= $u->user_BB;	
		$data['user_address']		= $u->user_address;	
	
		$title		= 'Ubah';		
	}
}else{	
		$data['user_id']			= '';
		$data['user_branch']		= '';
		$data['user_name']			= '';
		$data['user_position_id']	= '';
		$data['user_phone']			= '';
		$data['user_email']			= '';
		$data['user_BB']			= '';	
		$data['user_address']		= '';
	$title		= 'Tambah';	
}

?>

<div id="page-wrapper">

    <div class="row">
      <div class="col-lg-12">
        <h1><?=$title;?> 
		<?php 
		if($url=='profile')
		{ echo 'Profile'; }
		?>
		<?=$title_ind;?> <small>Enter Your Data</small></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo site_url("/core");?>"><i class="fa fa-file"></i> Home</a></li> 
          <li><a href="<?php echo site_url("/".$title_eng."/home");?>"><i class="<?=$title_class;?>"></i> <?=$title_ind;?></a></li>
          <li><i class="fa fa-edit"></i> <?=$title;?> <?=$title_ind;?></li>
        </ol>
       
      </div>
    </div><!-- /.row -->

    <div class="row">
      <form role="form" action="<?php echo site_url("/".$title_eng."/".$url."/".$action);?>" method="post" enctype="multipart/form-data">
      
      <input type="hidden" name="user_show" value="1" />
      <input type="hidden" name="user_id" value="<?=$data['user_id'];?>" />
      <div class="col-lg-5">
    	
        <div class="form-group">
            <label>Cabang</label>
            <input name="user_branch" class="form-control" placeholder="Enter Branch" value="<?=$data['user_branch'];?>">
          </div>
          
        <div class="form-group">
            <label>Nama</label>
            <input name="user_name" class="form-control" placeholder="Enter Name" value="<?=$data['user_name'];?>">
          </div>
        
        <div class="form-group">
            <label>Password</label> 
            <input type="password" name="user_pass" class="form-control" placeholder="Enter Password" >
            <p><i>*) kosongkan jika password sama </i></p>
          </div>
          
        <div class="form-group">
            <label>Ulang Password</label>
            <input type="password" name="user_pass2" class="form-control" placeholder="Enter RePassword" >
            <p><i>*) kosongkan jika password sama </i></p>
          </div>
        
        <?php 
		$session_user = $this->session->userdata('user');
		if($session_user->user_position_id=='1')
		{?>
        <div class="form-group">
            <label>Jabatan</label>
            <select name="user_position_id" class="form-control" value="<?=$data['user_position_id'];?>" >
              <option>--pilih--</option>
            <?php
			foreach($user_position as $up){
				$select[$up->user_position_id]='';
				$select[$data['user_position_id']]='selected';
			
			?>
              <option value="<?=$up->user_position_id;?>" <?=$select[$up->user_position_id];?>><?=$up->user_position_name;?></option>
            <?php }?>
            </select>
          </div>
     	<?php } ?>
     </div>
     <div class="col-lg-5">
            
        <div class="form-group">
            <label>No. Hp</label>
            <input name="user_phone" class="form-control" placeholder="Enter Number Phone" value="<?=$data['user_phone'];?>">
          </div>
          
        <div class="form-group">
            <label>Email</label>
            <input name="user_email" class="form-control" placeholder="Enter Email" value="<?=$data['user_email'];?>">
          </div>
            
        <div class="form-group">
            <label>Pin BB</label>
            <input name="user_BB" class="form-control" placeholder="Enter Pin BB" value="<?=$data['user_BB'];?>">
          </div>
          
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="user_address" class="form-control" rows="4" placeholder="Enter Address"><?=$data['user_address'];?></textarea>
          </div>
          
          
          <input type="submit" class="btn btn-primary" value="<?=$action;?>" />
       
        </div>
      </form>
    </div>
</div>