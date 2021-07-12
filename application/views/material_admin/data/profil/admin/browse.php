<?php
//admin
// function

function display_action($no,$row) {
	$html = a("data/profil/admin/id/{$row['id']}?ringkas=ya", '<i class="zmdi zmdi-menu"></i> detail', 'id=detail'.$no.' class="btn btn-small m-b-5 btn-info" title="ubah data admin ini"'). " &nbsp; ";
	$html .= a("data/user/id/{$row['id']}", '<i class="zmdi zmdi-key"></i> Akun Login', 'id=akun_login'.$no.' 
	class="btn btn-small m-b-5 bgm-purple waves-effect" title="lihat akun login ini"');
	return $html;
}
function display_nama($row) {
	$nama = array($row['nama'], $row['prefix'], $row['suffix']);
	$nama = array_filter($nama);
	$nama = implode(', ', $nama);

	return a("data/profil/admin/id/{$row['id']}?ringkas=ya", $nama, 'title="lihat detail data admin ini"');
}

if ($admin)
{
	$menu_atas = '<div class="col-sm-7" align="right">
                <a href='.base_url().'data/profil/admin/form" 
                id="tambah" class="btn btn-primary btn-sm" ><i class="zmdi zmdi-account-add"></i> Tambah Admin</a>
            </div> ';
}else{
	$menu_atas = '';
}


function table(&$no,$data,$menu_atas)
{
	$header_table = "
				<tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>L/P</th>
                    <th>Aktif</th>
					<th>Aksi</th>
                </tr>";
	
    $aktif = array('tidak', 'ya');
	$gender = array('l'=>'Laki-laki', 'p'=>'Perempuan');
    ?>
    <div class="card" id="table">
        <div class="card-header">
           <div class="col-sm-5">
                <h2>Data Admin
                <small>Data admin yang terdaftar di sistem.
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
						 <td>".$no."</td>
						 <td>".$view['id']."</td>
						 <td>".display_nama($view)."</td>
						 <td>".$gender[$view['gender']]."</td>
						 <td>".$aktif[$view['aktif']]."</td>
						 <td>".display_action($no,$view)."</td>
						</tr>";
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
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Admin')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>ADMIN</b></h2>
            </div>

            <?php
			echo alert_get();
			?>
			<?php
			$no=0;
			echo table($no,$resultset['data'],$menu_atas);
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

/*
setTimeout(function(){delayAnimation3('tambah','rubberBand')},5000);
//setTimeout(delayAnimation2,3000);
//setTimeout(delayAnimation3('tambah','rubberBand'),5000);

function delayAnimation2 () {
				var animatedEl = document.getElementById('tambah');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className = 'btn btn-primary btn-sm animated rubberBand';
					setTimeout(delayAnimation2, 3000);// i see 2.4s is your animation duration
				}, 2000)// wait 0.5s
			}
			
function delayAnimation3($var,$jenis_animasi,$delay_time) {
				$delay_time = typeof $delay_time !== 'undefined' ? a : 4000;
				var animatedEl = document.getElementById('tambah');
				animatedEl.className = animatedEl.className.replace("animated","");
				animatedEl.className = animatedEl.className.replace($jenis_animasi,"");
				//animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className += "animated "+$jenis_animasi;
					//animatedEl.className = 'btn btn-primary btn-sm animated rubberBand';
					setTimeout(function(){delayAnimation3($var,$jenis_animasi)}, $delay_time);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
*/			
			
  
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s

setTimeout(function(){delayAnimation('term','pulse')},4000);
setTimeout(function(){delayAnimation('cari','rubberBand')},6000);
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);
setTimeout(delayAnimation('tambah','rubberBand'),5000);
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
