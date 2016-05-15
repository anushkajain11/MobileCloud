<div class="navbar-content clearfix">
					<ul class="nav navbar-top-links pull-left">

						<!--Navigation toogle button-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li class="tgl-menu-btn">
							<a class="mainnav-toggle" href="#">
								<i class="fa fa-navicon fa-lg"></i>
							</a>
						</li>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End Navigation toogle button-->


						




					</ul>
					<ul class="nav navbar-top-links pull-right">

						<!--Language selector-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li class="dropdown">
							<a id="demo-lang-switch" class="lang-selector dropdown-toggle" href="#" data-toggle="dropdown">
								<span class="lang-selected">
									<img class="lang-flag" src="nifty-v2.2/template/img/flags/united-kingdom.png" alt="English">
									<span class="lang-id">EN</span>
									<span class="lang-name">English</span>
								</span>
							</a>

							<!--Language selector menu-->
							<ul class="head-list dropdown-menu with-arrow">
								<li>
									<!--English-->
									<a href="#" class="active">
										<img class="lang-flag" src="nifty-v2.2/template/img/flags/united-kingdom.png" alt="English">
										<span class="lang-id">EN</span>
										<span class="lang-name">English</span>
									</a>
								</li>
								<li>
									<!--France-->
									<a href="#">
										<img class="lang-flag" src="nifty-v2.2/template/img/flags/france.png" alt="France">
										<span class="lang-id">FR</span>
										<span class="lang-name">Fran&ccedil;ais</span>
									</a>
								</li>
								<li>
									<!--Germany-->
									<a href="#">
										<img class="lang-flag" src="nifty-v2.2/template/img/flags/germany.png" alt="Germany">
										<span class="lang-id">DE</span>
										<span class="lang-name">Deutsch</span>
									</a>
								</li>
								<li>
									<!--Italy-->
									<a href="#">
										<img class="lang-flag" src="nifty-v2.2/template/img/flags/italy.png" alt="Italy">
										<span class="lang-id">IT</span>
										<span class="lang-name">Italiano</span>
									</a>
								</li>
								<li>
									<!--Spain-->
									<a href="#">
										<img class="lang-flag" src="nifty-v2.2/template/img/flags/spain.png" alt="Spain">
										<span class="lang-id">ES</span>
										<span class="lang-name">Espa&ntilde;ol</span>
									</a>
								</li>
							</ul>
						</li>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End language selector-->



						<!--User dropdown-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li id="dropdown-user" class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
								<span class="pull-right">
									<img class="img-circle img-user media-object" src="nifty-v2.2/template/img/av1.png" alt="Profile Picture">
								</span>
								<div class="username hidden-xs"><?php echo $this->session->userdata('username'); ?></div>
							</a>


							<div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">

								<!-- Dropdown heading  -->
								<!--
								<div class="pad-all bord-btm">
									<p class="text-lg text-muted text-thin mar-btm">750Gb of 1,000Gb Used</p>
									<div class="progress progress-sm">
										<div class="progress-bar" style="width: 70%;">
											<span class="sr-only">70%</span>
										</div>
									</div>
								</div>
								-->

								<!-- User dropdown menu -->
								<ul class="head-list">
								<!--
									<li>
										<a href="#">
											<i class="fa fa-user fa-fw fa-lg"></i> Profile
										</a>
									</li>
									<li>
										<a href="#">
											<span class="badge badge-danger pull-right">9</span>
											<i class="fa fa-envelope fa-fw fa-lg"></i> Messages
										</a>
									</li>
									<li>
										<a href="#">
											<span class="label label-success pull-right">New</span>
											<i class="fa fa-gear fa-fw fa-lg"></i> Settings
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-question-circle fa-fw fa-lg"></i> Help
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-lock fa-fw fa-lg"></i> Lock screen
										</a>
									</li>
									-->
								</ul>

								<!-- Dropdown footer -->
								<div class="pad-all text-right">
									<a href="logout" class="btn btn-primary">
										<i class="fa fa-sign-out fa-fw"></i> Logout
									</a>
								</div>
							</div>
						</li>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End user dropdown-->

					</ul>
				</div>