<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="/" class="">
                        <i class="bi bi-house"></i>
                        <span>Dashboards</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="bi bi-file-text"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('timesheet') }}">Timesheet</a></li>
                        <li><a href="{{ route('timeline') }}">Timeline</a></li>
                        <li><a href="{{ route('attendance') }}">Attendance</a></li>
                        <li><a href="{{ route('activity.level') }}">Activity Level</a></li>
                        <li><a href="{{ route('statistics') }}">statistics</a></li>
                        <li><a href="{{ route('activity.description') }}">Activity Description</a></li>
                        <li><a href="{{ route('task') }}">Task</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="bi bi-people"></i>
                        <span>People</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if (!AppHelper::getLoginUser()->hasRole(RolePermissionHelper::ADMIN['slug']))
                            <li><a href="{{ route('team.index') }}">All Team</a></li>
                        @endif
                        @permission('member_show')
                            <li><a href="{{ route('member.index') }}">Members</a></li>
                        @endpermission
                    </ul>
                </li>
                @if (!AppHelper::getLoginUser()->hasRole(RolePermissionHelper::ADMIN['slug']))
                    <li>
                        <a href="{{ route('project.index') }}" class="">
                            <i class="bi bi-briefcase"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('task.index') }}" class="">
                            <i class="bi bi-file-check"></i>
                            <span>Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('screenshot.index') }}" class="">
                            <i class="bi bi-file-image"></i>
                            <span>Screenshots</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="bi bi-clock-history"></i>
                        <span>Time Manager</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('time.request')}}">Time Requests
                            <badge class="badge badge-soft-danger fs-7 position-absolute rounded">125</badge>
                        </a></li>
                        <li><a href="{{route('edit.time')}}">Edit Time</a></li>
                    </ul>
                </li>
                @if (AppHelper::getLoginUser()->hasRole(RolePermissionHelper::ADMIN['slug']))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow ">
                            <i class="bi bi-building"></i>
                            <span>Company</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('company.index') }}">All Company List</a></li>
                            <li><a href="{{ route('company.createOrEdit') }}">Register Company</a></li>
                        </ul>
                    </li>
                @endif
                @if (AppHelper::getLoginUser()->hasRole(RolePermissionHelper::ADMIN['slug']) ||
                        AppHelper::getLoginUser()->hasRole(RolePermissionHelper::OWNER['slug']))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow ">
                            <i class="bi bi-person-lock"></i>
                            <span>Role & Permission</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('role') }}">Role</a></li>
                            <li><a href="{{ route('permission') }}">Permission</a></li>
                            <li><a href="{{ route('role-permission') }}">Role & Permission</a></li>
                        </ul>
                    </li>
                @endif
                @if (AppHelper::getLoginUser()->hasRole(RolePermissionHelper::OWNER['slug']))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow ">
                            <i class="bi bi-person-workspace"></i>
                            <span>Position</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('position.index') }}">Position</a></li>
                            <li><a href="{{ route('position.createOrEdit') }}">Add Position</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
