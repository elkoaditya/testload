<?php 
$this->load->view('function_js');

	foreach($menu as $m){
		if($m->menu_name_eng=='schedule_teacher')
		{ 
			$title_eng		= $m->menu_name_eng;
			$title_ind		= $m->menu_name_ind;
			$title_class	= $m->menu_class;
		}
    }
	$url = base_url();
	$url = str_replace("injektor",'absensi',$url);
	
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1>Daftar <?=$title_ind;?></h1>
            <ol class="breadcrumb">
          <li><a href="<?php echo site_url("/core");?>"><i class="fa fa-file"></i> Home</a></li>
          <li class="active"><i class="<?=$title_class;?>"></i> <?=$title_ind;?></li>
        </ol> 
        </div>
        <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
        <?php 
	$session_user = $this->session->userdata('user');
	?>
               <form action="<?php echo site_url("/".$title_eng."/form/insert");?>" method="post">
    &nbsp;&nbsp;<button name="tambah" type="submit" class="btn btn-primary btn-sm"> Tambah <?=$title_ind;?></button>
   </form>
   
               <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data 
                </div>
                <!-- /.panel-heading -->
                        
        
          
    <div class="panel-body">
    	<div class="table-responsive">
			
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Semester</th>
                        <th>Nama Guru</th>
                        <th>File</th>
                        
                        <th>Edit</th>
                        <th>Delete</th>
                        
                    </tr>
                </thead> 
	<?php
	$no=0;
	foreach($schedule_teacher as $c)
	{ 
		$no++;
	?>
    	
            <tr>
            	<td><?=$no;?></td>
            	<td><?=$c->nama_semester;?></td>
                <td><?=$c->nama_guru;?></td>
                <?php
				if($c->file!=''){
					echo '<td align="left"><a href="'.$url.'content/'.APP_SCOPE.'/jadwal/'.$c->file.'" target="_blank">'.$c->file.'</a></td>';
				}else{
					echo '<td align="left"></td>';
				}?>
                
                
                <td align="center">
                <a href="<?php echo site_url("/".$title_eng."/form/update/".$c->id);?>"><img src="<?php echo base_url("public/img/pencil.png");?>" /></a></td>
                <td align="center">
                <a href="javascript:void(0)" onclick="hapus('<?=$c->id;?>', '<?=$c->file;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a></td>
            	
            </tr>
           
	<?php
		
	}
	
	/*
	if($no==0)
	{?>
    	<tr>
         <td colspan="7" align="center"><form action="admin.php?proses=pindah_kriteria&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>" method="post">
            &nbsp;&nbsp;<button name="tambah" type="submit" class="btn btn-primary btn-sm"> Ambil Kriteria dari Bulan Lalu </button>
           </form></td>
        </tr>
<?php		
	}*/
	?>
	     	</tbody>
          </table>
			</div>
          </div>
       </div>
      </div>
   </div>

</div>

<script>

function hapus(id,nama){
	$.prompt("Menghapus Jadwal <font color='#FF0000'>"+nama+"</font>", {
		title: "Peringatan",
		buttons: { "Ya": true, "Tidak": false },
		submit: function(e,v,m,f){
			// use e.preventDefault() to prevent closing when needed or return false. 
			// e.preventDefault(); 
			if(v==1)
			{location.href = "<?php echo site_url("/".$title_eng."/home/delete");?>/"+id;}
		}
	});
}



</script>
