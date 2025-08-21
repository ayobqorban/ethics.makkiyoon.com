<nav
            class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme container-fluid"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                    <span class="d-none d-md-inline-block text-muted ">مرحبا: {{auth()->check() ? auth()->user()->name :'بالضيف'}}</span>
                  </a>
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Language -->
                <!-- /Language -->
                <!-- Style Switcher -->
                <!-- / Style Switcher-->

                <!-- Notification -->
                <!--/ Notification -->
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{auth()->check() ? auth()->user()->image?asset('storage/'.auth()->user()->image):asset('assets/default.png') :asset('assets/default.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.html">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{auth()->check() ? auth()->user()->image?asset('storage/'.auth()->user()->image):asset('assets/default.png') :asset('assets/default.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-medium d-block">{{auth()->check() ? auth()->user()->name :'مرحبا: بالضيف'}}</span>
                            <small class="text-muted">{{auth()->check() ? auth()->user()->job :''}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    @if(auth()->check())
                    <li>
                      <a class="dropdown-item" href="/users/{{auth()->user()->id}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">حسابي</span>
                      </a>
                    </li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('logout')}}" target="_blank">
                        <form action="{{ route('logout') }}" method="post">
                        <i class="bx bx-power-off me-2"></i>
                            @csrf
                            <button type="submit" class="btn align-middle">تسجيل الخروج</button>
                        </form>
                    </a>
                </li>
            </ul>
            @endif
        </li>
                <!--/ User -->
              </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
              <input
                type="text"
                class="form-control search-input container-xxl border-0"
                placeholder="Search..."
                aria-label="Search..." />
              <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
            </div>
          </nav>
