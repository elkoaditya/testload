<?php
//  SDM
// function

function display_action($no,$row) {
	$html = a("data/profil/sdm/id/{$row['id']}?ringkas=ya", '<i class="zmdi zmdi-menu"></i> Detail', 'id=detail'.$no.' class="btn btn-small m-b-5 btn-info" title="ubah data guru ini"'). " &nbsp; ";
	$html .= a("data/user/id/{$row['id']}", '<i class="zmdi zmdi-key"></i> Akun Login', 'id=akun_login'.$no.' 
	class="btn btn-small m-b-5 bgm-purple waves-effect" title="lihat akun login ini"');
	
	return $html;
}

function display_nama($row) {
	return a("data/profil/sdm/id/{$row['id']}?ringkas=ya", $row['nama'], 'title="lihat detail data guru ini"');
}

if ($admin)
{
	$menu_atas = '<div class="col-sm-7" align="right">
                <a href='.base_url().'data/profil/sdm/form" 
                id="tambah" class="btn btn-primary btn-sm"><i class="zmdi zmdi-account-add"></i> Tambah Guru/Pembina</a>
            </div> ';
}else{
	$menu_atas = '';
}

function table(&$no,$data,$menu_atas,$user)
{
	$header_table = "
				<tr>
                    <th>Nama</th>
					<th>NIP</th>
                    <th>L/P</th>
					<th>Jabatan</th>";
	
	if($user['role'] == 'admin'){			
    	$header_table .="
					<th>Login</th>
					<th>Aksi</th>";
	}
	
	$header_table .= "</tr>";
	
    $aktif = array('blokir', 'aktif');
	$gender = array('l'=>'Laki-laki', 'p'=>'Perempuan');
    ?>
    <div class="card" id="table">
        <div class="card-header">
            <div class="col-sm-5">
                <h2>Data Guru/Pembina
                <small>Data guru/pembina yang terdaftar di sistem.
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
						 <td>".display_nama($view)."</td>
						 <td>".$view['nip']."</td>
						 <td>".$gender[$view['gender']]."</td>
						 <td>".$view['jabatan_nama']."</td>";
						
						if($user['role'] == 'admin'){
							 echo"
								 <td>".$aktif[$view['aktif']]."</td>
								 <td>".display_action($no,$view)."</td>
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

if ($admin)
	$disable = '';
else
	$disable = 'disabled="disabled"';
	
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Guru')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>DAFTAR GURU / PEMBINA</b></h2>
            </div>

            <?php
			echo alert_get();
			?>
			<?php
			$no=0;
			echo table($no,$resultset['data'],$menu_atas,$user);
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
			
setTimeout(function(){delayAnimation('term','pulse')},4000);

setTimeout(function(){delayAnimation('term','pulse')},4000);
setTimeout(function(){delayAnimation('cari','rubberBand')},6000);
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);

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
	<?php
	$time = $time + 500;
}
?>
</script>
	</body>
</html>
