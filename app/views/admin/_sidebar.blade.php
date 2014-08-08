<div class="col-xs-6 col-sm-3 col-md-2 sidebar sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="sidebar-panel">
        <ul class="nav nav-sidebar">
            <li class="@if (Request::path() == 'admin')active @endif">
                <a href="{{ route('dashboard') }}">
                    <span class="icon fa fa-dashboard fa-fw"></span>
                    <div>@lang('dashboard::global.name')</div>
                </a>
            </li>
        </ul>
    </div>
    @include('admin._sidebar-menu', ['name' => 'admin-applications'])
    @include('admin._sidebar-menu', ['name' => 'admin-content'])
    @include('admin._sidebar-menu', ['name' => 'admin-media'])
    @include('admin._sidebar-menu', ['name' => 'admin-system'])
    @include('admin._sidebar-menu', ['name' => 'admin-users'])
</div>
