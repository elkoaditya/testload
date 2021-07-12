<?php

foreach($menu as $m){
	if($m->menu_name_eng=='grade')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
}

foreach($grade as $i)
{
	//$data		= $u;
	$data['pelajaran_id']		= $i->pelajaran_id;
	$data['nilai_pelajaran_id']	= $i->nilai_pelajaran_id;
	
	$data['kelas_id']		= $i->id;
	$data['nilai_kelas_id']	= $i->nilai_kelas_id;
	
	$data['nama_kelas']		= $i->nama;
	$data['nama_pelajaran']	= $i->nama_pelajaran;
	$data['nama_mapel']		= $i->nama_mapel;
	
	$data['nama_guru']	= $i->nama_guru;
	
	$title		= 'Ubah Pengajar';		
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
      <form role="form" action="<?php echo site_url("/".$title_eng."/".$url."/".$action."/".$data['nilai_kelas_id']."/".$data['kelas_id']);?>" 
      method="post" enctype="multipart/form-data">
      <input type="hidden" name="kelas_id" value="<?=$data['kelas_id'];?>" />
      <input type="hidden" name="nilai_kelas_id" value="<?=$data['nilai_kelas_id'];?>" />
      
      <input type="hidden" name="pelajaran_id_awal" value="<?=$data['pelajaran_id'];?>" />
      <input type="hidden" name="nilai_pelajaran_id_awal" value="<?=$data['nilai_pelajaran_id'];?>" />
      <div class="col-lg-6">
    	   
       <div class="form-group">
        <label>Kelas</label>
        <br/><?=$data['nama_kelas']?>
      </div>
      
      <div class="form-group">
        <label>Mapel</label>
        <br/><?=$data['nama_mapel']?>
      </div>
       
       <div class="form-group">
        <label>Pelajaran Awal</label>
        <br/><?=$data['nama_pelajaran']?> (pengajar <?=$data['nama_guru']?>)
      </div>
      
        <div class="form-group">
            <label>Pelajaran</label>
            <select name="pelajaran_update" class="form-control">
            <option value="" >-pilih-</option>
			<?php
            $no=0;
            foreach($study as $c)
            { 
                $no++;
	 			$select = '';
				if($data['pelajaran_id']==$c->id)
				{	$select = 'selected';	}
				?>
                <option value="<?php echo $c->nilai_pelajaran_id;?>/<?php echo $c->id;?>" <?php echo $select;?>>
				<?php echo $c->nama;?> (pengajar <?php echo $c->nama_guru;?>)</option>
            <?php
			}
			?>
            </select>
          </div>
        
        
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>       
        </div>
        
      </form>
    </div>
</div>
