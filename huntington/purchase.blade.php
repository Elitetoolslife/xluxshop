  <body>
    <div id="page-container" class="page-header-dark main-content-boxed remember-theme">
      <header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
<!-- Logo -->
<a class="luxury-logo-container" href="../main/index.html" title="Premium Trading Platform">
    <div class="luxury-frame">
        <!-- Golden Particles -->
        <div class="luxury-particle lp1"></div>
        <div class="luxury-particle lp2"></div>
        <div class="luxury-particle lp3"></div>
        <div class="luxury-particle lp4"></div>
        
        <!-- Main Logo -->
        <img src="https://png.pngtree.com/png-vector/20240612/ourmid/pngtree-monkey-smoke-sigarate-png-image_12720609.png" 
             alt="Premium Logo" 
             class="luxury-logo-image">
    </div>
</a>
<!-- END Logo -->

<style>.luxury-logo-container {
    display: inline-block;
    position: relative;
    padding: 6px;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.luxury-frame {
    position: relative;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(45deg, 
        #daa520 0%, 
        #ffd700 25%, 
        #fff3a0 50%, 
        #ffd700 75%, 
        #daa520 100%);
    padding: 2px;
    box-shadow: 0 0 20px rgba(218, 165, 32, 0.3);
    animation: frame-pulse 3s ease-in-out infinite;
}

.luxury-logo-image {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    transition: all 0.4s ease;
    position: relative;
    z-index: 2;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Luxury Particles */
.luxury-particle {
    position: absolute;
    background: radial-gradient(circle, #ffd700 30%, transparent 70%);
    border-radius: 50%;
    animation: luxury-orbits 6s linear infinite;
    filter: blur(1px);
    opacity: 0.8;
}

.lp1 { width: 3px; height: 3px; top: 10%; left: 20%; }
.lp2 { width: 4px; height: 4px; top: 70%; left: 75%; }
.lp3 { width: 2px; height: 2px; top: 40%; left: 65%; }
.lp4 { width: 3px; height: 3px; top: 80%; left: 30%; }

/* Animations */
@keyframes frame-pulse {
    0%, 100% { 
        transform: scale(1);
        box-shadow: 0 0 20px rgba(218, 165, 32, 0.3); 
    }
    50% { 
        transform: scale(1.02);
        box-shadow: 0 0 30px rgba(218, 165, 32, 0.5); 
    }
}

@keyframes luxury-orbits {
    0% { transform: rotate(0deg) translateX(12px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(12px) rotate(-360deg); }
}

/* Hover Effects */
.luxury-logo-container:hover .luxury-frame {
    animation: frame-pulse 1s ease-in-out infinite;
    transform: scale(1.06);
}

.luxury-logo-container:hover .luxury-logo-image {
    transform: rotate(5deg) scale(1.05);
}

.luxury-logo-container:hover .luxury-particle {
    animation-duration: 3s;
    opacity: 1;
}

/* Golden Shine Effect */
.luxury-frame::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 50%;
    background: linear-gradient(45deg, 
        transparent 0%, 
        rgba(255, 215, 0, 0.2) 50%, 
        transparent 100%);
    animation: golden-shine 3s linear infinite;
    z-index: 1;
}

@keyframes golden-shine {
    0% { transform: rotate(0deg); opacity: 0; }
    25% { opacity: 0.6; }
    50% { opacity: 0; }
    100% { transform: rotate(360deg); opacity: 0; }
}

/* Mobile Optimization */
@media (max-width: 768px) {
    .luxury-frame {
        width: 40px;
        height: 40px;
    }
    .luxury-logo-image {
        width: 32px;
        height: 32px;
    }
}
</style>
            <!-- Dark Mode -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="dark_mode_toggle">
                <i class="far fa-moon"></i>
              </button>
              <!-- END Dark Mode -->
               <!--just a space character to sperate the icons -->
               &nbsp;
               <!--just a space character to sperate the icons -->
            <!-- Notifications Dropdown -->
            <div class="dropdown d-inline-block me-2">
                <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="text-primary">•</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg p-0 border-0 fs-sm"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                        <h5 class="dropdown-header text-uppercase">Notifications Center</h5>
                    </div>
                    <ul class="nav-items mb-0">
                                                                    </ul>
                    <!--
                    <div class="p-2 border-top text-center">
                        <a class="d-inline-block fw-medium" href="javascript:void(0)">
                            <i class="fa fa-fw fa-arrow-down me-1 opacity-50"></i> Load More..
                        </a>
                    </div>-->
                </div>
            </div>
            <!-- END Notifications Dropdown -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
            <!-- Open Search Section (visible on smaller screens) -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
 



            <!-- User Dropdown -->
            <div class="dropdown d-inline-block ms-2">
                <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle" src="https://png.pngtree.com/png-vector/20240612/ourmid/pngtree-monkey-smoke-sigarate-png-image_12720609.png"
                        alt="Header Avatar" style="width: 21px;" />
                    <span class="d-none d-sm-inline-block ms-2">HustlersFathers</span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                        <img class="img-avatar img-avatar48 img-avatar-thumb"
                            src="https://png.pngtree.com/png-vector/20240612/ourmid/pngtree-monkey-smoke-sigarate-png-image_12720609.png" alt="WaXa Trusted Group">
                        <p class="mt-2 mb-0 fw-medium">Username : HustlersFathers</p>
                        <p class="mb-0 text-muted fs-sm fw-medium">Account Type : user</p>
                    </div>
       					<div class="p-2">
						<a class="dropdown-item d-flex align-items-center justify-content-between"
                        href="../add-balance/index.html">
                        <span class="fs-sm fw-medium">Balance</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-success">0 USD</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                        href="../become-premium/index.html">
                        <span class="fs-sm fw-medium">Premium</span>
                        <span class="badge rounded-pill bg-info ms-2">normal</span>
                        </a>
						<a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="index.html">
                            <span class="fs-sm fw-medium">Orders</span>
                            <span class="badge rounded-pill bg-primary ms-2">0</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="../tickets/index.html">
                            <span class="fs-sm fw-medium">Tickets</span>
                            <span class="badge rounded-pill bg-danger ms-2">0</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="../main/index.html">
                            <span class="fs-sm fw-medium">Reports</span>
                            <span class="badge rounded-pill bg-danger ms-2">1</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="../main/index.html">
                            <span class="fs-sm fw-medium">Settings</span>
                        </a>
                    </div>
                    <div role="separator" class="dropdown-divider m-0"></div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="../faq/index.html">
                            <span class="fs-sm fw-medium">FAQ</span>
                        </a>

                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="../login/index.html" method="POST">
                            <input type="hidden" name="_token" value="JEVPhjed5WLGXT0Ej1rtrgZXiqR7Q61yCZa08Dc0" autocomplete="off">                            <span class="fs-sm fw-medium">Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
            <form class="w-100" action="https://waxa.pw/bd_search.html" method="POST">
                <div class="input-group">
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-alt-danger" data-toggle="layout"
                        data-action="header_search_off">
                        <i class="fa fa-fw fa-times-circle"></i>
                    </button>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                        id="page-header-search-input" name="page-header-search-input" />
                </div>
            </form>
        </div>
    </div>
    <!-- END Header Search -->

    <!-- Header Loader -->
    <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-primary-lighter">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css">
<div class='notifications top-right'></div>
<script>
</script>      <main id="main-container">
        <div class="bg-primary-darker">
    <div class="bg-black-10">
      <div class="content py-3">
        <!-- Toggle Main Navigation -->
        <div class="d-lg-none">
          <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
          <button type="button" class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
            Menu
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        <div id="main-navigation" class="d-none d-lg-block mt-2 mt-lg-0">
          <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">
            <ul class="nav-main nav-main-horizontal nav-main-hover nav-main-dark">
            <li class="nav-main-item">
              <a class="nav-main-link active" href="../main/index.html">
                <i class="nav-main-link-icon si si-wallet"></i>
                <span class="nav-main-link-name">Balance</span>
                <span class="nav-main-link-badge badge rounded-pill bg-primary">0 $</span>
              </a>
            </li>
            <li class="nav-main-heading">Manage</li>
            <li class="nav-main-item">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon fa fa-briefcase"></i>
                <span class="nav-main-link-name">Products</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name">Hosts</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../rdp/index.html">
                        <i class="nav-main-link-icon fa fa-desktop"></i>
                        <span class="nav-main-link-name">Remote Desktop</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">1</span>

                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../shells/index.html">
                        <i class="nav-main-link-icon fab fa-php"></i>
                        <span class="nav-main-link-name">Shells</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">26</span>

                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../cpanels/index.html">
                        <i class="nav-main-link-icon fab fa-cpanel"></i>
                        <span class="nav-main-link-name">cPanels</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">184</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../ssh/index.html">
                        <i class="nav-main-link-icon fab fa-linux"></i>
                        <span class="nav-main-link-name">SSHs</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">1</span>
                      </a>
                    </li>


                  </ul>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-paper-plane"></i>
                    <span class="nav-main-link-name">Senders</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../mailer/index.html">
                        <i class="nav-main-link-icon fa fa-leaf"></i>
                        <span class="nav-main-link-name">Mailers</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">3</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../smtp/index.html">
                        <i class="nav-main-link-icon fab fa-mailchimp"></i>
                        <span class="nav-main-link-name">SMTPs</span>
                                                <span class="nav-main-link-badge badge rounded-pill bg-primary">1</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-envelope-letter"></i>
                    <span class="nav-main-link-name">WebMails</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../webmail/index.html">
                        <i class="nav-main-link-icon fab fa-cpanel fa-2x"></i>
                        <span class="nav-main-link-name">cPanel</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">0</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../webmail/index.html">
                        <i class="nav-main-link-icon fab fa-microsoft"></i>
                        <span class="nav-main-link-name">Office365</span>
                                                <span class="nav-main-link-badge badge rounded-pill bg-primary">0</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../webmail/index.html">
                        <i class="nav-main-link-icon fab fa-golang"></i>
                        <span class="nav-main-link-name">GoDaddy</span>
                                                <span class="nav-main-link-badge badge rounded-pill bg-primary">0</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../webmail/index.html">
                        <i class="nav-main-link-icon fa fa-1x fa-info"></i>
                        <span class="nav-main-link-name">IONOS</span>
                                                <span class="nav-main-link-badge badge rounded-pill bg-primary">0</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="../webmail/index.html">
                        <i class="nav-main-link-icon fa fa-1x fa-shuttle-space"></i>
                        <span class="nav-main-link-name">Rackspace</span>
                                                <span class="nav-main-link-badge badge rounded-pill bg-primary">0</span>
                      </a>
                    </li>
                  </ul>
                </li>
                
              </ul>
            </li>
			 <li class="nav-main-heading">Accounts</li>
            <li class="nav-main-item">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="../account/index.html">
                <i class="nav-main-link-icon fa fa-universal-access"></i>
                <span class="nav-main-link-name">Accounts</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index.html">
                    <i class="nav-main-link-icon fa fa-people-group"></i>
                    <span class="nav-main-link-name">Main Sections</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../login/index.html">
                    <i class="nav-main-link-icon fab fa-facebook"></i>
                    <span class="nav-main-link-name">Social Media</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=9.html">
                    <i class="nav-main-link-icon fab fa-magento"></i>
                    <span class="nav-main-link-name">Marketing</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=1.html">
                    <i class="nav-main-link-icon fa fa-gamepad"></i>
                    <span class="nav-main-link-name">Games</span>
                  </a>
                </li>
				<li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=15.html">
                    <i class="nav-main-link-icon fa fa-mobile-button"></i>
                    <span class="nav-main-link-name">Mobile Games</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=11.html">
                    <i class="nav-main-link-icon fab fa-twitch"></i>
                    <span class="nav-main-link-name">Streaming</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=12.html">
                    <i class="nav-main-link-icon fa fa-restroom"></i>
                    <span class="nav-main-link-name">Dating</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=10.html">
                    <i class="nav-main-link-icon fab fa-btc"></i>
                    <span class="nav-main-link-name">Cryptocurrency</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=13.html">
                    <i class="nav-main-link-icon fab fa-youtube"></i>
                    <span class="nav-main-link-name">Entertainment</span>
                  </a>
                  <li class="nav-main-item">
                  <a class="nav-main-link" href="../account/index%EF%B9%96parent_id=14.html">
                      <i class="nav-main-link-icon fa fa-robot"></i>
                      <span class="nav-main-link-name">Artificial intelligence</span>
                    </a>
                  </li>
                </li>
              </ul>
            </li>
			            <li class="nav-main-heading">Services</li>
            <li class="nav-main-item">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fab fa-searchengin"></i>
                    <span class="nav-main-link-name">Services</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon fa fa-pencil-alt"></i>
                        <span class="nav-main-link-name">Telegram Services</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon fa fa-chart-line"></i>
                        <span class="nav-main-link-name">Social Media Services</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon fa fa-chart-area"></i>
                        <span class="nav-main-link-name">Backlinks Services</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">920</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon far fa-images"></i>
                        <span class="nav-main-link-name">Traffic Services</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">7</span>
                      </a>
                    </li>
                  </ul>
                </li>
			</ul>
            </li>
            <li class="nav-main-heading">Games</li>
            <li class="nav-main-item">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon si si-diamond"></i>
                <span class="nav-main-link-name">Games</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link" href="https://waxa.pw/bd_simple_1.html">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name"> Rock-Paper-Scissors </span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="https://waxa.pw/bd_simple_2.html">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name">Dice</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="https://waxa.pw/bd_image_1.html">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name">Heads / Tails</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="https://waxa.pw/bd_image_2.html">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name">Soon 2</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="https://waxa.pw/bd_video_1.html">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name">Soon 1</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="https://waxa.pw/bd_video_2.html">
                    <i class="nav-main-link-icon fa fa-server"></i>
                    <span class="nav-main-link-name">Soon 2</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <span class="nav-main-link-name">More Options</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon fa fa-server"></i>
                        <span class="nav-main-link-name">Soon</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon fa fa-server"></i>
                        <span class="nav-main-link-name">Soon</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" href="javascript:void(0)">
                        <i class="nav-main-link-icon fa fa-server"></i>
                        <span class="nav-main-link-name">Soon</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="nav-main-heading">Themes</li>
            <li class="nav-main-item ms-lg-auto">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon fa fa-brush"></i>
                <span class="nav-main-link-name d-lg-none">Themes</span>
              </a>
              <ul class="nav-main-submenu nav-main-submenu-right">
                <li class="nav-main-item">
                  <a class="nav-main-link" data-toggle="theme" data-theme="default" href="#">
                    <i class="nav-main-link-icon fa fa-square text-default"></i>
                    <span class="nav-main-link-name">Default</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" href="#">
                    <i class="nav-main-link-icon fa fa-square text-amethyst"></i>
                    <span class="nav-main-link-name">Amethyst</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/city.min.css" href="#">
                    <i class="nav-main-link-icon fa fa-square text-city"></i>
                    <span class="nav-main-link-name">City</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/flat.min.css" href="#">
                    <i class="nav-main-link-icon fa fa-square text-flat"></i>
                    <span class="nav-main-link-name">Flat</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/modern.min.css" href="#">
                    <i class="nav-main-link-icon fa fa-square text-modern"></i>
                    <span class="nav-main-link-name">Modern</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" href="#">
                    <i class="nav-main-link-icon fa fa-square text-smooth"></i>
                    <span class="nav-main-link-name">Smooth</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- END Main Navigation -->
      </div>
    </div>
  </div>
           <main id="main-container">
    <!-- Page Content -->
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
              <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                  <h1 class="h3 fw-bold mb-1">
                      Orders Manager
                  </h1>
                  <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                    That feeling of money when you start using your orders.
                                                          </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                  <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                      <a class="link-fx" href="../main/index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                      MyOrders
                  </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <!-- END Hero -->
          
    <div class="content">
<!-- Quick Overview -->
<div class="row g-3 mb-4 mt-3">
  <div class="col-6 col-lg-3">
      <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2"
           data-bs-toggle="tooltip" 
           data-bs-placement="top"
           title="Total Orders">
          <div class="block-content block-content-full p-3">
              <div class="d-flex align-items-center justify-content-between">
                  <div>
                      <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                          <i class="fas fa-shopping-cart me-1 animate-slide"></i> All Orders
                      </div>
                      <div class="fs-2 fw-bold text-primary">
                          <span class="count-up">0</span>
                      </div>
                  </div>
                  <i class="fas fa-chart-line fa-2x text-primary opacity-25 animate-float"></i>
              </div>
          </div>
          <div class="block-content py-2 bg-body-light">
              <p class="fw-medium fs-sm text-primary mb-0">
                  <i class="fas fa-arrow-up me-1"></i> Total Orders
              </p>
          </div>
      </div>
  </div>

  <div class="col-6 col-lg-3">
      <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2"
           data-bs-toggle="tooltip" 
           data-bs-placement="top"
           title="Total Completed Orders">
          <div class="block-content block-content-full p-3">
              <div class="d-flex align-items-center justify-content-between">
                  <div>
                      <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                          <i class="fas fa-check-circle me-1 animate-bounce"></i> Completed
                      </div>
                      <div class="fs-2 fw-bold text-success">
                          <span class="count-up">3</span>
                      </div>
                  </div>
                  <i class="fas fa-clipboard-check fa-2x text-success opacity-25 animate-float"></i>
              </div>
          </div>
          <div class="block-content py-2 bg-body-light">
              <p class="fw-medium fs-sm text-success mb-0">
                  <i class="fas fa-arrow-up me-1"></i> Successful Orders
              </p>
          </div>
      </div>
  </div>

  <div class="col-6 col-lg-3">
      <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2"
           data-bs-toggle="tooltip" 
           data-bs-placement="top"
           title="Total Reported Orders">
          <div class="block-content block-content-full p-3">
              <div class="d-flex align-items-center justify-content-between">
                  <div>
                      <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                          <i class="fas fa-exclamation-triangle me-1 animate-pulse"></i> Reported
                      </div>
                      <div class="fs-2 fw-bold text-danger">
                          <span class="count-up">3</span>
                      </div>
                  </div>
                  <i class="fas fa-bug fa-2x text-danger opacity-25 animate-float"></i>
              </div>
          </div>
          <div class="block-content py-2 bg-body-light">
              <p class="fw-medium fs-sm text-danger mb-0">
                  <i class="fas fa-arrow-up me-1"></i> Issues Reported
              </p>
          </div>
      </div>
  </div>

  <div class="col-6 col-lg-3">
      <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2"
           data-bs-toggle="tooltip" 
           data-bs-placement="top"
           title="Total Rejected Reports">
          <div class="block-content block-content-full p-3">
              <div class="d-flex align-items-center justify-content-between">
                  <div>
                      <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                          <i class="fas fa-times-circle me-1 animate-spin"></i> Rejected
                      </div>
                      <div class="fs-2 fw-bold text-warning">
                          <span class="count-up">3</span>
                      </div>
                  </div>
                  <i class="fas fa-ban fa-2x text-warning opacity-25 animate-float"></i>
              </div>
          </div>
          <div class="block-content py-2 bg-body-light">
              <p class="fw-medium fs-sm text-warning mb-0">
                  <i class="fas fa-arrow-up me-1"></i> Rejected Reports
              </p>
          </div>
      </div>
  </div>
</div>

      <style>@keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes slide {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(5px); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes tilt {
            0% { transform: perspective(1000px) rotateX(0deg) rotateY(0deg); }
            100% { transform: perspective(1000px) rotateX(2deg) rotateY(2deg); }
        }

        /* Animation Classes */
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-slide { animation: slide 2s ease-in-out infinite; }
        .animate-bounce { animation: bounce 1.5s ease-in-out infinite; }
        .animate-pulse { animation: pulse 1.5s infinite linear; }
        .animate-spin { animation: spin 2s linear infinite; }

        /* Block Styles */
        .block-link-pop {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.075);
            cursor: pointer;
        }

        .block-link-pop:hover {
            transform: perspective(1000px) rotateX(2deg) rotateY(2deg) scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .block-link-pop::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(255,255,255,0.1) 0%, 
                rgba(255,255,255,0.2) 50%, 
                rgba(255,255,255,0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .block-link-pop:hover::before {
            opacity: 1;
        }

        /* General Styles */
        .bg-body-extra-light {
            background-color: rgba(248,249,250,0.8);
            backdrop-filter: blur(10px);
        }

        .count-up {
            display: inline-block;
            font-variant-numeric: tabular-nums;
            min-width: 60px;
        }

        .row.mb-4 {
            margin-bottom: 1.5rem !important;
        }
        
        .row.mt-3 {
            margin-top: 1rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }
      </style>
      <!-- END Quick Overview -->



      <!-- All Products -->
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">All Orders</h3>
          <div class="block-options">
            <div class="dropdown">
              <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Filters <i class="fa fa-angle-down ms-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  Active Tickets
                  <span class="badge bg-success rounded-pill">260</span>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  Pending Tickets
                  <span class="badge bg-danger rounded-pill">24</span>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  Closed Tickets
                  <span class="badge bg-primary rounded-pill">14503</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="block-content">

          <!-- All Products Table -->
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="userorders-table"><thead><tr><th title="Id">Id</th><th title="Type">Type</th><th title="Price">Price</th><th title="Seller">Seller</th><th title="Website">Website</th><th title="Login">Login</th><th title="Pass">Pass</th><th title="Country">Country</th><th title="Status" width="10">Status</th><th title="Purshased">Purshased</th><th title="Creation Date">Creation Date</th><th title="Updated At">Updated At</th><th title="View" width="10%">View</th><th title="Report" width="15%">Report</th></tr></thead></table>
          </div>
          <!-- END All Products Table -->
        </div>
      </div>
    </div>
    <!-- END Page Content -->
  </main>
      </main>
      <!-- Footer -->
          <footer id="page-footer" class="bg-body-extra-light">
            <div class="content py-3">
              <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                  Page Loaded in 2.17 Seconds
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                  <a class="fw-semibold" href="../main/index.html" target="_blank">WaXa V1.0</a> &copy; <span data-toggle="year-copy"></span>
                </div>
              </div>
            </div>
          </footer>
          <!-- END Footer -->    </div>
