<!--
=========================================================
* Soft UI Dashboard 3 - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
  <title>
    Project Management System
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('css/soft-ui-dashboard.css?v=1.1.0')}}" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
    <div class="sidenav-header">
    @if (auth()->user()->role === 'admin')
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Project Management System</span>
      </a>
    </div>
    @else
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('staff.dashboard') }}">
        <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Project Management System</span>
      </a>
    </div>
    @endif
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="nav">
        {{-- Role-based Navigation --}}
        @if (auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-chart-line text-primary"></i>
                    </div>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ Request::is('admin/projects*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-project-diagram text-success"></i>
                    </div>
                    <span class="nav-link-text">All Projects</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ Request::is('admin/tasks*') ? 'active' : '' }}" href="{{ route('admin.tasks.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-tasks text-info"></i>
                    </div>
                    <span class="nav-link-text">All Tasks</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ Request::is('staff/dashboard') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-chart-line text-primary"></i>
                    </div>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            <!-- Projects Section -->
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#projectsCollapse" class="nav-link {{ Request::is('staff/projects*') || Request::is('staff/staff-projects*') ? 'active' : '' }}" aria-controls="projectsCollapse" role="button" aria-expanded="{{ Request::is('staff/projects*') || Request::is('staff/staff-projects*') ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-project-diagram text-success"></i>
                    </div>
                    <span class="nav-link-text">Projects</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ Request::is('staff/projects*') || Request::is('staff/staff-projects*') ? 'show' : '' }}" id="projectsCollapse">
                    <ul class="nav nav-sm flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('staff/projects*') && !Request::is('staff/staff-projects*') ? 'active' : '' }}" href="{{ route('staff.projects.index') }}">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                                    <i class="fas fa-folder text-success"></i>
                                </div>
                                <span class="nav-link-text">My Projects</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('staff/staff-projects*') ? 'active' : '' }}" href="{{ route('staff.staff-projects.index') }}">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                                    <i class="fas fa-users text-success"></i>
                                </div>
                                <span class="nav-link-text">Other Staff Projects</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Tasks Section -->
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tasksCollapse" class="nav-link {{ Request::is('staff/tasks*') || Request::is('staff/staff-tasks*') ? 'active' : '' }}" aria-controls="tasksCollapse" role="button" aria-expanded="{{ Request::is('staff/tasks*') || Request::is('staff/staff-tasks*') ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-tasks text-info"></i>
                    </div>
                    <span class="nav-link-text">Tasks</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ Request::is('staff/tasks*') || Request::is('staff/staff-tasks*') ? 'show' : '' }}" id="tasksCollapse">
                    <ul class="nav nav-sm flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('staff/tasks*') && !Request::is('staff/staff-tasks*') ? 'active' : '' }}" href="{{ route('staff.tasks.index') }}">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                                    <i class="fas fa-clipboard-list text-info"></i>
                                </div>
                                <span class="nav-link-text">My Tasks</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('staff/staff-tasks*') ? 'active' : '' }}" href="{{ route('staff.staff-tasks.index') }}">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                                    <i class="fas fa-tasks text-info"></i>
                                </div>
                                <span class="nav-link-text">Other Staff Tasks</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
      
        {{-- Common Profile Link --}}
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ Request::is('profile/edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                    <i class="fas fa-user-cog text-warning"></i>
                </div>
                <span class="nav-link-text">Profile</span>
            </a>
        </li>

        {{-- Logout --}}
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link bg-transparent border-0 d-flex align-items-center w-100">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2">
                        <i class="fas fa-sign-out-alt text-danger"></i>
                    </div>
                    <span class="nav-link-text">Log Out</span>
                </button>
            </form>
        </li>
    </ul>
</div>


  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->

    @php
    $routeName = Route::currentRouteName(); // e.g., 'projects.index'
    $baseName = explode('.', $routeName)[0]; // Get 'projects'
    $pageTitle = ucwords(str_replace('_', ' ', $baseName)); // 'projects' => 'Projects'
    @endphp

   
          
            
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center mb-2">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
           
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        @if(session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        </div>
        @endif
        @yield('content')

      <footer class="footer pt-3  ">

        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg ">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Soft UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn btn-primary w-100 px-3 mb-2 active" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn btn-primary w-100 px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3">
          <h6 class="mb-0">Navbar Fixed</h6>
        </div>
        <div class="form-check form-switch ps-0">
          <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/soft-ui-dashboard">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/soft-ui-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/soft-ui-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Soft%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/soft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS -->
  <script src="{{ asset ('js/core/popper.min.js')}}"></script>
  <script src="{{ asset ('js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset ('js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset ('js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{ asset ('js/plugins/chartjs.min.js')}}"></script>
  <script>
    var chartBarsCanvas = document.getElementById("chart-bars");
    if (chartBarsCanvas) {
      var ctx = chartBarsCanvas.getContext("2d");
      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Inter",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });
    }

    var chartLineCanvas = document.getElementById("chart-line");
    if (chartLineCanvas) {
      var ctx2 = chartLineCanvas.getContext("2d");
      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6
            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Inter",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Inter",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset ('js/soft-ui-dashboard.min.js?v=1.1.0')}}"></script>
  @stack('scripts')
</body>

</html>
