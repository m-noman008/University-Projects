<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        @if (Auth::user()->role == 'admin')
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                            <i data-feather="home" class="feather-icon text-indigo"></i>
                            <span class="hide-menu">@lang('Dashboard')</span>
                        </a>
                    </li>

                    @shop
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Product ')</span></li>
                        <li
                            class="sidebar-item {{ menuActive(
                                [
                                    'admin.product.category.list',
                                    'admin.product.category.create',
                                    'admin.product.category.edit*',
                                    'admin.product.attribute.list',
                                    'admin.product.attribute.create',
                                    'admin.product.attribute.edit*',
                                    'admin.product.list',
                                    'admin.product.create',
                                    'admin.product.edit*',
                                    'admin.product.stock.list',
                                    'admin.product.stock.create',
                                    'admin.product.stock.edit*',
                                    'admin.product.search',
                                    'admin.product.stock.search',
                                ],
                                3,
                            ) }}">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fab fa-product-hunt text-indigo"></i>
                                <span class="hide-menu">@lang('Manage Product')</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse first-level base-level-line {{ menuActive(
                                    [
                                        'admin.product.category.list',
                                        'admin.product.category.create',
                                        'admin.product.category.edit*',
                                        'admin.product.attribute.list',
                                        'admin.product.attribute.create',
                                        'admin.product.attribute.edit*',
                                        'admin.product.list',
                                        'admin.product.create',
                                        'admin.product.edit*',
                                        'admin.product.stock.list',
                                        'admin.product.stock.create',
                                        'admin.product.stock.edit*',
                                        'admin.product.search',
                                        'admin.product.stock.search',
                                    ],
                                    1,
                                ) }}">
                                <li
                                    class="sidebar-item {{ menuActive(['admin.product.category.list', 'admin.product.category.create', 'admin.product.category.edit*']) }}">
                                    <a href="{{ route('admin.product.category.list') }}"
                                        class="sidebar-link {{ menuActive(['admin.product.category.list', 'admin.product.category.create', 'admin.product.category.edit*']) }}">
                                        <span class="hide-menu">@lang('Category')</span>
                                    </a>
                                </li>

                                <li
                                    class="sidebar-item {{ menuActive(['admin.product.attribute.list', 'admin.product.attribute.create', 'admin.product.attribute.edit*']) }}">
                                    <a href="{{ route('admin.product.attribute.list') }}"
                                        class="sidebar-link {{ menuActive(['admin.product.attribute.list', 'admin.product.attribute.create', 'admin.product.attribute.edit*']) }}">
                                        <span class="hide-menu">@lang('Attribute')</span>
                                    </a>
                                </li>

                                <li
                                    class="sidebar-item {{ menuActive(['admin.product.list', 'admin.product.create', 'admin.product.list.edit*', 'admin.product.search']) }}">
                                    <a href="{{ route('admin.product.list') }}"
                                        class="sidebar-link {{ menuActive(['admin.product.list', 'admin.product.create', 'admin.product.list.edit*', 'admin.product.search']) }}">
                                        <span class="hide-menu">@lang('Products')</span>
                                    </a>
                                </li>

                                <li
                                    class="sidebar-item {{ menuActive(['admin.product.stock.list', 'admin.product.stock.create', 'admin.product.stock.edit*', 'admin.product.stock.search']) }}">
                                    <a href="{{ route('admin.product.stock.list') }}"
                                        class="sidebar-link {{ menuActive(['admin.product.stock.list', 'admin.product.stock.create', 'admin.product.stock.edit*', 'admin.product.stock.search']) }}">
                                        <span class="hide-menu">@lang('Stock')</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endshop


                    @bookAppointment
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">@lang('Book Appointment ')</span></li>

                        <li
                            class="sidebar-item {{ menuActive(['admin.appointment.list', 'admin.edit.appointment', 'admin.search.appointment'], 3) }}">
                            <a class="sidebar-link" href="{{ route('admin.appointment.list', 'all_list') }}"
                                aria-expanded="false">
                                <i class="fa fa-calendar-check text-orange"></i>
                                <span class="hide-menu">@lang('Appointment List')</span>
                            </a>
                        </li>
                    @endbookAppointment

                    @plan
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Plan')</span></li>

                        <li
                            class="sidebar-item {{ menuActive(['admin.plan.list', 'admin.plan.create', 'admin.plan.edit'], 3) }}">
                            <a class="sidebar-link" href="{{ route('admin.plan.list') }}" aria-expanded="false">
                                <i class="fas fa-outdent text-purple"></i>
                                <span class="hide-menu">@lang('Manage Plan')</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ menuActive(['admin.plan.sold.list', 'admin.search.plan.sold'], 3) }}">
                            <a class="sidebar-link" href="{{ route('admin.plan.sold.list') }}" aria-expanded="false">
                                <i class="fas fa-shopping-basket text-indigo"></i>
                                <span class="hide-menu">@lang('Plan Sold List')</span>
                            </a>
                        </li>
                    @endplan


                    @shop
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Product Order')</span></li>

                        <li
                            class="sidebar-item {{ menuActive(['admin.order.list', 'admin.order.product.info', 'admin.product.order.search'], 3) }}">
                            <a class="sidebar-link" href="{{ route('admin.order.list') }}" aria-expanded="false">
                                <i class="fa fa-cart-arrow-down text-orange"></i>
                                <span class="hide-menu">@lang('Order List')</span>
                            </a>
                        </li>
                    @endshop

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Services')</span></li>
                    @service
                        <li
                            class="sidebar-item {{ menuActive(['admin.service.list', 'admin.service.create', 'admin.service.edit*'], 3) }}">
                            <a class="sidebar-link" href="{{ route('admin.service.list') }}" aria-expanded="false">
                                <i class="fas fa-wrench text-red"></i>
                                <span class="hide-menu">@lang('Manage Service')</span>
                            </a>
                        </li>
                    @endservice

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('All Transaction ')</span></li>

                    <li class="sidebar-item {{ menuActive(['admin.transaction*'], 3) }}">
                        <a class="sidebar-link" href="{{ route('admin.transaction') }}" aria-expanded="false">
                            <i class="fas fa-exchange-alt text-purple"></i>
                            <span class="hide-menu">@lang('Transaction')</span>
                        </a>
                    </li>


                    {{-- Manage User --}}
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage User')</span></li>

                    <li
                        class="sidebar-item {{ menuActive(['admin.users', 'admin.users.search', 'admin.user-edit*', 'admin.send-email*', 'admin.user*'], 3) }}">
                        <a class="sidebar-link" href="{{ route('admin.users') }}" aria-expanded="false">
                            <i class="fas fa-users text-dark"></i>
                            <span class="hide-menu">@lang('All User')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.staff.list') }}" aria-expanded="false">
                            <i class="fas fa-users text-dark"></i>
                            <span class="hide-menu">Staff Management</span>
                        </a>
                    </li>


                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Payment Settings')</span></li>
                   <!--  <li
                        class="sidebar-item {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods'], 3) }}">
                        <a class="sidebar-link" href="{{ route('admin.payment.methods') }}" aria-expanded="false">
                            <i class="fas fa-credit-card text-red"></i>
                            <span class="hide-menu">@lang('Payment Methods')</span>
                        </a>
                    </li> -->



                    <li class="sidebar-item {{ menuActive(['admin.payment.log', 'admin.payment.search'], 3) }}">
                        <a class="sidebar-link" href="{{ route('admin.payment.log') }}" aria-expanded="false">
                            <i class="fas fa-history text-indigo"></i>
                            <span class="hide-menu">@lang('Payment Log')</span>
                        </a>
                    </li>


                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Support Tickets')</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket') }}" aria-expanded="false">
                            <i class="fas fa-ticket-alt text-info"></i>
                            <span class="hide-menu">@lang('All Tickets')</span>
                        </a>
                    </li>


                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Controls')</span></li>


                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.basic-controls') }}" aria-expanded="false">
                            <i class="fas fa-cogs text-primary"></i>
                            <span class="hide-menu">@lang('Basic Controls')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-envelope text-success"></i>
                            <span class="hide-menu">@lang('Email Settings')</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                            <li class="sidebar-item">
                                <a href="{{ route('admin.email-controls') }}" class="sidebar-link">
                                    <span class="hide-menu">@lang('Email Controls')</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('admin.email-template.show') }}" class="sidebar-link">
                                    <span class="hide-menu">@lang('Email Template') </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                  


                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Theme Settings')</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.logo') }}" aria-expanded="false">
                            <i class="fas fa-image text-purple text-orange"></i><span
                                class="hide-menu">@lang('Manage Logo')</span>
                        </a>
                    </li>






                    @team
                        <li
                            class="sidebar-item {{ menuActive(['admin.team.list', 'admin.team.create', 'admin.team.edit*'], 3) }}">
                            <a class="sidebar-link" href="{{ route('admin.team.list') }}" aria-expanded="false">
                                <i class="fas fa-user-plus text-teal"></i>
                                <span class="hide-menu">@lang('Manage Team')</span>
                            </a>
                        </li>
                    @endteam

                    @gallery
                        <li
                            class="sidebar-item {{ menuActive(['admin.gallery.tag.list', 'admin.gallery.items.list', 'admin.gallery.items.create', 'admin.gallery.items.edit*'], 3) }}">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-images text-success"></i>
                                <span class="hide-menu">@lang('Manage Gallery')</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse first-level base-level-line {{ menuActive(['admin.gallery.tag.list', 'admin.gallery.items.list', 'admin.gallery.items.create', 'admin.gallery.items.edit*'], 1) }}">
                                <li
                                    class="sidebar-item {{ menuActive(['admin.gallery.tag.list', 'admin.gallery.tag.create', 'admin.gallery.tag.edit*']) }}">
                                    <a href="{{ route('admin.gallery.tag.list') }}"
                                        class="sidebar-link {{ menuActive(['admin.gallery.tag.list', 'admin.gallery.tag.create', 'admin.gallery.tag.edit*']) }}">
                                        <span class="hide-menu">@lang('Gallery Tags')</span>
                                    </a>
                                </li>

                                <li
                                    class="sidebar-item {{ menuActive(['admin.gallery.items.list', 'admin.gallery.items.create', 'admin.gallery.items.edit*']) }}">
                                    <a href="{{ route('admin.gallery.items.list') }}"
                                        class="sidebar-link {{ menuActive(['admin.gallery.items.list', 'admin.gallery.items.create', 'admin.gallery.items.edit*']) }}">
                                        <span class="hide-menu">@lang('Gallery Items')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endgallery


                    @php
                        $segments = request()->segments();
                        $last = end($segments);
                    @endphp
                        <li class="list-divider"></li>
                </ul>
            </nav>
        @elseif (Auth::user()->role == 'appointer')
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
            @bookAppointment
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">@lang('Book Appointment ')</span></li>

                <li
                    class="sidebar-item {{ menuActive(['admin.appointment.list', 'admin.edit.appointment', 'admin.search.appointment'], 3) }}">
                    <a class="sidebar-link" href="{{ route('admin.appointment.list', 'all_list') }}"
                        aria-expanded="false">
                        <i class="fa fa-calendar-check text-orange"></i>
                        <span class="hide-menu">@lang('Appointment List')</span>
                    </a>
                </li>
            @endbookAppointment
        @elseif (Auth::user()->role == 'order_manager')
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
            @shop
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Product Order')</span></li>

                <li
                    class="sidebar-item {{ menuActive(['admin.order.list', 'admin.order.product.info', 'admin.product.order.search'], 3) }}">
                    <a class="sidebar-link" href="{{ route('admin.order.list') }}" aria-expanded="false">
                        <i class="fa fa-cart-arrow-down text-orange"></i>
                        <span class="hide-menu">@lang('Order List')</span>
                    </a>
                </li>
            @endshop
            </ul>
        </nav>
        @endif
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
