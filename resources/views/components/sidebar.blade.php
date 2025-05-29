   <!--start sidebar-->
   <aside class="sidebar-wrapper" data-simplebar="true">
       <div class="sidebar-header">
           <div class="logo-icon">
               <img src="assets/images/logo-icon.png" class="logo-img" alt="">
           </div>
           <div class="logo-name flex-grow-1">
               <h5 class="mb-0">{{ config('app.name') }}</h5>
           </div>
           <div class="sidebar-close">
               <span class="material-icons-outlined">close</span>
           </div>
       </div>
       @php
           $user = auth()->user();
           $userMenuNames = $user->menus->pluck('name')->toArray();
       @endphp

       <div class="sidebar-nav">
           <!--navigation-->
           <ul class="metismenu" id="sidenav">

               <li class="menu-label">Menu</li>
               <li>
                   <a href="{{ route('dashboard') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">dashboard</i></div>
                       <div class="menu-title">Dashboard</div>
                   </a>
               </li>
               @if (in_array('bahanBaku', $userMenuNames))
               <li>
                   <a href="{{ route('bahanBaku.index') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">inventory</i></div>
                       <div class="menu-title">Bahan Baku</div>
                   </a>
               </li>
               @endif
               @if (in_array('supplier', $userMenuNames))
               <li>
                   <a href="{{ route('supplier.index') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">people</i></div>
                       <div class="menu-title">Supplier</div>
                   </a>
               </li>
               @endif
               @if (in_array('transaksi_masuk', $userMenuNames))
               <li>
                   <a href="{{ route('transaksi_masuk.index') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">input</i></div>
                       <div class="menu-title">Transaksi Masuk</div>
                   </a>
               </li>
               @endif
               @if (in_array('transaksi_keluar', $userMenuNames))
               <li>
                   <a href="{{ route('transaksi_keluar.index') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">output</i></div>
                       <div class="menu-title">Transaksi Keluar</div>
                   </a>
               </li>
               @endif
               @if (in_array('laporan_masuk', $userMenuNames))
               <li>
                   <a href="cards.html">
                       <div class="parent-icon"><i class="material-icons-outlined">output</i></div>
                       <div class="menu-title">Laporan Masuk</div>
                   </a>
               </li>
               @endif
               @if (in_array('laporan_keluar', $userMenuNames))
               <li>
                   <a href="cards.html">
                       <div class="parent-icon"><i class="material-icons-outlined">output</i></div>
                       <div class="menu-title">Laporan Keluar</div>
                   </a>
               </li>
               @endif
               @if (in_array('grafik_transaksi_masuk', $userMenuNames))
               <li>
                   <a href="cards.html">
                       <div class="parent-icon"><i class="material-icons-outlined">trending_up</i></div>
                       <div class="menu-title">Grafik Transaksi Masuk</div>
                   </a>
               </li>
               @endif
               @if (in_array('grafik_transaksi_keluar', $userMenuNames))
               <li>
                   <a href="cards.html">
                       <div class="parent-icon"><i class="material-icons-outlined">trending_down</i></div>
                       <div class="menu-title">Grafik Transaksi Keluar</div>
                   </a>
               </li>
               @endif
               <li>
                   <a href="cards.html">
                       <div class="parent-icon"><i class="material-icons-outlined">calculate</i></div>
                       <div class="menu-title">Hasil Perhitungan</div>
                   </a>
               </li>
               {{-- @endif --}}

               <li class="menu-label">Akun</li>
               <li>
                   <a href="{{ route('acount.index') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">manage_accounts</i></div>
                       <div class="menu-title">Manajemen Akun</div>
                   </a>
               </li>
               {{-- @endif --}}
           </ul>
           <!--end navigation-->
       </div>
   </aside>
