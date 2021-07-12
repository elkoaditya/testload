<?php 
$this->load->view('function_js');

	foreach($menu as $m){
		if($m->menu_name_eng=='grade')
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
                foreach($grade as $s)
                { 
					$nilai_kelas_id = $s->nilai_kelas_id;
					$kelas_id = $s->id;
                ?>
                <div class="panel-heading">
                    Detail Data Kelas
        <a href="<?php echo site_url("/".$title_eng."/form/update/".$s->nilai_kelas_id."/".$s->id);?>" class="btn btn-warning">
					<img src="<?php echo base_url("public/img/pencil.png");?>" /> Edit</a>
        <!--<a href="javascript:void(0)" onclick="hapus('<?=$s->nilai_kelas_id;?>','<?=$s->id;?>','<?=$s->nama;?>')">
		<img src="<?php echo base_url("public/img/cross.png");?>" /></a>-->
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
			   
                        	<div class="form-group">
                                <label>Nama Semester</label>
                                <br/><?php echo $s->nama_semester;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Nama Kelas</label>
                                <br/><?php echo $s->nama;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Wali Kelas</label>
                                <br/><?php echo $s->nama_wali;?>
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
     
<!--/////////////////////PELAJARAN////////////////////////////////-->

    <div class="row">
        <div class="col-lg-12">
        <?php 
	$session_user = $this->session->userdata('user');
	?>
              
   
               <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Pelajaran
                </div>
                <!-- /.panel-heading -->
                        
        
          
    <div class="panel-body">
    	<div class="table-responsive">
			
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        
                        <th>Mapel</th>
                        <th>Pelajaran</th>
                        <th>Pengajar</th>
                        <th>KKM</th>
                        <th>Ganti Pengajar</th>
                        
                    </tr>
                </thead> 
	<?php
	$no=0;
	foreach($pelajaran as $c)
	{ 
		$no++;
	?>
    	
            <tr>
            	<td><?=$no;?></td>
            	<td align="center"><?=$c->kode_kategori_mapel;?></td>
                <td width="20%"><?=$c->nama_mapel;?></td>
                
                <td align="left"><?=$c->nama_pelajaran;?></td>
                <td align="left"><?=$c->nama;?></td>
                <td align="right"><?=$c->kkm;?></td>
                <td align="right">
                <a href="<?php echo site_url("/grade/form_study_grade");?>/<?=$nilai_kelas_id?>/<?=$kelas_id?>/<?=$c->pelajaran_nilai_id;?>/<?=$c->pelajaran_id;?>"
                class="btn btn-warning"> Ganti Pengajar</a></td>
               
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
                        <th>NIS</th>
                        <th>NISN</th>
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
            	
                <td align="left"><?=$c->nis;?></td>
                <td align="left"><?=$c->nisn;?></td>
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
	$.prompt("Menghapus Data Kelas <font color='#FF0000'>"+nama+"</font>", {
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
