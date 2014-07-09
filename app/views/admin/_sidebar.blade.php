<div class="col-sm-3 col-md-2 sidebar">
    <div class="sidebar-panel">
        <ul class="nav nav-sidebar">
            <li class="@if (Request::path() == 'admin')active @endif">
                <a href="{{ route('dashboard') }}">
                    <span class="fa fa-dashboard fa-fw"></span>  @lang('dashboard::global.name')
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
