<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">Menu Utama</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @php $level = auth()->user()->level->level_name; @endphp



            <li class="nav-item">
<li class="nav-heading">Master Data</li>
                      @if($level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('level.index') }}">
                            <i class="bi bi-person-workspace"></i>
                            <span>Level</span>
                        </a>
                    </li>
                    @endif
                      @if($level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('user.index') }}">
<i class="bi bi-person-lines-fill"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>
                    @endif
                    @if($level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('service.index') }}">
                            <i class="bi bi-steam"></i>
                            <span>Layanan</span>
                        </a>
                    </li>
                      @if($level == 'Operator' || $level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('customer.index') }}">

                            <i class="bi bi-people-fill"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>
                    @endif

@endif

            </li><!-- End Components Nav -->

            <li class="nav-heading">Transaksi</li>
                     @if($level == 'Operator' || $level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('transaction.index') }}">
                            <i class="bi bi-receipt-cutoff"></i>
                            <span>Order</span>
                        </a>
                    </li>
                    @endif

@if($level == 'Operator' || $level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('pickup.index') }}">
                           <i class="bi bi-basket2-fill"></i>
                            <span>Pickup</span>
                        </a>
                    </li>

@endif
 @if($level == 'Pimpinan')
 <li class="nav-heading">Transaksi</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('report.index') }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Laporan</span>
                </a>
            </li>
            @endif
    </ul>

</aside><!-- End Sidebar-->
