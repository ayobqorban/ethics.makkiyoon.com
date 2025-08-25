<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <img class="img-fluid p-3" src="{{asset('/assets/logo.png')}}" alt="">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="/" class="menu-link ">
                <i class="menu-icon fa-solid fa-house"></i>
                <div class="text-truncate">الرئيسية</div>
            </a>
        </li>
        <li class="menu-item open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-certificate p-2"></i>
                <div class="text-truncate">الاختبارات والنتائج</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('all.examps.index')}}" class="menu-link">
                        <div class="text-truncate">جميع الاختبارات</div>
                    </a>
                </li>
                {{-- <li class="menu-item">
                    <a href="{{route('employee.forms.index')}}" class="menu-link">
                        <div class="text-truncate">الاختبارات</div>
                    </a>
                </li> --}}
            </ul>
        </li>
    @if(auth()->user()->is_admin)
        <li class="menu-item open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-certificate p-2"></i>
                <div class="text-truncate"> النماذج والمشاركات </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('forms.index')}}" class="menu-link">
                        <div class="text-truncate">نماذج الميثاق</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('gf_forms.index')}}" class="menu-link">
                        <div class="text-truncate">نماذج عامة</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('result.index')}}" class="menu-link">
                        <div class="text-truncate">النتائج</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-certificate p-2"></i>
                <div class="text-truncate"> الأسئلة والخيارات </div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('questions.index')}}" class="menu-link">
                        <div class="text-truncate">أسئلة الميثاق</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('gf_questions.index')}}" class="menu-link">
                        <div class="text-truncate">أسئلة عامة</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-certificate p-2"></i>
                <div class="text-truncate">الشهادات</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('certificate.index')}}" class="menu-link">
                        <div class="text-truncate">إدارة الشهادات</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item open">
            <a  class="menu-link menu-toggle">
                <i class="fa-solid fa-certificate p-2"></i>
                <div class="text-truncate">المستخدمين</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/users/member" class="menu-link">
                        <div class="text-truncate">الموظفين</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/users/trainee" class="menu-link">
                        <div class="text-truncate">المتدربين</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/users/admin" class="menu-link">
                        <div class="text-truncate">الإدارة</div>
                    </a>
                </li>
            </ul>

        </li>
    @endif
    </ul>
</aside>

