<?php 
$this->load->view('function_js');

	foreach($menu as $m){
		if($m->menu_name_eng=='student')
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
                foreach($student as $s)
                { 
                ?>
                <div class="panel-heading">
                    Detail Data Siswa
                    <a href="<?php echo site_url("/".$title_eng."/form/update/".$s->siswa_nilai_id."/".$s->id);?>" class="btn btn-warning">
					<img src="<?php echo base_url("public/img/pencil.png");?>" /> Edit</a>
                	<!--<a href="javascript:void(0)" onclick="hapus('<?=$s->siswa_nilai_id;?>','<?=$s->id;?>','<?=$s->nama;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a>
					-->
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
			   
                        	<div class="form-group">
                                <label>Semester</label>
                                <br/><?php echo $s->nama_semester;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Nama</label>
                                <br/><?php echo $s->nama;?>
                              </div>
							  
							  <div class="form-group">
                                <label>No Absen</label>
                                <br/><?php echo $s->absen_no;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Agama</label>
                                <br/><?php echo $s->nama_agama;?>
                              </div>
                              
                              <div class="form-group">
                                <label>L/P</label>
                                <br/><?php echo $s->gender;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Kelas</label>
                                <br/><?php echo $s->nama_kelas;?>
                              </div>
                              
                              <div class="form-group">
                                <label>NIS</label>
                                <br/><?php echo $s->nis;?>
                              </div>
                              
                              <div class="form-group">
                                <label>NISN</label>
                                <br/><?php echo $s->nisn;?>
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
                <td align="left"><?=$c->nama_guru;?></td>
                <td align="right"><?=$c->kkm;?></td>
                
                
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

<!--/////////////////////ORGANISASI////////////////////////////////-->
<div class="row">
        <div class="col-lg-12">
        <?php 
	$session_user = $this->session->userdata('user');
	?>
              
   
               <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Organisasi
                </div>
                <!-- /.panel-heading -->
                        
        
          
    <div class="panel-body">
    	<div class="table-responsive">
			
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Siswa</th>
                        
                        
                    </tr>
                </thead> 
	<?php
	$no=0;
	foreach($organisasi as $c)
	{ 
		$no++;
	?>
    	
            <tr>
            	<td><?=$no;?></td>
                <td width="20%"><?=$c->nama_organisasi;?></td>
                <td align="right"><?=$c->siswa_jml;?></td>
                
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
   

<!--/////////////////////EKSKUL////////////////////////////////-->
<div class="row">
        <div class="col-lg-12">
        <?php 
	$session_user = $this->session->userdata('user');
	?>
              
   
               <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Ekskul
                </div>
                <!-- /.panel-heading -->
                        
        
          
    <div class="panel-body">
    	<div class="table-responsive">
			
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Siswa</th>
                        
                    </tr>
                </thead> 
	<?php
	$no=0;
	foreach($ekskul as $c)
	{ 
		$no++;
	?>
    	
            <tr>
            	<td><?=$no;?></td>
                <td width="20%"><?=$c->nama_ekskul;?></td>
                <td align="right"><?=$c->siswa_jml;?></td>
                
               
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
	$.prompt("Menghapus Data Siswa <font color='#FF0000'>"+nama+"</font>", {
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
