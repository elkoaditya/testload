
	<div id="bg_cover" class=" page_bg1">

		<style>

			.cover-label{
				border: #000 thin solid;
				padding: 10px 18px 10px 18px;
				font-size: 22px;
			}

			#cover-title{
				font-size: 22px;
				font-weight: bold;
				font-family: "Times New Roman";
				line-height: 40px;
			}

			#w-nama{
				margin: 12px 50px 28px 50px;
			}

			#w-nisn{
				margin: 12px 140px 28px 140px;
			}

		</style>

		<br/>
		<br/>
		<br/>

		<div id="cover-title" class="center">
			RAPOR SISWA
			<BR/>
			<?=$title;?>
			
		</div>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>

		<p style="text-align: center;">
			<?php

			$logotutwuri = array(
				"src"	 => "content/images/logotutwurihandayanicolor21.png",
				"width"	 => "20%",
				"height" => "20%",
			);

			echo img($logotutwuri);

			?>
		</p>

		<br/>
		<br/>
		<br/>
		<br/>

		<div class="center" style="font-size: 14px;">
			Nama Siswa:
		</div>

		<div id="w-nama" class="center cover-label bold">
			<?php echo strtoupper($row["nama"]); ?>
		</div>

		<br/>
		<br/>
		<div class="center" style="font-size: 14px;">
			NISN:
		</div>

		<div id="w-nama" class="center cover-label">
			<?php echo ($row["nisn"]); ?>
		</div>

		<br/><br/>

		<?php if(APP_SUBDOMAIN == 'smk-penerbangan.smg.fresto.co'){?>
			<div id="cover-title" class="center">
				KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN
				<br/>
				REPUBLIK INDONESIA
			</div>
		<?php }else{ ?>
		<br/><br/><br/><br/>
			<div style="text-align: center; font-size: 14px; font-weight: bold;">
				KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN
				<br/><br/>
				REPUBLIK INDONESIA
			</div>
		<?php } ?>

	</div>

	<?= '<pagebreak />'; ?>