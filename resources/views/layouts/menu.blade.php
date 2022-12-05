<li class="nav-item-one nav-item">
    <a href="{{ url('/home') }}" class="waves-effect nav-link">
        <p>Dashboard</p>
    </a>

</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>User Management</p>
    </a>

    <ul class="menu-content" style="display: none">
        <li class="nav-item  menu-is-opening menu-open">
            <a href="{{ route('roles.index') }}" class="nav-link">
                <p>Roles</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('permissions.index') }}" class="nav-link">
                <p>Permissions</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('farmers.index') }}" class="nav-link">
                <p>Farmers</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('buyers.index') }}" class="nav-link">
                <p>Buyers</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('sellers.index') }}" class="nav-link">
                <p>Sellers</p>
            </a>
        </li>



    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-book mr-2" aria-hidden="true"></i>
        <p>Content Management</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('countries.index') }}" class="nav-link">
                <p>Countries</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('districts.index') }}" class="nav-link">
                <p>Districts</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('sliders.index') }}" class="nav-link">
                <p>Sliders</p>
            </a>
        </li>


    </ul>
</li>




<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
        <p>Crop Management</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
                <p>Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('subCategories.index') }}" class="nav-link">
                <p>Sub Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('crops.index') }}" class="nav-link">
                <p>Add Crops</p>
            </a>
        </li>




    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
        <p>Animal Management</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('animals.index') }}"
               class="nav-link {{ Request::is('animals*') ? 'active' : '' }}">
                <p>Animals</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('animalCategories.index') }}"
               class="nav-link {{ Request::is('animalCategories*') ? 'active' : '' }}">
                <p>Animal Categories</p>
            </a>
        </li>




    </ul>
</li>



<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-book mr-2" aria-hidden="true"></i>
        <p>Farm Management</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('farms.index') }}" class="nav-link">

                <p>Farms</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('plots.index') }}" class="nav-link">
                <p>Plots</p>
            </a>
        </li>


        <li class="nav-item-one nav-item">
            <a href="javascript:;" class="waves-effect nav-link ">
                <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
                <p>Task Management</p>
            </a>

            <ul class="menu-content" style="display: none">

                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}"
                       class="nav-link">
                        <p>Add Tasks</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('task-calender') }}"
                       class="nav-link">
                        <p>Task Calender</p>
                    </a>
                </li>



            </ul>
        </li>




        <li class="nav-item">
            <a href="{{ route('cropHarvests.index') }}" class="nav-link">
                <p>Crop Harvests</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('expenseCategories.index') }}" class="nav-link">
                <p>Expense Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('expenses.index') }}" class="nav-link">
                <p>Expenses</p>
            </a>
        </li>


    </ul>
</li>



<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
        <p>Manage Market</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('vendorCategories.index') }}" class="nav-link">
                <p>Vendor Categories</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('cropOnSales.index') }}" class="nav-link">
                <p>Crop On Sales</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('buyers.index') }}" class="nav-link">
                <p>Buyers</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('cropOrders.index') }}" class="nav-link">
                <p>Crop Orders</p>
            </a>
        </li>



    </ul>
</li>



<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Seller Vendor Services</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('sellerProductCategories.index') }}" class="nav-link">
                <p>Add Product Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('sellerProducts.index') }} " class="nav-link">
                <p>Add Seller Products</p>
            </a>
        </li>


    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Training Vendor Services</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('trainingVendorServices.index') }}" class="nav-link">
                <p>Add Traning Services</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('farmerTrainings.index') }}" class="nav-link">
                <p>Add Farmer Trainings</p>
            </a>
        </li>


    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Rent Vendor Services</p>
    </a>

    <ul class="menu-content" style="display: none">



        <li class="nav-item">
            <a href="{{ route('rentVendorCategories.index') }}"
               class="nav-link">
                <p>Add Rent Categories</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('rentVendorSubCategories.index') }}"
               class="nav-link">
                <p>Add Sub Categories</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('rentVendorServices.index') }}"
               class="nav-link ">
                <p>Add Rent Vendor Service</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('rentVendorImages.index') }}"
               class="nav-link">
                <p>View Rent Vendor Images</p>
            </a>
        </li>


    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Insuarance Services</p>
    </a>

    <ul class="menu-content" style="display: none">





        <li class="nav-item">
            <a href="{{ route('insuaranceVendorServices.index') }}"
               class="nav-link ">
                <p>Add Insuarance Services</p>
            </a>
        </li>






    </ul>
</li>

<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Animal Feeds</p>
    </a>

    <ul class="menu-content" style="display: none">



        <li class="nav-item">
            <a href="{{ route('animalFeedCategories.index') }}" class="nav-link">
                <p>Add Categories</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('animalFeedSubCategories.index') }}"
                class="nav-link">
                <p>Add Sub Categories</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('animalFeeds.index') }}"
                class="nav-link">
                <p>Add Animal Feeds</p>
            </a>
        </li>




    </ul>
</li>




<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-user mr-2" aria-hidden="true"></i>
        <p>Account</p>
    </a>

</li>

<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fas fa-cog mr-2"></i>
        <p>Settings</p>
    </a>

</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();""
        class="waves-effect nav-link ">
        <i class="fas fa-cog mr-2"></i>
        <p>Logout</p>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

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









