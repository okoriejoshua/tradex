 <aside class="main-sidebar  sidebar-light-primary elevation-1">
   <!-- Brand Logo -->
   <a href="index3.html" class="brand-link">
     <img src="{{ asset('backend/ui/img/AdminLTELogo.png')}}" alt=" Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text font-weight-light">{{ config('app.name', 'Tradex') }}</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar"> 
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="btn-group ">
         <div class="btn btn-default image">
           <img src="{{ asset('storage/photos/'.(auth()->user()->photo?auth()->user()->photo:'default.png'))}}" class="profile-photo-sidebar mt-2 img-circle elevation-2" alt="User Image">
         </div>
         <div class="info btn btn-default">
           <a href="{{route('admin.profile')}}" class="pl-0">
             <small class="profile-name-sidebar"> {{auth()->user()->name}} </small>
             <br> <small class="text-muted badge badge-success"><i class="fas fa-check-circle"></i> Super Admin</small>
           </a>
         </div>
         <div class="info btn btn-default">
           <a data-toggle="modal" data-target="#signOutModal" href="#" class="pr-2">
             <i class="fas fa-power-off mt-3 "></i>
           </a>
         </div>
       </div>
     </div>
     <div class="user-panel mt-3 pb-3 mb-3 ">
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
           <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->is('admin/dashboard') ? 'active':'' }}">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li>
         <li class="nav-item {{ request()->is('admin/users') || request()->is('admin/admins') ? 'menu-is-opening menu-open' : '' }}">
           <a href="#" class="nav-link {{ request()->is('admin/users') || request()->is('admin/admins') ? 'active' : '' }}">
             <i class="nav-icon fas fa-users"></i>
             <p>
               Manage Users
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('admin.admins')}}" class="nav-link {{ request()->is('admin/admins')? 'nav-link-active' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Admins</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('admin.users')}}" class="nav-link {{ request()->is('admin/users')? 'nav-link-active' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Users</p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-bullhorn"></i>
             <p>
               Announcement
               <span class="right badge badge-danger">New</span>
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-headset"></i>
             <p>
               User Supports
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Live Chat</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Notifications</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/boxed.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Complaints</p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item mb-0">
           <a href="" class="nav-link">
             <i class="nav-icon fas fa-cog"></i>
             <p>
               Settings
             </p>
           </a>
         </li>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>