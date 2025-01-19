{{-- @can('Dashboard') --}}

<li class="treeview">
    <a href="#">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        <span class="pull-right-container">
        </span>
    </a>
</li>
{{-- @endcan

@can('Members') --}}

<li class="{{ Request::is('Member') ? 'active' : '' }} {{ Request::is('Member/*') ? 'active' : '' }}">
    <a href="/Member"><i class="fa fa-user"></i>
        <span>Member</span></a>
</li>
<li class="{{ Request::is('Promo') ? 'active' : '' }} {{ Request::is('Promo/*') ? 'active' : '' }}">
    <a href="/Promo"><i class="fa fa-gift"></i>
        <span>Promo</span></a>
</li>
<li class="{{ Request::is('vouchers') ? 'active' : '' }} {{ Request::is('vouchers/*') ? 'active' : '' }}">
    <a href="/vouchers"><i class="fa fa-percent"></i>
        <span>Vouchers</span></a>
</li>
<li class="{{ Request::is('Testimonial') ? 'active' : '' }} {{ Request::is('Testimonial/*') ? 'active' : '' }}">
    <a href="/Testimonial"><i class="fa fa-star"></i>
        <span>Testimonial</span></a>
</li>
<li class="{{ Request::is('customers') ? 'active' : '' }} {{ Request::is('customers/*') ? 'active' : '' }}">
    <a href="/customers"><i class="fa fa-users"></i>
        <span>Customer</span></a>
</li>
<li class="{{ Request::is('payments') ? 'active' : '' }} {{ Request::is('payments/*') ? 'active' : '' }}">
    <a href="/payments"><i class="fa fa-money"></i>
        <span>List Payment</span></a>
</li>
<li class="{{ Request::is('wa_admin') ? 'active' : '' }} {{ Request::is('wa_admin/*') ? 'active' : '' }}">
    <a href="/wa_admin"><i class="fa fa-phone"></i>
        <span>WA Admin</span></a>
</li>
{{-- @endcan

@can('Master Data') --}}

<li class="treeview {{ Request::is('MasterData/*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-pie-chart"></i>
        <span>Master Data</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('*/SumberTransaksi') ? 'active' : '' }}"><a href="/MasterData/SumberTransaksi"><i
                    class="fa fa-circle-o"></i> Sumber
                Transaksi</a>
        </li>
        <li class="{{ Request::is('*/Produk') ? 'active' : '' }}"><a href="/MasterData/Produk"><i
                    class="fa fa-circle-o"></i> Produk</a></li>
        <li class="{{ Request::is('*/Harga') ? 'active' : '' }}"><a href="/MasterData/Harga"><i
                    class="fa fa-circle-o"></i> Harga
                Transaksi</a></li>
        {{-- <li class="{{ Request::is('*/PaymentMethod') ? 'active' : '' }}"><a href="/MasterData/PaymentMethod"><i
                class="fa fa-circle-o"></i> Payment Method</a>
</li> --}}
<li class="treeview {{ Request::is('MasterData/Template/*') ? 'active' : '' }}">
    <a href="#"><i class="fa fa-circle-o"></i> Template Chat
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        {{-- <li class="{{ Request::is('*/Template/OpeningChat') ? 'active' : '' }}"><a
            href="/MasterData/Template/OpeningChat"><i class="fa fa-circle-o"></i>Opening Chat</a>
</li> --}}
<li class="{{ Request::is('*/Template/PemberianAkun') ? 'active' : '' }}"><a
        href="/MasterData/Template/PemberianAkun"><i class="fa fa-circle-o"></i>Pemberian Akun</a>
</li>
{{-- <li class="{{ Request::is('*/Template/ErrorHandling') ? 'active' : '' }}"><a
    href="/MasterData/Template/ErrorHandling"><i class="fa fa-circle-o"></i>Error Handling</a>
</li> --}}
</ul>
</li>

</ul>
</li>
{{-- @endcan
@can('Akun') --}}

<li class="treeview {{ Request::is('Akun/*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-laptop"></i>
        <span>Akun</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('Akun/Index') && Request::get('varian') === 'Netflix' ? 'active' : '' }}"><a
                href="/Akun/Index?varian=Netflix"><i class="fa fa-circle-o"></i>Netflix</a>
        </li>
        <li class="{{ Request::is('Akun/Vidio/*') ? 'active' : '' }}"><a href="/Akun/Vidio/Index"><i
                    class="fa fa-circle-o"></i>Vidio</a>
        </li>
        <li class="{{ Request::is('Akun/Vision/*') ? 'active' : '' }}"><a href="/Akun/Vision/Index"><i
                    class="fa fa-circle-o"></i>Vision</a>
        </li>
        <li class="{{ Request::is('Akun/Spotify/*') ? 'active' : '' }}"><a href="/Akun/Spotify/Index"><i
                    class="fa fa-circle-o"></i>Spotify</a>
        </li>
        <li class="{{ Request::is('Akun/Disney/*') ? 'active' : '' }}"><a href="/Akun/Disney/Index"><i
                    class="fa fa-circle-o"></i>Disney</a>
        </li>
        <li class="{{ Request::is('Akun/Youtube/*') ? 'active' : '' }}"><a href="/Akun/Youtube/Index"><i
                    class="fa fa-circle-o"></i>Youtube</a>
        </li>
        <li class="{{ Request::is('Akun/WeTV/*') ? 'active' : '' }}"><a href="/Akun/WeTV/Index"><i
                    class="fa fa-circle-o"></i>We TV</a>
        </li>
        <li class="{{ Request::is('Akun/Viu/*') ? 'active' : '' }}"><a href="/Akun/Viu/Index"><i
                    class="fa fa-circle-o"></i>Viu</a>
        </li>
        <li class="{{ Request::is('Akun/Canva/*') ? 'active' : '' }}"><a href="/Akun/Canva/Index"><i
                    class="fa fa-circle-o"></i>Canva</a>
        </li>
        <li class="{{ Request::is('Akun/HBO/*') ? 'active' : '' }}"><a href="/Akun/HBO/Index"><i
                    class="fa fa-circle-o"></i>HBO GO</a>
        </li>
        <li class="{{ Request::is('Akun/Prime/*') ? 'active' : '' }}"><a href="/Akun/Prime/Index"><i
                    class="fa fa-circle-o"></i>Prime Vidio</a>
        </li>
    </ul>
</li>
{{-- @endcan

@can('Transaksi') --}}

<li class="treeview {{ Request::is('Transaksi/*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Transaksi</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('Transaksi/pending') ? 'active' : '' }}"><a href="/Transaksi/pending"><i
                    class="fa fa-circle-o"></i> Pending</a></li>
        <li class="{{ Request::is('Transaksi/Today') ? 'active' : '' }}"><a href="/Transaksi/Today"><i
                    class="fa fa-circle-o"></i> Hari ini</a></li>
        <li class="{{Request::is('Transaksi/PR/*') ? 'active':''}}"><a href="/Transaksi/PR"><i
                    class="fa fa-circle-o"></i> PR</a></li>
        <li class="{{Request::is('Transaksi/Status/Update') ? 'active':''}}"><a href="/Transaksi/Status/Update"><i
                    class="fa fa-circle-o"></i>Update Pembayaran</a>
        </li>
        <li class="{{Request::is('Transaksi/History') ? 'active' :''}}"><a href="/Transaksi/History"><i
                    class="fa fa-circle-o"></i>
                History</a></li>
    </ul>
</li>
{{-- @endcan

@can('Finance') --}}

<li class="treeview">
    <a href="#">
        <i class="fa fa-fw fa-money"></i> <span>Finance & Accounting</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="general.html"><i class="fa fa-circle-o"></i>Input Biaya</a></li>
        <li><a href="advanced.html"><i class="fa fa-circle-o"></i> Generate
                Report</a></li>
        {{-- <li><a href="editors.html"><i class="fa fa-circle-o"></i> Reseller</a></li> --}}
    </ul>
</li>
{{-- @endcan

@can('Access Management') --}}

<li class="{{ Request::is('AccessManagement') ? 'active' : '' }}"><a href="/AccessManagement"><i
            class="fa fa-fw fa-gears"></i>
        <span>Access Management</span></a>
</li>
{{-- @endcan --}}