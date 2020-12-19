
<li class="sidebar-header"><span><span class="fa fa-bank"></span> E-Escritor</span></li>

<li class="nav-item @if (Request::is('admin'.'/siravel-analytics') || Request::is('admin'.'/siravel-analytics/*')) active @endif">
    <a class="nav-link" href="{{ url('admin'.'/siravel-analytics') }}"><span class="fa fa-fw fa-line-chart"></span> Analytics</a>
</li>
<li class="nav-item @if (Request::is('admin'.'/products') || Request::is('admin'.'/products/*')) active @endif">
    <a class="nav-link" href="{{ url('admin'.'/products') }}"><span class="fa fa-fw fa-archive"></span> Products</a>
</li>
<li class="nav-item @if (Request::is('admin'.'/plans') || Request::is('admin'.'/plans/*')) active @endif">
    <a class="nav-link" href="{{ url('admin'.'/plans') }}"><span class="fa fa-fw fa-credit-card"></span> Subscription Plans</a>
</li>
<li class="nav-item @if (Request::is('admin'.'/coupons') || Request::is('admin'.'/coupons/*')) active @endif">
    <a class="nav-link" href="{{ url('admin'.'/coupons') }}"><span class="fa fa-fw fa-ticket"></span> Coupons</a>
</li>
<li class="nav-item @if (Request::is('admin'.'/transactions') || Request::is('admin'.'/transactions/*')) active @endif">
    <a class="nav-link" href="{{ url('admin'.'/transactions') }}"><span class="fa fa-fw fa-dollar"></span> Transactions</a>
</li>
<li class="nav-item @if (Request::is('admin'.'/orders') || Request::is('admin'.'/orders/*')) active @endif">
    <a class="nav-link" href="{{ url('admin'.'/orders') }}"><span class="fa fa-fw fa-ship"></span> Orders</a>
</li>
