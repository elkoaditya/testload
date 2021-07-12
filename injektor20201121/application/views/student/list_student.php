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
	
	$view_angkatan[1]='';
	$view_angkatan[2]='';
	$view_angkatan[3]=''; 
	if(isset($angkatan))
	{
		if($angkatan=='10')
		{	$view_angkatan[1]='selected';	}
		elseif($angkatan=='11')
		{	$view_angkatan[2]='selected';	}
		elseif($angkatan=='12')
		{	$view_angkatan[3]='selected';	}
	}	
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
        
        <div class="col-lg-4">
           <form action="<?php echo site_url("/".$title_eng."/home_angkatan");?>" method="post">
               <div class="form-group">
                    <label>ANGKATAN</label>
                    <select name="angkatan" class="form-control">
                        <option value="0" >ALL</option>
                        <option value="10" <?php echo $view_angkatan[1];?>>X</option>
                        <option value="11" <?php echo $view_angkatan[2];?>>XI</option>
                        <option value="12" <?php echo $view_angkatan[3];?>>XII</option>
                    </select>
                </div>
                <button name="tambah" type="submit" class="btn btn-primary btn-sm"> Cari</button>
            </form>
        </div>
        <div class="col-lg-4">
        	<label>Tambah Siswa</label>
        <?php 
			$session_user = $this->session->userdata('user');
			?>
					   <form action="<?php echo site_url("/".$title_eng."/form/insert");?>" method="post">
			&nbsp;&nbsp;<button name="tambah" type="submit" class="btn btn-primary btn-sm"> Tambah <?=$title_ind;?></button>
		   </form>
   		</div>
        <div class="col-lg-12">
   
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
                        
                        <th>Kelas</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Siswa</th>
                        <th>Agama</th>
                        
                        <th>Edit</th>
                        <!--<th>Delete</th>-->
                        
                    </tr>
                </thead> 
	<?php
	$no=0;
	foreach($student as $c)
	{ 
		$no++;
	?>
    	
            <tr>
            	<td><?=$no;?></td>
            	<td align="center">(<?=$c->id_semester;?>) <?=$c->nama_semester;?></td>
                <td><?=$c->nama_kelas;?></td>
                
                <td align="right"><?=$c->nis;?></td>
                <td align="right"><?=$c->nisn;?></td>
                <td align="left"><a href="<?php echo site_url("/".$title_eng."/detail/id/".$c->siswa_nilai_id);?>"><?=$c->nama;?></a></td>
                <td align="right"><?=$c->nama_agama;?></td>
                
                
                <td align="center">
                <a href="<?php echo site_url("/".$title_eng."/form/update/".$c->siswa_nilai_id."/".$c->id);?>" class="btn btn-warning btn-xs">
				<img src="<?php echo base_url("public/img/pencil.png");?>" /> Edit</a></td>
                <!--<td align="center">
                <a href="javascript:void(0)" onclick="hapus('<?=$c->siswa_nilai_id;?>','<?=$c->id;?>','<?=$c->nama;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a></td>
            	-->
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
