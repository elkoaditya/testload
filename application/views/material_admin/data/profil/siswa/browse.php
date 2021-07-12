<?php
//siswa
// function

function display_action($no,$row,$semaktif) {
	
	$html = a("data/profil/siswa/id/{$row['id']}?ringkas=ya", '<i class="zmdi zmdi-menu"></i> detail', 'id=detail'.$no.' class="btn btn-small m-b-5 btn-info" title="ubah data siswa ini"'). " &nbsp; ";
	$html .= a("data/user/id/{$row['id']}", '<i class="zmdi zmdi-key"></i> Akun Login', 'id=akun_login'.$no.' 
	class="btn btn-small m-b-5 bgm-purple waves-effect" title="lihat akun login ini"');
	
	if ($semaktif['id'] == 0)
	{
		$html .= display_delete($no,$row);
	}

	return $html;
}

function display_delete($no,$row) {
	$html = " &nbsp; ".a("data/profil/siswa/delete_permanent/{$row['id']}", '<i class="zmdi zmdi-delete"></i> delete permanent', 'id=delete'.$no.' class="btn btn-small m-b-5 btn-danger"  onclick="return confirm(\'APAKAH ANDA YAKIN MENGHAPUS SELURUH DATA \n'.$row['nama'].' ?\')" title="hapus data siswa ini"');
	return $html;
}

function display_nama($row) {
	return a("data/profil/siswa/id/{$row['id']}?ringkas=ya", $row['nama'], 'title="lihat detail data siswa ini"');
}

if ($admin)
{
	$menu_atas = '<div class="col-sm-7" align="right">';		
	$menu_atas .= '<a href="'.base_url().'data/profil/siswa/edit_excel_siswa" id="edit_excel" 
				class="btn btn-primary btn-sm m-b-5" ><i class="zmdi zmdi-download"></i> Edit Siswa Excel</a>';
	if ($semaktif['id'] == 0)
	{
		$menu_atas .= '<a href="'.base_url().'data/profil/siswa/tambah_excel_siswam" id="tambah_excel" 
					class="btn btn-primary btn-sm m-b-5 m-l-5" ><i class="zmdi zmdi-download"></i> Tambah Siswa Excel</a>';
				
		$menu_atas .= '<a href="'.base_url().'data/profil/siswa/form" id="tambah_manual"
					class="btn btn-primary btn-sm m-b-5 m-l-5" ><i class="zmdi zmdi-account-add"></i> Tambah Siswa Manual</a>';
	}else{
		$menu_atas .= '<span class="btn btn-primary btn-sm m-b-5 m-l-5" disabled><i class="zmdi zmdi-download"></i> Tambah Siswa Excel</span>';
				
		$menu_atas .= '<span class="btn btn-primary btn-sm m-b-5 m-l-5" disabled><i class="zmdi zmdi-account-add"></i> Tambah Siswa Manual</span>';
	}
	$menu_atas .= '</div> ';
}else{
	$menu_atas = '';
}

function table(&$no,$data,$menu_atas,$user,$semaktif)
{
	$header_table = "
				<tr>
                    <th>Kelas</th>
					<th>Nama</th>
					<th>NIS</th>
                    
                    <th>L/P</th>";
	
	if($user['role'] == 'admin'){			
    	$header_table .="
					<th>Login</th>
					<th>Aksi</th>";
	}
	
	$header_table .= "</tr>";
	
    $aktif = array('disable', 'aktif');
	$gender = array('l'=>'Laki-laki', 'p'=>'Perempuan');
    ?>
    <div class="card" id="table">
        <div class="card-header">
            <div class="col-sm-5">
                <h2>Data Siswa
                <small>Data siswa yang terdaftar di sistem.
                </small>
            	</h2>
                
            </div>
            <?=$menu_atas?>
        </div>

        <br>
        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                 <?php echo $header_table;?>
                </thead>
                <tfoot>
                  <?php echo $header_table;?>
                </tfoot>
                <tbody>
                    <?php
					
					foreach($data as $view)
					{
						$no++;
						echo"<tr>
						 <td>".$view['kelas_nama']."</td>
						 <td>".display_nama($view)."</td>
						 <td>".$view['nis']."</td>
						 
						 <td>".$gender[$view['gender']]."</td>";
						
						if($user['role'] == 'admin'){
							 echo"
								 <td>".$aktif[$view['aktif']]."</td>
								 <td>".display_action($no,$view,$semaktif)."</td>
							 ";
						}
						
						echo"</tr>";
					}
					?>
                </tbody>
             </table>
             
           </div> 
         </div>
    <?php
}

?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Siswa')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>DAFTAR SISWA</b></h2>
            </div>
			
            <?php
			echo alert_get();
			?>
			<?php
			$no=0;
			echo table($no,$resultset['data'],$menu_atas,$user,$semaktif);
			?>
			
			
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>


<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic').DataTable();
} );

$('#data-table-basic').dataTable( {
  "pageLength": 50
} )

setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('tambah_excel','rubberBand')},5000);
setTimeout(function(){delayAnimation('edit_excel','rubberBand')},5000);
setTimeout(function(){delayAnimation('tambah_manual','rubberBand')},5000);

////table
<?php
$time=3000;
$no_js=0;
if($no>10)
{	$no=10;	}

while($no_js < $no)
{
	$no_js++;
	?>
	setTimeout(function(){delayAnimation('akun_login<?=$no_js?>','rubberBand')},<?=$time?>);
	setTimeout(function(){delayAnimation('detail<?=$no_js?>','rubberBand')},<?=$time?>);
	setTimeout(function(){delayAnimation('delete<?=$no_js?>','rubberBand')},<?=$time?>);
	<?php
	$time = $time + 500;
}
?>
</script>
	</body>
</html>
