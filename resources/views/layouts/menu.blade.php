<li class="nav-item">
    <a href="{{ route('roles.index') }}"
       class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
        <p>Roles</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('permissions.index') }}"
       class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
        <p>Permissions</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('sliders.index') }}"
       class="nav-link {{ Request::is('sliders*') ? 'active' : '' }}">
        <p>Sliders</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('countries.index') }}"
       class="nav-link {{ Request::is('countries*') ? 'active' : '' }}">
        <p>Countries</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('districts.index') }}"
       class="nav-link {{ Request::is('districts*') ? 'active' : '' }}">
        <p>Districts</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('farms.index') }}"
       class="nav-link {{ Request::is('farms*') ? 'active' : '' }}">
        <p>Farms</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('categories.index') }}"
       class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
        <p>Categories</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('crops.index') }}"
       class="nav-link {{ Request::is('crops*') ? 'active' : '' }}">
        <p>Crops</p>
    </a>
</li>


