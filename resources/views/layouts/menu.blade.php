<li class="nav-item-one nav-item">
    <a href="{{url('/home')}}" class="waves-effect nav-link">
        <p>Dashboard</p>
    </a>

</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>User Management</p>
    </a>

    <ul class="menu-content" style="display: none">
        <li class="nav-item  menu-is-opening menu-open">
            <a href="{{ route('roles.index') }}">
                <p>Roles</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('permissions.index') }}">
                <p>Permissions</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('farmers.index') }}">
                <p>Farmers</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{url('buyers') }}">
                <p>Buyers</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('sellers.index') }}">
                <p>Sellers</p>
            </a>
        </li>



    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa fa-book mr-2" aria-hidden="true"></i>
        <p>Content</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('countries.index') }}">
                <p>Countries</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('districts.index') }}">
                <p>Districts</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('sliders.index') }}">
                <p>Sliders</p>
            </a>
        </li>


    </ul>
</li>




<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
        <p>Categories</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('categories.index') }}">
                <p>Categories</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('expenseCategories.index') }}">
                <p>Expense Categories</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('subCategories.index') }}">
                <p>Sub Categories</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('vendorCategories.index') }}">
                <p>Vendor Categories</p>
            </a>
        </li>

    </ul>
</li>

<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa-solid fa-cow  mr-2" aria-hidden="true"></i>
        <p>My Farm</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('farms.index') }}">
                <i class="fas fa-flower mr-2" aria-hidden="true"></i>
                <p>Farms</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('plots.index') }}" >
                <p>Plots</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('crops.index') }}" >
                <p>Crops</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('expenses.index') }}" >
                <p>Expenses</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('sellerProducts.index') }} "
           >
                <p>Seller Products</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('cropOnSales.index') }}"
            >
                <p>Crop On Sales</p>
            </a>
        </li>




        <li class="nav-item">
            <a href="{{ route('traningVendorServices.index') }}"
             >
                <p>Traning Vendor Services</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('farmerTrainings.index') }}"
               >
                <p>Farmer Trainings</p>
            </a>
        </li>


    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Seller Vendor Services</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('sellerProductCategories.index') }}">
                <p>Seller Product Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('sellerProducts.index') }} "
           >
                <p>Seller Products</p>
            </a>
        </li>


    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Training Vendor Services</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('traningVendorServices.index') }}"
             >
                <p>Traning Vendor Services</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('farmerTrainings.index') }}"
               >
                <p>Farmer Trainings</p>
            </a>
        </li>


    </ul>
</li>




<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fa fa-user mr-2" aria-hidden="true"></i>
        <p>Account</p>
    </a>

</li>

<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link {{ Request::is('farmerTrainings*') ? 'active' : '' }}">
        <i class="fas fa-cog mr-2"></i>
        <p>Settings</p>
    </a>

</li>












<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript">
    $(".nav-item-one").click(function() {
        $(".menu-content-two").hide();
        $("ul", this).toggle("slow");
    });

    //$('.menu-content-two').hide();

    $(".nav-item-two").click(function() {
        $(".menu-content").hide();
        $("ul", this).toggle("slow");
    });
</script>
<li class="nav-item">
    <a href="{{ route('cropHarvests.index') }}"
       class="nav-link {{ Request::is('cropHarvests*') ? 'active' : '' }}">
        <p>Crop Harvests</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('cropOrders.index') }}"
       class="nav-link {{ Request::is('cropOrders*') ? 'active' : '' }}">
        <p>Crop Orders</p>
    </a>
</li>


