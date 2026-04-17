<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @php $level = auth()->user()->level->level_name; @endphp



            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-database-fill"></i><span>Master Data</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
                            <i class="bi bi-people-fill"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>
                    @endif
                      @if($level == 'Operator' || $level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('customer.index') }}">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>
                    @endif
                    @if($level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('service.index') }}">
                            <i class="bi bi-list"></i>
                            <span>Layanan</span>
                        </a>
                    </li>
@endif
                </ul>
            </li><!-- End Components Nav -->

                     @if($level == 'Operator' || $level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('transaction.index') }}">
                            <i class="bi bi-receipt-cutoff"></i>
                            <span>Transaksi</span>
                        </a>
                    </li>
                    @endif

@if($level == 'Operator' || $level == 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('pickup.index') }}">
                            <i class="bi bi-bag-check-fill"></i>
                            <span>Pickup Laundry</span>
                        </a>
                    </li>

@endif
 @if($level == 'Pimpinan')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('report.index') }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Laporan</span>
                </a>
            </li>
            @endif
    </ul>

</aside><!-- End Sidebar-->
