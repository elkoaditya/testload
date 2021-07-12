<?php 
$this->load->view('function_js');

	foreach($menu as $m){
		if($m->menu_name_eng=='teacher')
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
                foreach($teacher as $s)
                { 
                ?>
                <div class="panel-heading">
                    Detail Data Guru
                    <a href="<?php echo site_url("/".$title_eng."/form/update/".$s->id);?>"><img src="<?php echo base_url("public/img/pencil.png");?>" /></a>
                	<a href="javascript:void(0)" onclick="hapus('<?=$s->id;?>','<?=$s->nama;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a>
            	
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
			   
                        	<div class="form-group">
                                <label>NIP</label>
                                <br/><?php echo $s->nip;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Nama</label>
                                <br/><?php echo $s->nama;?>
                              </div>
                              
                              <div class="form-group">
                                <label>Jabatan</label>
                                <br/><?php echo $s->nama_jabatan;?>
                              </div>
                              <?php
								foreach($kelas as $k)
								{ ?>
                              <div class="form-group">
                                <label>Wali Kelas</label>
                                <?php
									 echo '<br/> - '.$k->nama;
								?>
                                
                              </div>
                              <?php
                              }?>
                			
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
                        <th>Kode</th>
                        <th>Kategori</th>
                        
                        <th>Mapel</th>
                        <th>Pelajaran</th>
                        <th>Siswa</th>
                        <th>KKM</th>
                        
                        <th>Edit</th>
                        <th>Delete</th>
                        
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
            	<td align="center"><?=$c->kode_mapel;?></td>
                <td align="center"><?=$c->kode_kategori_mapel;?></td>
                <td width="20%"><?=$c->nama_mapel;?></td>
                
                <td align="left"><?=$c->nama_pelajaran;?></td>
                <td align="right"><?=$c->siswa_jml;?></td>
                <td align="right"><?=$c->kkm;?></td>
                
                
                <td align="center">
                <a href="<?php echo site_url("/".$title_eng."/form/update/".$c->pelajaran_nilai_id);?>"><img src="<?php echo base_url("public/img/pencil.png");?>" /></a></td>
                <td align="center">
                <a href="javascript:void(0)" onclick="hapus('<?=$c->pelajaran_nilai_id;?>','<?=$c->nama_pelajaran;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a></td>
            	
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
                        
                        <th>Edit</th>
                        <th>Delete</th>
                        
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
                
                
                <td align="center">
                <a href="<?php echo site_url("/".$title_eng."/form/update/".$c->organisasi_nilai_id);?>"><img src="<?php echo base_url("public/img/pencil.png");?>" /></a></td>
                <td align="center">
                <a href="javascript:void(0)" onclick="hapus('<?=$c->organisasi_nilai_id;?>','<?=$c->nama_organisasi;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a></td>
            	
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
                        
                        <th>Edit</th>
                        <th>Delete</th>
                        
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
                
                
                <td align="center">
                <a href="<?php echo site_url("/".$title_eng."/form/update/".$c->ekskul_nilai_id);?>"><img src="<?php echo base_url("public/img/pencil.png");?>" /></a></td>
                <td align="center">
                <a href="javascript:void(0)" onclick="hapus('<?=$c->ekskul_nilai_id;?>','<?=$c->nama_organisasi;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a></td>
            	
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
	$.prompt("Menghapus Data Guru <font color='#FF0000'>"+nama+"</font>", {
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
