<?php 
$this->load->view('function_js');

	foreach($menu as $m){
		if($m->menu_name_eng=='study')
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
            <h1>Detail <?=$title_ind;?></h1>
            <ol class="breadcrumb">
          <li><a href="<?php echo site_url("/core");?>"><i class="fa fa-file"></i> Home</a></li>
          <li class="active"><a href="<?php echo site_url("/".$title_eng."/home");?>"><i class="<?=$title_class;?>"></i> <?=$title_ind;?></li></a>
        </ol> 
        </div>
        <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->


	<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
               <?php
                foreach($study as $s)
                { 
                ?>
                <div class="panel-heading">
                    Detail Data Pelajaran
    <a href="<?php echo site_url("/".$title_eng."/form/update/".$s->nilai_pelajaran_id."/".$s->id);?>" class="btn btn-warning btn-xs">
		<img src="<?php echo base_url("public/img/pencil.png");?>" /> Edit</a>
    <a href="javascript:void(0)" onclick="hapus('<?=$s->nilai_pelajaran_id;?>','<?=$s->id;?>','<?=$s->nama;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a>
            	
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
			   
                        	<div class="form-group">
                                <label>Nama Semester</label>
                                <br/><?php echo $s->nama_semester;?>
                              </div>
							  
							  <div class="form-group">
                                <label>Nama Kurikulum</label>
                                <br/><?php echo $s->nama_kurikulum;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Nama Pelajaran</label>
                                <br/><?php echo $s->nama;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Nama Mata Pelajaran</label>
                                <br/><?php echo $s->nama_mapel;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Agama</label>
                                <br/><?php echo $s->nama_agama;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Nama Guru</label>
                                <br/><?php echo $s->nama_guru;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Kelas</label>
                                <?php
								foreach($kelas as $k)
								{ 
									 echo '<br/> - '.$k->nama;
								}?>
                                
                              </div>
                			
                            </div>
                         </div>
                     </div>
                  <?php
				}
                ?>
                 </div>
             </div>
         
     </div>
     
<!--/////////////////////Siswa////////////////////////////////-->

    <div class="row">
        <div class="col-lg-12">
        <?php 
	$session_user = $this->session->userdata('user');
	?>
              
   
               <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Siswa
                </div>
                <!-- /.panel-heading -->
                        
        
          
    <div class="panel-body">
    	<div class="table-responsive">
			
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>NIS</th>
                        
                        <th>Siswa</th>
                        <th>L/P</th>
                        
                    </tr>
                </thead> 
	<?php
	$no=0;
	foreach($siswa as $c)
	{ 
		$no++;
	?>
    	
            <tr>
            	<td><?=$no;?></td>
            	<td width="20%"><?=$c->nama_kelas;?></td>
                
                <td align="left"><?=$c->nis;?></td>
                <td align="left"><?=$c->nama;?></td>
                <td align="right"><?=$c->gender;?></td>
                
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

function hapus(id,id1,nama){
	$.prompt("Menghapus Data Pelajaran <font color='#FF0000'>"+nama+"</font>", {
		title: "Peringatan",
		buttons: { "Ya": true, "Tidak": false },
		submit: function(e,v,m,f){
			// use e.preventDefault() to prevent closing when needed or return false. 
			// e.preventDefault(); 
			if(v==1)
			{location.href = "<?php echo site_url("/".$title_eng."/home/delete");?>/"+id+"/"+id1;}
		}
	});
}



</script>
