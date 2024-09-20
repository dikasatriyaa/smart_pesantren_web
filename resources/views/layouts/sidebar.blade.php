<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{asset('./assets/images/faces/face1.jpg')}}" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{auth()->user()->name}}</span>
            <span class="text-secondary text-small">Smart Pesantren</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      @can('admin')
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/user">
          <span class="menu-title">Data User</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Data Santri</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="/santri">Santri</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/aktivitas">Aktivitas Pendidikan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/akademik">Nilai</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/hafalan">Hafalan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/kesehatan">Kesehatan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/kitab">Kitab</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/pelanggaran">Pelanggaran</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/guru">
          <span class="menu-title">Data Ustadz/Ah</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/rombel">
          <span class="menu-title">Rombongan Belajar</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/mapel">
          <span class="menu-title">Mata Pelajaran</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/menu">
          <span class="menu-title">Data Menu</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/news">
          <span class="menu-title">News</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/pengumuman">
          <span class="menu-title">Pengumuman</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      @endcan

      @can('guru')
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Data Santri</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="/santri">Santri</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/aktivitas">Aktivitas Pendidikan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/akademik">Nilai</a>
            </li>
          </ul>
        </div>
      </li>
      @endcan

      @can('wali')
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Data Santri</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="/santri">Santri</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/kehadiran">Kehadiran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/hafalan">Hafalan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/kesehatan">Kesehatan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/pelanggaran">Pelanggaran</a>
            </li>
          </ul>
        </div>
      </li>
      @endcan

      <li class="nav-item">
        <a class="nav-link" href="/logout" target="_blank">
          <span class="menu-title">Log Out</span>
          <i class="mdi mdi-file-document-box menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>