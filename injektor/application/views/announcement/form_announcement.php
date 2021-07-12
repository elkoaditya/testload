<?php

foreach($menu as $m){
	if($m->menu_name_eng=='announcement')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
	
}

if($action=='update')
{
	foreach($announcement as $i)
	{
		//$data		= $u;
		$data['id']				= $i->id;
		$data['urut']			= $i->urut;
		$data['judul']			= $i->judul;
		$data['deskripsi']		= $i->deskripsi;
		$data['untuk_guru']		= $i->untuk_guru;
		$data['untuk_siswa']	= $i->untuk_siswa;

		$title		= 'Ubah';		
	}
}else{	
		$data['id']				= '';
		$data['urut']			= '';
		$data['judul']			= '';
		$data['deskripsi']		= '';
		$data['untuk_guru']		= '';
		$data['untuk_siswa']	= '';
		
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
            <label>Urut</label>
        	<input name="urut" class="form-control" placeholder="Urut" value="<?=$data['urut'];?>">
           </div>
		   
		<div class="form-group">
            <label>Judul</label>
        	<input name="judul" class="form-control" placeholder="judul" value="<?=$data['judul'];?>">
           </div>
		
		<div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi"><?=$data['deskripsi'];?></textarea>
          </div> 
		  
		<div class="form-group">
            <label>Di Tujukan Kepada</label>
            	<?php
            	$select = '';
				if($data['untuk_guru']==1)
				{	$select = 'checked';	}
				?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="untuk_guru" value="1" <?php echo $select;?>> Guru
                </label>
            </div>
				<?php
            	$select = '';
				if($data['untuk_siswa']==1)
				{	$select = 'checked';	}
				?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="untuk_siswa" value="1" <?php echo $select;?>> Siswa
                </label>
            </div>
		</div>
        
        <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>       
        </div>
        
      </form>
    </div>
</div>
