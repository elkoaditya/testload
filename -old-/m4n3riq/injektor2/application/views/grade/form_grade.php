<?php

foreach($menu as $m){
	if($m->menu_name_eng=='grade')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
}

if($action=='update')
{
	foreach($grade as $i)
	{
		//$data		= $u;
		$data['id']		= $i->id;
		$data['nilai_kelas_id']	= $i->nilai_kelas_id;
		$data['nama']			= $i->nama;
		$data['kelas_wali_id']	= $i->kelas_wali_id;
		$data['jurusan_id']		= $i->jurusan_id;
		$data['grade']			= $i->grade;
		$data['kurikulum_id']	= $i->kurikulum_id;
		$data['kelas_gurubk_id']= $i->kelas_gurubk_id;
		
		$title		= 'Ubah';		
	}
}else{	
		$data['id']				= '';
		$data['nilai_kelas_id']	= '';
		$data['nama']			= '';
		$data['kelas_wali_id']	= '';
		$data['jurusan_id']		= '';
		$data['grade']			= '';
		$data['kurikulum_id']	= '';
		$data['kelas_gurubk_id']= '';
		
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
      <input type="hidden" name="kelas_id" value="<?=$data['id'];?>" />
      <input type="hidden" name="nilai_kelas_id" value="<?=$data['nilai_kelas_id'];?>" />
      <div class="col-lg-6">
    	   
        <div class="form-group">
            <label>Nama</label>
        	<input name="nama" class="form-control" placeholder="Nama" value="<?=$data['nama'];?>">
           </div>
        
        <div class="form-group">
            <label>Wali Kelas</label>
            <select name="kelas_wali_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($teacher as $c)
            { 
                $no++;
	 			$select = '';
				if($data['kelas_wali_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        <div class="form-group">
            <label>Jurusan</label>
            <select name="jurusan_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($jurusan as $c)
            { 
                $no++;
	 			$select = '';
				if($data['jurusan_id']==$c->id)
				{	$select = 'selected';	}
			?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        <div class="form-group">
            <label>Grade</label>
            <select name="grade" class="form-control">
            	<option value="" >-pilih-</option>
			<?php            
			/*
			for($ig=7;$ig<=12;$ig++)
			{
				$grade[$ig] = '';
				if($data['grade']==$ig)
				{	$grade[$ig] = 'selected';	}
				
				?>
				<option value="<?=$ig?>" <?php echo $grade[$ig];?>><?=$ig?></option>
                
				<?php
			}
			*/
            $no=0;
            foreach($grade_detail as $gd)
            { 
                $no++;
	 			$select = '';
				if($data['grade']==$gd->id)
				{	$select = 'selected';	}
			?>
                <option value="<?php echo $gd->id;?>" <?php echo $select;?>><?php echo $gd->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        <div class="form-group">
            <label>Kurikulum</label>
            <select name="kurikulum_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($kurikulum as $c)
            { 
                $no++;
	 			$select = '';
				if($data['kurikulum_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        <div class="form-group">
            <label>Bimbingan Konseling</label>
            <select name="kelas_gurubk_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($teacher as $c)
            { 
                $no++;
	 			$select = '';
				if($data['kelas_gurubk_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>       
        </div>
        
      </form>
    </div>
</div>
