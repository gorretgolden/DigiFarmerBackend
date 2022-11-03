<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/home') }}" class="brand-link">
        <img src="https://cdn.pixabay.com/photo/2022/10/25/07/07/pumpkins-7545052__340.jpg"
             alt="{{ config('app.name') }} Logo"
             class="brand-image rounded">
        <span class="brand-text font-weight-light">Farm</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
