<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/themes/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><span class="hidden-xs">{{ Auth::user()->getAuthIdentifierName() }}</span></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tags"></i>
                    <span>Products</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.category.index')}}"><i class="fa fa-circle-o"></i> Categories</a></li>
                    <li><a href="{{route('admin.product.index')}}"><i class="fa fa-circle-o"></i> Products</a></li>
                    <li><a href="{{route('admin.manufacturer.index')}}"><i class="fa fa-circle-o"></i> Manufacturers</a></li>
                    {{--<li><a href="{{route('admin.shipper.index')}}"><i class="fa fa-circle-o"></i> Shippers</a></li>--}}
                    <li><a href="{{route('admin.shipFee.index')}}"><i class="fa fa-circle-o"></i> Ship Fee</a></li>
                    <li><a href="{{route('admin.supplier.index')}}"><i class="fa fa-circle-o"></i> Suppliers</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Sales</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.order.index')}}"><i class="fa fa-circle-o"></i> Orders</a></li>
                    <li><a href="{{route('admin.profit.index')}}"><i class="fa fa-circle-o"></i> Profit</a></li>
                    <li><a href="{{route('admin.profit.debt')}}"><i class="fa fa-circle-o"></i> Debt</a></li>
                    <li><a href="{{route('admin.customer.index')}}"><i class="fa fa-circle-o"></i> Customers</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Voucher</a></li>
                    <li><a href="{{route('admin.shipper.transport')}}"><i class="fa fa-circle-o"></i> Transport</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share-alt"></i>
                    <span>Marketing</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.cpevent.index')}}"><i class="fa fa-circle-o"></i> Coupon</a></li>
                    <li><a href="{{route('admin.cpcode.index')}}"><i class="fa fa-circle-o"></i> Event</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Reports</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Sales</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Products</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Customers</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>User</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.user.index')}}"><i class="fa fa-circle-o"></i> User</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i>
                    <span>Systems</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.cache.index')}}"><i class="fa fa-circle-o"></i> Cache</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>