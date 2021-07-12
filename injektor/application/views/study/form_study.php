<?php

foreach($menu as $m){
	if($m->menu_name_eng=='study')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
}

if($action=='update')
{
	foreach($study as $i)
	{
		//$data		= $u;
		$data['id']		= $i->id;
		$data['nilai_pelajaran_id']		= $i->nilai_pelajaran_id;
		$data['kode']					= $i->kode;
		$data['nama']					= $i->nama;
		$data['guru_id']				= $i->guru_id;
		$data['agama_id']				= $i->agama_id;
		$data['mapel_id']				= $i->mapel_id;
		$data['kategori_id']			= $i->kategori_id;
		$data['nilai_pelajaran_kkm']	= $i->nilai_pelajaran_kkm;
		$data['kurikulum_id']			= $i->kurikulum_id;
		$data['teori']					= $i->teori;
		$data['praktek']				= $i->praktek;
		
		$title		= 'Ubah';		
	}
}else{	
		$data['id']						= '';
		$data['nilai_pelajaran_id']		= '';
		$data['kode']					= '';
		$data['nama']					= '';
		$data['guru_id']				= '';
		$data['agama_id']				= '';
		$data['mapel_id']				= '';
		$data['kategori_id']			= '';
		$data['nilai_pelajaran_kkm']	= '';
		$data['kurikulum_id']			= '';
		$data['teori']					= '';
		$data['praktek']				= '';
		
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
   		<?php
		if(isset($_GET['info']))
		{ 
			if($_GET['info']=='alert')
			{ 
				echo"<div class='alert alert-danger'>
				Tolong ISI KODE , NAMA , KKM , GURU , MAPEL , KATEGORI MAPEL , KURIKULUM !! 
				</div>";
			}
		}
		?>
      <form role="form" action="<?php echo site_url("/".$title_eng."/".$url."/".$action);?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pelajaran_id" value="<?=$data['id'];?>" />
      <input type="hidden" name="nilai_pelajaran_id" value="<?=$data['nilai_pelajaran_id'];?>" />
      <div class="col-lg-6">
    	   
        <div class="form-group">
            <label>Kode</label>
        	<input name="kode" class="form-control" placeholder="Kode" value="<?=$data['kode'];?>">
           </div>
           
        <div class="form-group">
            <label>Nama</label>
        	<input name="nama" class="form-control" placeholder="Nama" value="<?=$data['nama'];?>">
           </div>
        
        <div class="form-group">
            <label>KKM</label>
        	<input name="kkm" class="form-control" placeholder="kkm" value="<?=$data['nilai_pelajaran_kkm'];?>">
           </div>
        
        <div class="form-group">
            <label>Mapel</label>
            <select name="mapel_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($mapel as $c)
            { 
                $no++;
	 			$select = '';
				if($data['mapel_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        <div class="form-group">
            <label>Guru Pengajar</label>
            <select name="guru_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($teacher as $c)
            { 
                $no++;
	 			$select = '';
				if($data['guru_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($kategori as $c)
            { 
                $no++;
	 			$select = '';
				if($data['kategori_id']==$c->id)
				{	$select = 'selected';	}
			?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
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
            <label>Bentuk Pelajaran</label>
            	<?php
            	$select = '';
				if($data['teori']==1)
				{	$select = 'checked';	}
				?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="teori" value="1" <?php echo $select;?>> Teori
                </label>
            </div>
            	<?php
            	$select = '';
				if($data['praktek']==1)
				{	$select = 'checked';	}
				?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="praktek" value="1" <?php echo $select;?>> Praktek
                </label>
            </div>
          </div>
        
        
        <div class="form-group">
            <label>Agama</label>
            <select name="agama_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($agama as $c)
            { 
                $no++;
	 			$select = '';
				if($data['agama_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
        
        
        <div class="form-group">
            <label>Kelas</label>
            <?php
            $no=0;
            foreach($kelas as $c)
            { 
                $no++;
	 			$select = '';
				if($action=='update')
				{
					foreach($kelas_pelajaran as $kp)
					{
						if($kp->nilai_kelas_id==$c->nilai_kelas_id)
						{	$select = 'checked';	}
					}
				}
				?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="kelas_nilai<?php echo $no;?>" value="<?php echo $c->nilai_kelas_id;?>" <?php echo $select;?>> <?php echo $c->nama;?>
                    <input type="hidden" name="kelas<?php echo $no;?>" value="<?php echo $c->id;?>" />
                </label>
            </div>
            <?php
			}
			?>
          </div>
        
        <div class="form-group">
        <input type="hidden" name="jumlah_kelas" value="<?php echo $no;?>" />
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>       
        </div>
        
      </form>
    </div>
</div>
