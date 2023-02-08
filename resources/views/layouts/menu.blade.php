<li class="nav-item-one nav-item">
    <a href="{{ url('/home') }}" class="waves-effect nav-link">
        <i class="fa fa-home mr-2" aria-hidden="true"></i>
        <p class="ml-2">Dashboard</p>
    </a>

</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p class="ml-2">Users</p>
    </a>

    <ul class="menu-content" style="display: none">
        <li class="nav-item  menu-is-opening menu-open">
            <a href="{{ route('roles.index') }}" class="nav-link">
                <i class="fa fa-user mr-2" aria-hidden="true"></i>
                <p>Roles</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('permissions.index') }}" class="nav-link">
                <i class="fa fa-ban mr-2" aria-hidden="true"></i>
                <p>Permissions</p>
            </a>
        </li>



        <li class="nav-item">
            <a href="{{ route('farmers.index') }}" class="nav-link">
                <i class="fa fa-users mr-2" aria-hidden="true"></i>
                <p>Farmers</p>
            </a>
        </li>


        {{-- <li class="nav-item">
            <a href="{{ route('buyers.index') }}" class="nav-link">
                <p>Buyers</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('sellers.index') }}" class="nav-link">
                <p>Vendors</p>
            </a>
        </li> --}}



    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-book mr-2" aria-hidden="true"></i>
        <p class="ml-2">Content</p>
    </a>


    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('countries.index') }}" class="nav-link">
                <p>Countries</p>
            </a>
        </li>




        {{-- <li class="nav-item">
            <a href="{{ route('regions.index') }}"
               class="nav-link {{ Request::is('regions*') ? 'active' : '' }}">
                <p>Regions</p>
            </a>
        </li> --}}


        <li class="nav-item">
            <a href="{{ route('addresses.index') }}"
               class="nav-link">
                <p>Addresses</p>
            </a>
        </li>


        {{-- <li class="nav-item">
            <a href="{{ route('days.index') }}" class="nav-link">
                <p>Days</p>
            </a>
        </li> --}}

        <li class="nav-item">
            <a href="{{ route('loanPlans.index') }}" class="nav-link ">
                <p>Loan Plans</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('loanPayBacks.index') }}" class="nav-link">
                <p>Loan Pay Backs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('statuses.index') }}" class="nav-link ">
                <p>Statuses</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sliders.index') }}" class="nav-link">
                <p>Sliders</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('onboardings.index') }}" class="nav-link ">
                <p>Onboardings</p>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a href="{{ route('periodUnits.index') }}" class="nav-link ">
                <p>Period Units</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('commissions.index') }}" class="nav-link ">
                <p>Commissions</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('userVerifications.index') }}"
               class="nav-link ">
                <p>User Verifications</p>
            </a>
        </li>

    </ul>
</li>





<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
        <p class="ml-2">Crops</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
                <p>Add Categories</p>
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
        <p class="ml-2">Animals</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('animalCategories.index') }}" class="nav-link ">
                <p>Animal Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('animals.index') }}" class="nav-link">
                <p>Add Animals</p>
            </a>
        </li>






    </ul>
</li>



<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-book mr-2" aria-hidden="true"></i>
        <p class="ml-2">Farm</p>
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

                <p>Tasks</p>
            </a>

            <ul class="menu-content" style="display: none">

                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link">
                        <p>Add Tasks</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('task-calender') }}" class="nav-link">
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
        <p class="ml-2">Market</p>
    </a>

    <ul class="menu-content" style="display: none">



        <li class="nav-item">
            <a href="{{ route('cropOnSales.index') }}" class="nav-link">
                <p>Crop On Sales</p>
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
        <p class="ml-2"> Vendors</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('vendorCategories.index') }}" class="nav-link">
                <p>Vendor Categories</p>
            </a>
        </li>



        <li class="nav-item-one nav-item">
            <a href="javascript:;" class="waves-effect nav-link ">
                <i class="fa fa-users mr-2" aria-hidden="true"></i>
                <p>Seller Vendors</p>
            </a>

            <ul class="menu-content" style="display: none">

                <li class="nav-item">
                    <a href="{{ route('sellerProductCategories.index') }}"
                       class="nav-link ">
                        <p>Add  Categories</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('sellerProducts.index') }} " class="nav-link">
                        <p>Add Products</p>
                    </a>
                </li>


            </ul>
        </li>
        <li class="nav-item-one nav-item">
            <a href="javascript:;" class="waves-effect nav-link ">
                <i class="fa fa-users mr-2" aria-hidden="true"></i>
                <p>Training Vendors</p>
            </a>

            <ul class="menu-content" style="display: none">

                <li class="nav-item">
                    <a href="{{ route('trainingVendorServices.index') }}" class="nav-link">
                        <p>Add Trainings</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('farmerTrainings.index') }}" class="nav-link">
                        <p>Register Farmers </p>
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
            <a href="{{ route('animalFeeds.index') }}" class="nav-link">
                <p>Add Animal Feeds</p>
            </a>
        </li>




    </ul>
</li>

        <li class="nav-item-one nav-item">
            <a href="javascript:;" class="waves-effect nav-link ">
                <i class="fa fa-users mr-2" aria-hidden="true"></i>
                <p>Rent Vendors</p>
            </a>

            <ul class="menu-content" style="display: none">



                <li class="nav-item">
                    <a href="{{ route('rentVendorCategories.index') }}" class="nav-link">
                        <p>Add Categories</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('rentVendorSubCategories.index') }}"
                       class="nav-link">
                        <p>Add Sub Categories</p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('rentVendorServices.index') }}" class="nav-link ">
                        <p>Add Rent Vendors</p>
                    </a>
                </li>
{{--
                <li class="nav-item">
                    <a href="{{ route('rentVendorImages.index') }}" class="nav-link">
                        <p>Rent Vendor Images</p>
                    </a>
                </li> --}}


            </ul>
        </li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Insuarance Services</p>
    </a>

    <ul class="menu-content" style="display: none">





        <li class="nav-item">
            <a href="{{ route('insuaranceVendorServices.index') }}" class="nav-link ">
                <p>Add Insuarances</p>
            </a>
        </li>


    </ul>
</li>




<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Finance Vendors</p>
    </a>

    <ul class="menu-content" style="display: none">
        <li class="nav-item">
            <a href="{{ route('financeVendorCategories.index') }}" class="nav-link">
                <p>Add  Categories</p>
            </a>
        </li>




        <li class="nav-item">
            <a href="{{ route('finaceVendorServices.index') }}" class="nav-link">
                <p>Add Finance Vendor</p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Agronomist Services</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('agronomistVendorServices.index') }}"
               class="nav-link ">
               <p>Add Agronomist</p>
            </a>
        </li>




        <li class="nav-item">
            <a href="{{ route('agronomistShedules.index') }}"
               class="nav-link">
                <p>Agronomist Shedules</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('agronomistSlots.index') }}"
               class="nav-link">
                <p>Agronomist Slots</p>
            </a>
        </li>



    </ul>
</li>

<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-users mr-2" aria-hidden="true"></i>
        <p>Veterinary Services</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('veterinaries.index') }}"
               class="nav-link">
                <p>Add  Vet service</p>
            </a>
        </li>




        <li class="nav-item">
            <a href="{{ route('veterinaryShedules.index') }}"
               class="nav-link">
                <p>Veterinary Shedules</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('veterinarySlots.index') }}"
               class="nav-link">
                <p>Veterinary Slots</p>
            </a>
        </li>



    </ul>
</li>


    </ul>
</li>












<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-question mr-2" aria-hidden="true"></i>
        <p class="ml-2">Faqs</p>
    </a>

    <ul class="menu-content" style="display: none">


        <li class="nav-item">
            <a href="{{ route('faqCategories.index') }}" class="nav-link ">
                <p>Add Faq Categories</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('faqs.index') }}" class="nav-link ">
                <p>Add Faqs</p>
            </a>
        </li>



    </ul>
</li>



<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-question mr-2" aria-hidden="true"></i>
        <p class="ml-2">Terms & Policies</p>
    </a>

    <ul class="menu-content" style="display: none">

        <li class="nav-item">
            <a href="{{ route('terms.index') }}" class="nav-link">
                <p>Terms</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('privacyPolicies.index') }}" class="nav-link ">
                <p>Privacy Policies</p>
            </a>
        </li>




    </ul>
</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" class="waves-effect nav-link ">
        <i class="fa fa-user mr-2" aria-hidden="true"></i>
        <p class="ml-2">Account</p>
    </a>

</li>


<li class="nav-item-one nav-item">
    <a href="{{ route('general-settings') }}" class="waves-effect nav-link ">
        <i class="fas fa-cog mr-2"></i>
        <p class="ml-2">Settings</p>
    </a>

</li>


<li class="nav-item-one nav-item">
    <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();""
        class="waves-effect nav-link ">
        <i class="fas fa-cog mr-2"></i>
        <p class="ml-2">Logout</p>
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

















