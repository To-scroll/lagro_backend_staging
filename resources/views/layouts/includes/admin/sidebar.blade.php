<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box" style="background-color: #ee1b24;">
        <!-- Dark Logo-->
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('public/logo/logo_black2.png')}}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{asset('public/logo/logo_black9.jpg')}}" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('public/logo/logo_black2.png')}}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{asset('public/logo/logo_black9.jpg')}}" alt="" height="80">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu">Menu</span>
                </li>
               
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                            <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboard</span>
                        </a>
                       
                       
                    </li>
                    
                 
                
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="mdi mdi-badge-account"></i> <span data-key="t-dashboards">Badge</span>
                        </a>
                        <div class="collapse menu-dropdown {{(request()->is('badge') || request()->is('badge/*')) ? 'show' : '' }}" id="sidebarDashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('badge.index')}}" class="nav-link {{ request()->is('badge') ? 'active' : '' }}" data-key="t-analytics">Badge List  </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('badge.create')}}" class="nav-link {{ request()->is('badge/create') ? 'active' : '' }}" data-key="t-analytics"> Create Badge  </a>
                                </li>
                            </ul>
                        </div>
                       
                    </li> 
                   <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarCategory" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCategory">
                            <i class="bx bx-category"></i> <span data-key="t-dashboards">Product Category</span>
                        </a>
                        <div class="collapse menu-dropdown {{ (request()->is('category') || request()->is('category/*') || request()->is('category-discount') || request()->is('category-discount/*')) ? 'show' : '' }}" id="sidebarCategory">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}" class="nav-link {{ request()->is('category') ? 'active' : '' }}" data-key="t-analytics">Category List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('category.create') }}" class="nav-link {{ request()->is('category/create') ? 'active' : '' }}" data-key="t-analytics">Create Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('category-discount.index') }}" class="nav-link {{ request()->is('category-discount') ? 'active' : '' }}" data-key="t-analytics">Category Discounts</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('category-discount.create') }}" class="nav-link {{ request()->is('category-discount/create') ? 'active' : '' }}" data-key="t-analytics">Apply Discount</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAttributes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAttributes">
                            <i class="bx bx-scatter-chart"></i> <span data-key="t-dashboards">Attributes</span>
                        </a>
                        <div class="collapse menu-dropdown {{(request()->is('attributes') || request()->is('attributes/*')) ? 'show' : '' }}" id="sidebarAttributes">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('attributes.index')}}" class="nav-link {{ request()->is('attributes') ? 'active' : '' }}" data-key="t-analytics">Attribute List  </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('attributes.create')}}" class="nav-link {{ request()->is('attributes/ceate') ? 'active' : '' }}" data-key="t-analytics"> Create Attribute  </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAttributeOptions" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAttributeOptions">
                            <i class="bx bx-border-top"></i> <span data-key="t-dashboards">Attribute Options</span>
                        </a>
                        <div class="collapse menu-dropdown {{(request()->is('attribute-options') || request()->is('attribute-options/*')) ? 'show' : '' }}" id="sidebarAttributeOptions">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('attribute-options.index')}}" class="nav-link {{ request()->is('attribute-options') ? 'active' : '' }}" data-key="t-analytics">Attribute Options List  </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('attribute-options.create')}}" class="nav-link {{ request()->is('attribute-options/create') ? 'active' : '' }}" data-key="t-analytics"> Create Attribute Option  </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                            <i class="bx bxl-product-hunt"></i> <span data-key="t-dashboards">Products</span>
                        </a>
                        <div class="collapse menu-dropdown {{(request()->is('product') || request()->is('product/*')) ? 'show' : '' }}" id="sidebarProducts">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('product.index')}}" class="nav-link {{ request()->is('product') ? 'active' : '' }}" data-key="t-analytics">Products List  </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('product.create')}}" class="nav-link {{ request()->is('product/create') ? 'active' : '' }}"  data-key="t-analytics">Create  Product   </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('orders') ? 'active' : '' }}" href="{{route('orders.index')}}">
                            <i class="mdi mdi-file-search-outline"></i> <span data-key="t-dashboards">Orders</span>
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('invoice') ? 'active' : '' }}" href="{{ route('invoice.index')}}">
                            <i class="mdi mdi-file-star"></i> <span data-key="t-dashboards">Invoice</span>
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->is('offers') ? 'active' : '' }}" href="{{ route('offers.index') }}">
                            <i class="bx bx-purchase-tag"></i> <span data-key="t-dashboards">Discount-Offers</span>
                        </a>
                    </li>
        
                    @php
                        $webActive = request()->is('banner*') ||
                                     
                                     request()->is('general-faq*') ||
                                     request()->is('testimonial*') ||
                                     request()->is('customers*') ||
                                     request()->is('settings*') ||
                                     request()->is('cms*') ||
                                     request()->is('locations*')||
                                     request()->is('blog*');
                    @endphp
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $webActive ? 'active' : '' }}" href="#sidebarWeb" data-bs-toggle="collapse" role="button" aria-expanded="{{ $webActive ? 'true' : 'false' }}" aria-controls="sidebarWeb">
                            <i class="bx bx-world"></i> <span data-key="t-dashboards">Web</span>
                        </a>
                        <div class="collapse menu-dropdown {{ $webActive ? 'show' : '' }}" id="sidebarWeb">
                            <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                        
                                    <a class="nav-link menu-link {{ request()->is('banner') ? 'active' : '' }}" href="{{ route('banner.index') }}">
                                        <i class="bx bx-image-add"></i> <span data-key="t-dashboards">Banners</span>
                                    </a>
                                    
                                </li>
                                {{--
                                <li class="nav-item">
                                    
                                    <a class="nav-link menu-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                                        <i class=" bx bxs-contact"></i> <span data-key="t-dashboards">Contact Us</span>
                                    </a>
                                    
                                </li>
                                --}}
                                <li class="nav-item">
                                    
                                    <a class="nav-link menu-link {{ request()->is('general-faq') ? 'active' : '' }}" href="{{ url('general-faq')}}">
                                        <i class="mdi mdi-frequently-asked-questions"></i> <span data-key="t-dashboards">Faq</span>
                                    </a>
                                    
                                </li>
                                <li class="nav-item">
                                    
                                    <a class="nav-link menu-link {{ request()->is('testimonial') ? 'active' : '' }}" href="{{ route('testimonial.index') }}">
                                        <i class="mdi mdi-chat-plus"></i> <span data-key="t-dashboards">Testimonial</span>
                                    </a>
                                    
                                </li>
                                <li class="nav-item">
                                    
                                    <a class="nav-link menu-link {{ request()->is('settings') ? 'active' : '' }}" href="{{ route('customers.index')}}">
                                        <i class="mdi mdi-account-group"></i> <span data-key="t-dashboards">Customers</span>
                                    </a>
                                    
                                </li>
                                
                                <li class="nav-item">
                                    
                                    <a class="nav-link menu-link {{ request()->is('settings') ? 'active' : '' }}" href="{{ route('settings.index')}}">
                                        <i class="bx bxl-product-hunt"></i> <span data-key="t-dashboards">Settings</span>
                                    </a>
                                    
                                </li>
                                 <li class="nav-item">
                        
                                    <a class="nav-link menu-link {{ request()->is('cms') ? 'active' : '' }}" href="{{ url('cms')}}">
                                        <i class="bx bx-notepad"></i> <span data-key="t-dashboards">Pages</span>
                                    </a>
                                    
                                </li>
                                 <li class="nav-item">
                        
                                    <a class="nav-link menu-link {{ request()->is('locations') ? 'active' : '' }}" href="{{ route('locations.index') }}">
                                        <i class="bx bx-map"></i> <span data-key="t-dashboards">Store-Locations</span>
                                    </a>
                                    
                                </li>
                                <li class="nav-item">
                        
                                    <a class="nav-link menu-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ url('blog')}}">
                                        <i class="bx bx-notepad"></i> <span data-key="t-dashboards">Blogs</span>
                                    </a>
                                    
                                </li>
                                
                            </ul>
                        </div>
                    </li>
                    
                    
                    
                    {{--
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSettings">
                            <i class="bx bxl-product-hunt"></i> <span data-key="t-dashboards">Settings</span>
                        </a>
                        <div class="collapse menu-dropdown {{(request()->is('settings') || request()->is('settings/*')) ? 'show' : '' }}" id="sidebarSettings">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('settings.index')}} " class="nav-link" data-key="t-analytics">Settings </a>
                                </li>
                               
                               <li class="nav-item">
                                    <a href="{{url('store-settings')}}" class="nav-link" data-key="t-analytics">Store Settings   </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="{{url('email-settings')}}" class="nav-link" data-key="t-analytics">Email Settings   </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    --}}
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('sales-report') ? 'active' : '' }}" href="{{ route('sales-report')}}">
                            <i class="bx bxs-cloud-download"></i> <span data-key="t-dashboards">Sales Report</span>
                        </a>
                        
                    </li>
                   
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('configuration') ? 'active' : '' }}"  href="{{ url('configuration')}}">
                            <i class="mdi mdi-cookie-settings"></i> <span data-key="t-dashboards">Configuration</span>
                        </a>
                        
                    </li>
                    {{--
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarGroups" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarGroups">
                            <i class="mdi mdi-ungroup"></i> <span data-key="t-dashboards">Groups</span>
                        </a>
                        <div class="collapse menu-dropdown {{(request()->is('groups') || request()->is('groups/*')) ? 'show' : '' }}" id="sidebarGroups">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{url('groups')}}" class="nav-link {{ request()->is('groups') ? 'active' : '' }}" data-key="t-analytics">Groups List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('groups.create')}}" class="nav-link {{ request()->is('groups/create') ? 'active' : '' }}" data-key="t-analytics">Create Group </a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>
                    --}}
                    {{--
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('coupons') ? 'active' : '' }}" href="{{ url('coupons')}}">
                            <i class="bx bxs-coupon"></i> <span data-key="t-dashboards">Coupons</span>
                        </a>
                        
                    </li>
                    --}}
                    <li class="nav-item">
                        
                        <a class="nav-link menu-link {{ request()->is('reviews') ? 'active' : '' }}" href="{{ url('reviews')}}">
                            <i class="mdi mdi-view-carousel"></i> <span data-key="t-dashboards">Reviews</span>
                        </a>
                        
                    </li>
             
                
                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>