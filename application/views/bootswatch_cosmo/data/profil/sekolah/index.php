<!DOCTYPE html>
<html lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Fresto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fresto learning system">
    <meta name="author" content="Fredy Nurman Saleh">
    <meta name="author" content="Dhin Aristo">

    <!--[if lt IE 9]>
      <script src="<?php echo base_url("assets/bootswatch_cosmo"); ?>/html5.js"></script>
    <![endif]-->

    <link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootswatch.css" rel="stylesheet">

	</head>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php $this->load->view(THEME . "/-menu-/{$user['role']}"); ?>

    <div class="container">

			<div>
				<ul class="breadcrumb">
					<?php
					echo li('', a('', 'Depan') . ' <span class="divider">/</span>');
					echo li('', a('data', 'Data') . ' <span class="divider">/</span>');
					echo li('', a('data/profil', 'Profil') . ' <span class="divider">/</span>');
					echo li('class="active"', 'Sekolah');
					?>
				</ul>
			</div>

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Profil Sekolah</h1>
				</div>

				<style>
					.controls{
						font-size: 2em;
					}
				</style>

				<?php echo alert_get(); ?>

				<div class="form-horizontal well">
					<fieldset>
						<div class="control-group">
							<label class="control-label">Nama</label>
							<div class="controls">SMA Semarang</div>
						</div>
						<div class="control-group">
							<label class="control-label">Kota</label>
							<div class="controls">Semarang</div>
						</div>
					</fieldset>
				</div>

			</div>

			<br><br><br><br>

			<!-- Footer
			 ================================================== -->
      <hr>

      <footer id="footer">
        <p class="pull-right"><a href="#top">Back to top</a></p>
        <div class="links">
          <a href="#;">Tentang</a>
          <a href="#;">Jurnal</a>
          <a href="#;">Bantuan</a>
          <a href="#;">Donasi</a>
        </div>
        Dibuat oleh <a href="http://fredyns.net/">Fredy</a> dan <a href="http://ristology.com/">Risto</a>.
				<br/>
				Kontak <a href="mailto:email@fredyns.net">email@fredyns.net</a> atau <a href="mailto:ristology@gmail.com">ristology@gmail.com</a>.
				<br>
      </footer>

    </div><!-- /container -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url("assets/bootswatch_cosmo"); ?>/jquery.min.js"></script>
    <script src="<?php echo base_url("assets/bootswatch_cosmo"); ?>/jquery.smooth-scroll.min.js"></script>
    <script src="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootstrap.min.js"></script>
    <script src="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootswatch.js"></script>


	</body>
</html>