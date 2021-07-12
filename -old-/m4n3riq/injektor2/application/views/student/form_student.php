<?php

foreach($menu as $m){
	if($m->menu_name_eng=='student')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
}

if($action=='update')
{
	foreach($student as $i)
	{
		//$data		= $u;
		$data['id']		= $i->id;
		$data['siswa_nilai_id']		= $i->siswa_nilai_id;
		$data['nis']					= $i->nis;
		$data['nisn']					= $i->nisn;
		$data['id_nilai_kelas']			= $i->id_nilai_kelas;
		$data['nama']					= $i->nama;
		$data['absen_no']				= $i->absen_no;
		$data['gender']					= $i->gender;
		$data['agama_id']				= $i->agama_id;
		$data['lahir_tempat']			= $i->lahir_tempat;
		$data['lahir_tgl']				= $i->lahir_tgl;
		if($data['lahir_tgl']=='0000-00-00')
		{	$data['lahir_tgl']="";	}
		$data['alamat']					= $i->alamat;
		$data['kota']					= $i->kota;
		$data['telepon']				= $i->telepon;
		
		$title		= 'Ubah';		
	}
}else{	
		$data['id']						= '';
		$data['siswa_nilai_id']			= '';
		$data['nis']					= '';
		$data['nisn']					= '';
		$data['id_nilai_kelas']			= '';
		$data['nama']					= '';
		$data['absen_no']					= '';
		$data['gender']					= '';
		$data['agama_id']				= '';
		$data['lahir_tempat']			= '';
		$data['lahir_tgl']				= '';
		$data['alamat']					= '';
		$data['kota']					= '';
		$data['telepon']				= '';
		
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
				Tolong ISI NIS , NAMA , KELAS , GENDER !! 
				</div>";
			}
		}
		?>
      <form role="form" action="<?php echo site_url("/".$title_eng."/".$url."/".$action);?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="siswa_id" value="<?=$data['id'];?>" />
      <input type="hidden" name="nilai_siswa_id" value="<?=$data['siswa_nilai_id'];?>" />
      <div class="col-lg-6">
    	   
        <div class="form-group">
            <label>NIS</label>
        	<input name="nis" class="form-control" placeholder="NIS" value="<?=$data['nis'];?>">
           </div>
        
        <div class="form-group">
            <label>NISN</label>
        	<input name="nisn" class="form-control" placeholder="NISN" value="<?=$data['nisn'];?>">
           </div>
        
        <div class="form-group">
            <label>Kelas</label>
            <select name="nilai_kelas_id" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($kelas as $c)
            { 
                $no++;
	 			$select = '';
				if($data['id_nilai_kelas']==$c->nilai_kelas_id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->nilai_kelas_id;?>" <?php echo $select;?>><?php echo $c->nama;?></option>
            <?php
			}
			?>
            </select>
          </div>
             
        <div class="form-group">
            <label>Nama Lengkap</label>
        	<input name="nama" class="form-control" placeholder="Nama" value="<?=$data['nama'];?>">
           </div>
        
		<div class="form-group">
			<label>No Absen</label>
			<input name="absen_no" class="form-control" placeholder="No absen" value="<?=$data['absen_no'];?>">
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
            <label>Tempat Lahir</label>
        	<input name="lahir_tempat" class="form-control" placeholder="Lahir tempat" value="<?=$data['lahir_tempat'];?>">
           </div>
        
        <div class="form-group">
            <label>Tanggal Lahir</label>
        	<div data-name="lahir_tgl" class="bfh-datepicker" data-format="y-m-d" data-date="<?=$data['lahir_tgl'];?>" placeholder="Enter Date"></div>
           </div>
           
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="4" placeholder="Alamat"><?=$data['alamat'];?></textarea>
          </div> 
          
        <div class="form-group">
            <label>Kota</label>
        	<input name="kota" class="form-control" placeholder="Kota" value="<?=$data['kota'];?>">
           </div>
        
        <div class="form-group">
            <label>Telepon</label>
        	<input name="telepon" class="form-control" placeholder="Telepon" value="<?=$data['telepon'];?>">
           </div>
           
        <div class="form-group">
        <input type="hidden" name="jumlah_kelas" value="<?php echo $no;?>" />
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>       
        </div>
        
      </form>
    </div>
</div>
