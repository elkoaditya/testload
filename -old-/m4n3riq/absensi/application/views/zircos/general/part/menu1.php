<!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- Logo container-->
                    <div class="logo" width="500px">
						<table>
							<tr>
								<td>
									&nbsp;&nbsp;<img src="<?=URL_MASTER;?>content/images/<?=LOGO_SEKOLAH?>" alt="" height="60"> &nbsp;&nbsp;
								</td>
								<td>
									<div style="font-size:22px; line-height:36px">
										E-KURIKULUM <?=SEKOLAH?>
								</td>
							</tr>
						</table>
							
                    </div>
					
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            

                            <li class="dropdown navbar-c-items">
                                <a href="#" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
									<!--<img src="<?=base_url()?>assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> -->
									<i class="fa fa-user"></i>
								</a>
                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li class="text-center">
                                        <h5>User</h5>
                                    </li>
                                    
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
                        
                        <ul class="navigation-menu">
							<!--
							<li class="has-submenu">
                                <a href="<?=base_url()?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
							</li>
							
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-layers"></i>Absensi</a>
                                <ul class="submenu">
                                    <li>
                                        <a href="<?=base_url()?>data/siswa">Siswa</a>
                                    </li>
                                </ul>
                            </li>
							-->
							<li class="has-submenu">
                                <a href="<?=base_url()?>laporan/lap_absensi"><i class="mdi mdi-format-list-bulleted"></i>Laporan Absensi</a>
							</li>
							<li class="has-submenu">
                                <a href="<?=base_url()?>laporan/lap_jurnal_guru"><i class="mdi mdi-file-document"></i>Laporan Jurnal Guru</a>
							</li>
							<li class="has-submenu">
                                <a href="<?=base_url()?>laporan/lap_jurnal_siswa"><i class="mdi mdi-file-document"></i>Laporan Jurnal Siswa</a>
							</li>
							
							
							
							<?php
								$role = $this->session->userdata['user']['role'];
								if($role=='super_admin')
								{
									?>
									
							<li class="has-submenu">
                                <a href="<?=base_url()?>data/user_login"><i class="mdi mdi-account-key"></i>User Login</a>
							</li>		
									<?php
								}
							?>
							
                        </ul>
                       
                    </div> 
                </div>  
            </div>  
			
        </header>
        <!-- End Navigation Bar-->