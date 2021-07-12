<?php 
$d = $this->d; 
$setview = 0;
if(isset($user['kelas_id'])){
	if($user['kelas_id'] > 0){
		$setview = 1;
	}
}
?>
<!-- Navbar
	================================================== -->
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="brand" href="#"><strong><?php echo APP_TITLE; ?></strong></div>
			<div class="nav-collapse in collapse" id="main-menu" style="height: auto;">
				

				<ul class="nav pull-right" id="main-menu-right">
					<li class="dropdown" id="user-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $d['user']['nama']; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</div>
</div>
