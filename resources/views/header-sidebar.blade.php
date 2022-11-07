  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="{{route('home')}}" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">ANF115</span>
      </a>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">@auth {{Auth::user()->username}} @endauth</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>@auth{{Auth::user()->username}}@endauth</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar sesión</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    @if(Session::has('permisos'))

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{route('home')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @if(array_key_exists("ADMIN", Session::get('permisos')))
        @if(in_array("administrador", Session::get('permisos')['ADMIN']))
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Menu del admin</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('ratios')}}">
              <i class="bi bi-circle"></i><span>Ratios</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Parametros nacionales</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>etc.</span>
            </a>
          </li>
        </ul>
      </li>
        @endif
      @endif

      <li class="nav-heading">Pages</li>

      @if(array_key_exists("RATIOS", Session::get('permisos')))
        @if(in_array("ratios.ver", Session::get('permisos')['RATIOS']))
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{route('ratios')}}">
            <i class="bi bi-person"></i>
            <span>Ratios</span>
          </a>
        </li>
        @endif
      @endif

      @if(array_key_exists("ANALISIS_VERTICAL", Session::get('permisos')))
        @if(in_array("analisis.vertical.ver", Session::get('permisos')['ANALISIS_VERTICAL']))
        <li class="nav-item">
          <a class="nav-link collapsed" href="#">
            <i class="bi bi-question-circle"></i>
            <span>Análisis Vertical</span>
          </a>
        </li>
        @endif
      @endif
      
      @if(array_key_exists("ANALISIS_HORIZONTAL", Session::get('permisos')))
        @if(in_array("analisis.horizontal.ver", Session::get('permisos')['ANALISIS_HORIZONTAL']))
        <li class="nav-item">
          <a class="nav-link collapsed" href="#">
            <i class="bi bi-envelope"></i>
            <span>Análisis Horizontal</span>
          </a>
        </li>
        @endif
      @endif

      @if(array_key_exists("ESTADOS_FINANCIEROS", Session::get('permisos')))
        @if(in_array("estados.cargar", Session::get('permisos')['ESTADOS_FINANCIEROS']))
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{route('cargar-estados.show')}}">
            <i class="bi bi-journal"></i>
            <span>Cargar Estados Financieros</span>
          </a>
        </li>
        @endif
      @endif

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('logout')}}">
          <i class="bi bi-box-arrow-right"></i>
          <span>Cerrar Sesión</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

    @endif

  </aside><!-- End Sidebar-->