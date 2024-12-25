 <aside class="main-sidebar  sidebar-light-primary elevation-1">
   <!-- Brand Logo -->
   <a href="index3.html" class="brand-link">
     <img src="{{ asset('backend/ui/img/AdminLTELogo.png')}}" alt=" Logo" class="brand-image img-circle elevation-1" style="opacity: .8">
     <span class="brand-text font-weight-light capital">{{ config('app.name', 'Tradex') }}</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-4 ">
       <div class="d-flex">
         <div class="image">
           <img src="@isset(auth()->user()->photo) {{ asset('storage/photos/'.auth()->user()->photo)}} @else {{ asset('backend/ui/img/avatar.png')}} @endisset" class="profile-photo-sidebar img-circle elevation-1" alt="User Image">
         </div>
         <div class="info">
           <a href="{{route('user.profile')}}" class="btn btn-xs"><span class="d-block">Account &NonBreakingSpace; @if(auth()->user()->email_verified_at) <i class="fas fa-check-circle text-success"></i> @else <span class="btn btn-xs border radius-8"><i class="fas fa-exclamation-circle text-warning"></i><span class="text-muted"> verify email <i class="fas fa-angle-right "></i> </span></span> @endif </span></a>
           @if(auth()->user()->kyc_level=='none')
           <small class="d-block">KYC <span class="text-muted"> Not Verified</span> </small> @else @endif
         </div>
       </div>
       <div class="d-flex justify-content-between mt-4 mb-0  btn btn-default ">
         <div class="info">Mode </div>
         <div class="image d-flex mt-1">
           <span class="small-size p-2" style="margin-top: -7px;" id="current-mode">Day</span>
           <div class="custom-control custom-switch" id="toggleDarkMode">
             <input type="checkbox" class="custom-control-input" id="mode">
             <label class="custom-control-label" for="mode"></label>
           </div>
         </div>
       </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item mb-0">
           <a href="{{route('user.dashboard')}}" class="nav-link {{ request()->is('user/dashboard') ? 'theme-bg-linear':'' }}">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li><!-- menu-is-opening menu-open-->
         <li class="nav-item mb-0">
           <a href="{{route('user.transactions')}}" class="nav-link  {{ request()->is('user/transactions') || request()->is('user/transactions/*')? 'theme-bg-linear' : '' }}">
             <i class="nav-icon fas fa-credit-card"></i>
             <p>
               Transactions
             </p>
           </a>
         </li>

         <li class="nav-item mb-0">
           <a href="{{route('user.activities')}}" class="nav-link  {{ request()->is('user/activities') || request()->is('user/activities/*')? 'theme-bg-linear' : '' }}">
             <i class="nav-icon fas fa-clock"></i>
             <p>
               Activities
             </p>
           </a>
         </li>

         <li class="nav-item mb-0">
           <a href="{{route('user.payment')}}" class="nav-link  {{ request()->is('user/payment') || request()->is('user/payment/*')? 'theme-bg-linear' : '' }}">
             <i class="nav-icon fas fa-landmark"></i>
             <p>
               Bank & Payments
             </p>
           </a>
         </li>

         <li class="nav-item mb-0">
           <a href="{{route('user.referral')}}" class="nav-link  {{ request()->is('user/referral') || request()->is('user/referral/*')? 'theme-bg-linear' : '' }}">
             <i class="nav-icon fas fa-user-friends"></i>
             <p>
               Referrals
             </p>
           </a>
         </li>

         <li class="nav-item mb-0">
           <a href="mailto:admin@tradex.com" class="nav-link  {{ request()->is('user/support') || request()->is('user/support/*')? 'theme-bg-linear' : '' }}">
             <i class="nav-icon fas fa-headset"></i>
             <p>
               Customer Support
             </p>
           </a>
         </li>
         <li class="nav-item mb-0">
           <a data-toggle="modal" data-target="#signOutModal" href="#" class="nav-link">
             <i class="nav-icon fas fa-power-off"></i>
             <p>
               Sign Out
             </p>
           </a>
         </li>
         <li style="border-top:.5px solid #6c757d" class="nav-item mt-4">
           <a href="#" class="nav-link mt-2">
             <p>
               <small class="d-flex justify-content-between capital">
                 <span>
                   <i class="nav-icon fas fa-info-circle"></i>
                   {{ config('app.name', 'Tradex') }}
                 </span>
                 <i class="fas fa-angle-right right mt-1"></i>
               </small>
             </p>
           </a>
         </li>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>