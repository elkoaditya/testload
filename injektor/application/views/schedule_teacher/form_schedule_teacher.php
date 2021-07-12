<?php

foreach($menu as $m){
	if($m->menu_name_eng=='schedule_teacher')
	{ 
		$title_eng		= $m->menu_name_eng;
		$title_ind		= $m->menu_name_ind;
		$title_class	= $m->menu_class;
	}
	$base_url = base_url();
	$base_url = str_replace("injektor",'absensi',$base_url);
	
	$file_view = "http://docs.google.com/viewer?url=";
}

if($action=='update')
{
	foreach($schedule_teacher as $i)
	{
		//$data		= $u;
		$data['id']				= $i->id;
		$data['guru_id'] 		= $i->guru_id;
		$data['file']			= $i->file;
		
		$title		= 'Ubah';		
	}
}else{	
		$data['id']				= '';
		$data['guru_id'] 		= '';
		$data['file']			= '';
		
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
    	   
        <?php
		/*
		if($data['file']!=''){
			echo '<div class="form-group">
					<label>File Tersimpan</label><br/>
						<iframe id="lampiran" src="'.$file_view.''.$base_url.'content/jadwal/'.$data['file'].'&embedded=true" width="600" height="400"></iframe> ';
		}*/
		if($data['file']!=''){
			echo '<div class="form-group">
					<label>File Tersimpan</label>
						<img width="140px" src="'.$base_url.'content/'.APP_SCOPE.'/jadwal/'.$data['file'].'"></div>';
		}?>
		<div class="form-group">
            <label>File Image</label>
        	<input type='file' name="file" class="form-control" >
           </div>
        
		<div class="form-group">
            <label>Guru</label>
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
        <input type="submit" class="btn btn-primary" value="<?php echo $title;?>" />  
        </div>       
        </div>
        
      </form>
    </div>
</div>
