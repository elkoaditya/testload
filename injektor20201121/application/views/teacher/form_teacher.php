<?php

foreach($menu as $m){
	if($m->menu_name_eng=='teacher')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
}

if($action=='update')
{
	foreach($teacher as $i)
	{
		//$data		= $u;
		$data['id']				= $i->id;
		$data['nip']			= $i->nip;
		$data['nuptk']			= $i->nuptk;
		$data['nama']			= $i->nama;
		$data['gender']			= $i->gender;
		$data['alamat']			= $i->alamat;
		
		$title		= 'Ubah';		
	}
}else{	
		$data['id']				= '';
		$data['nip']			= '';
		$data['nuptk']			= '';
		$data['nama']			= '';
		$data['gender']			= '';
		$data['alamat']			= '';
		
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
      <input type="hidden" name="id" value="<?=$data['id'];?>" />
      <div class="col-lg-6">
    	  
        <div class="form-group">
            <label>NIP</label>
            <input name="nip" class="form-control" placeholder="NIP" value="<?=$data['nip'];?>">
          </div>
         
        <div class="form-group">
            <label>NUPTK</label>
            <input name="nuptk" class="form-control" placeholder="NUPTK" value="<?=$data['nuptk'];?>">
          </div>
           
        <div class="form-group">
            <label>Nama Lengkap</label>
        	<input name="nama" class="form-control" placeholder="Nama" value="<?=$data['nama'];?>">
           </div>
        
        <div class="form-group">
            <label>Gender</label>
            <select name="gender" class="form-control">
            	<?php
				$gender[1]='';
				$gender[2]=''; 
				if($data['gender']=='l')
				{	$gender[1]='selected';	}
				elseif($data['gender']=='p')
				{	$gender[2]='selected';	}
				?>
            	<option value="" >-pilih-</option>
                <option value="l" <?php echo $gender[1];?>>Laki-laki</option>
                <option value="p" <?php echo $gender[2];?>>Perempuan</option>
            </select>
          </div>
        
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="4" placeholder="Alamat"><?=$data['alamat'];?></textarea>
          </div>          
        
        <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>
               
        </div>
      </form>
    </div>
</div>