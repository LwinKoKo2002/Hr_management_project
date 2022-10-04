<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <span>Ninja Hr</span>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <a class="user-pic" href="{{route('profile')}}">
                <img class="img-responsive img-rounded" src="{{auth()->user()->profile_image_path()}}"
                    alt="User picture">
            </a>
            <div class="user-info">
                <span class="user-name">
                    {{auth()->user()->name}}
                </span>
                <span class="user-role">{{auth()->user()->department ? auth()->user()->department->name : '-' }}</span>
                <span class="user-status">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                </span>
            </div>
        </div>
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>Menu</span>
                </li>
                <li>
                    <a href="{{route('home')}}">
                        <i class="fa-sharp fa-solid fa-house-chimney"></i>
                        <span style="font-size: 16px">Home</span>
                    </a>
                </li>
                @can('view_company_setting')
                <li>
                    <a href="{{route('company-setting.index')}}">
                        <i class="fa-solid fa-building"></i>
                        <span style="font-size: 16px">Company Setting</span>
                    </a>
                </li>
                @endcan
                @can('view_employee')
                <li>
                    <a href="{{route('employee.index')}}">
                        <i class="fa fa-users"></i>
                        <span style="font-size: 16px">Employees</span>
                    </a>
                </li>
                @endcan
                @can('view_department')
                <li>
                    <a href="{{route('department.index')}}">
                        <i class="fa-solid fa-code-merge"></i>
                        <span style="font-size: 16px">Department</span>
                    </a>
                </li>
                @endcan
                @can('view_role')
                <li>
                    <a href="{{route('roles.index')}}">
                        <i class="fa-solid fa-user-shield"></i>
                        <span style="font-size: 16px">Role</span>
                    </a>
                </li>
                @endcan
                @can('view_permission')
                <li>
                    <a href="{{route('permission.index')}}">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span style="font-size: 16px">Permission</span>
                    </a>
                </li>
                @endcan
                @can('view_project')
                <li>
                    <a href="{{route('project.index')}}">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <span style="font-size: 16px">Project</span>
                    </a>
                </li>
                @endcan
                @can('view_attendence')
                <li>
                    <a href="{{route('attendence.index')}}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span style="font-size: 16px">Attendence</span>
                    </a>
                </li>
                @endcan
                @can('view_attendance_overview')
                <li>
                    <a href="{{route('attendance.overview')}}">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span style="font-size: 16px">Attendence overview</span>
                    </a>
                </li>
                @endcan
                @can('view_salary')
                <li>
                    <a href="{{route('salary.index')}}">
                        <i class="fa-solid fa-money-bill"></i>
                        <span style="font-size: 16px">Salary</span>
                    </a>
                </li>
                @endcan
                @can('view_salary_overView')
                <li>
                    <a href="{{route('overview.salary')}}">
                        <i class="fa-solid fa-money-check"></i>
                        <span style="font-size: 16px">Salary overview</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>