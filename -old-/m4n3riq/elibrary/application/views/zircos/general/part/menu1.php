<?php
if(defined('CHANGE_TITLE')){
	$title = CHANGE_TITLE;
}else{
	$title = 'Perpustakaan Digital';
}
?>
<!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- Logo container-->
                    <div class="logo" width="500px">
                        <table>
							<tr>
								<td>
									&nbsp;&nbsp;<img src="<?=URL_MASTER;?>content/images/<?=LOGO_SEKOLAH?>" alt="" height="50"> &nbsp;&nbsp;
								</td>
								<td>
									<div style="font-size:22px; line-height:36px">
									<?=$title?>
								</td>
							</tr>
						</table>
                    </div>
					
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            

                            <li class="dropdown navbar-c-items">
                                <a href="#" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
									<!--<img src="<?=URL_MASTER;?>assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> -->
									<i class="fa fa-user"></i>
								</a>
                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li class="text-center">
                                        <h5><?=$this->session->userdata['user']['nama']?></h5>
                                    </li>
									<!--
                                    <li><a href=""><i class="ti-user m-r-5"></i> Profile</a></li>-->
                                    <li><a href="<?=base_url()?>dashboard/login/logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>

                            </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a> 
							<div class="navbar-toggle" style="font-size:22px; padding-top:5px;">
								
								<font color="white">
									<img src="<?=URL_MASTER;?>content/images/<?=LOGO_SEKOLAH?>" alt="" height="50">
								</font>
							</div> 
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>
                    <!-- end menu-extras -->

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
							
							<li class="has-submenu">
                                <a href="<?=base_url()?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
							</li>
							
							<?php
								$role = $this->session->userdata['user']['role'];
								
								// HISTORY
								if($role=='guru'){
								?>
								<li class="has-submenu">
									<a href="#"><i class="mdi mdi-account-multiple"></i>Record Baca</a>
									<ul class="submenu">
										<li>
											<a href="<?=base_url()?>data/sdm/detail/<?=$this->session->userdata['user']['id'];?>">Record Pribadi</a>
										</li>	
										<li>
											<a href="<?=base_url()?>data/baca">Record Semua</a>
										</li>
									</ul>
								</li>
								<?php
								}elseif($role=='user')
								{
									?>
									<li class="has-submenu">
										<a href="<?=base_url()?>data/siswa/detail/<?=$this->session->userdata['user']['id'];?>">
											<i class="mdi mdi-account-multiple"></i>Record Pribadi
										</a>
									</li>
									<?php
								}elseif($role=='super_admin')
								{
									?>
									<li class="has-submenu">
										<a href="<?=base_url()?>data/baca"><i class="mdi mdi-account-multiple"></i>Record Semua</a>
									</li>
									<?php
								}
								
								
								
								if($role!='user')
								{
									
										
										if($role=='super_admin')
										{
											?>
											<li class="has-submenu">
												<a href="#"><i class="mdi mdi-account-multiple"></i>Data User</a>
												<ul class="submenu">
													<li>
														<a href="<?=base_url()?>data/sdm">Guru</a>
													</li>
													<li>
														<a href="<?=base_url()?>data/siswa">Siswa</a>
													</li>
												</ul>
											</li>
											<?php
										}else{
											?>
									
											<li class="has-submenu">
												<a href="<?=base_url()?>data/siswa"><i class="mdi mdi-account-multiple"></i>Siswa</a>
											</li>	
									<?php
										}
								}
								
								
							?>
							
							<!--
							<li class="has-submenu">
                                <a href="<?=base_url()?>data/buku"><i class="mdi mdi-book-multiple"></i>Buku Perpustakaan</a>
							</li>-->
							<li class="has-submenu">
                                <a href="#"><i class="mdi mdi-book-multiple"></i>Buku Perpustakaan</a>
                                <ul class="submenu">
									<?php
									if($role!='user')
									{
										?>
										<li>
											<a href="<?=base_url()?>data/tag">Tag Buku</a>
										</li>
										<?php
									}
									?>
									<!--<li>
                                        <a href="<?=base_url()?>data/buku">Daftar Judul Buku</a>
                                    </li>-->
									<li>
                                        <a href="<?=base_url()?>data/buku/listcover_simple">Daftar Buku</a>
                                    </li>
                                </ul>
                            </li>
							
							<li class="has-submenu">
								<a href="<?=base_url()?>data/buku_bab/list_resume"><i class="mdi mdi-layers"></i>Daftar Resume</a>
							</li>
							
							<?php
							$role = $this->session->userdata['user']['role'];
							
							if($role=='super_admin')
							{ ?>
							<li class="has-submenu">
                                <a href="#"><i class="mdi mdi-chart-bar"></i>Grafik</a>
                                <ul class="submenu">
									<li>
										<a href="<?=base_url()?>data/grafik/home/sdm">Grafik Guru</a>
									</li>
									<li>
                                        <a href="<?=base_url()?>data/grafik/home/siswa">Grafik Siswa</a>
                                    </li>
                                </ul>
                            </li>
							<li class="has-submenu">
								<a href="<?=base_url()?>data/laporan"><i class="mdi mdi-layers"></i>Laporan</a>
							</li>
							<?php
							}else if($role!='user')
							{ ?>
								
								<li class="has-submenu">
									<a href="<?=base_url()?>data/grafik/home/siswa"><i class="mdi mdi-chart-bar"></i>Grafik Siswa</a>
								</li>
								
								
								<li class="has-submenu">
									<a href="<?=base_url()?>data/laporan"><i class="mdi mdi-layers"></i>Laporan</a>
								</li>
							<?php } ?>
							
							
							
							
							<?php
								$role = $this->session->userdata['user']['role'];
								if($role=='super_admin')
								{
									?>
								<!--	
							<li class="has-submenu">
                                <a href="<?=base_url()?>data/user_login"><i class="mdi mdi-account-key"></i>User Login</a>
							</li>	-->	
									<?php
								}
							?>
							
                        </ul>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->