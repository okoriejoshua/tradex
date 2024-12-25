 <nav style="border-color:#454d5503!important;" class="main-header navbar navbar-expand navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>
     <li class="sitename-mobile nav-item">
       <a class="nav-link" href="#" role="button">{{ config('app.name', 'Tradex') }}</a>
     </li>
   </ul>

   <ul class="navbar-nav ml-auto">
     <li class="nav-item">
       <a class="nav-link" data-widget="navbar-search" href="#" role="button">
         <i class="fas fa-search"></i>
       </a>
       <div class="navbar-search-block">
         <form class="form-inline">
           <div class="input-group input-group-sm">
             <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
             <div class="input-group-append">
               <button class="btn btn-navbar" type="submit">
                 <i class="fas fa-search"></i>
               </button>
               <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                 <i class="fas fa-times"></i>
               </button>
             </div>
           </div>
         </form>
       </div>
     </li>
     <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#">
         <i class="far fa-bell"></i>
         <span class="badge badge-danger navbar-badge">0</span>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <a href="#" class="dropdown-item">
           <!-- Message Start -->
           <div class="media">
             <img src="{{ asset('backend/ui/img/avatar.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
             <div class="media-body">
               <h3 class="dropdown-item-title">
                 Brad Diesel
                 <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
               </h3>
               <p class="text-sm">Call me whenever you can...</p>
               <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
             </div>
           </div>
           <!-- Message End -->
         </a>

         <div class="dropdown-divider"></div>
         <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
       </div>
     </li>
     <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#">
         <img src="@isset(auth()->user()->photo) {{ asset('storage/photos/'.auth()->user()->photo)}} @else {{ asset('backend/ui/img/avatar.png')}} @endisset" alt="user-photo"
           style="opacity:.8; width: 30px;margin-top: -6px;" class="border-1 profile-photo img-circle elevation-1">
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <div class="card card-widget widget-user" style="margin-bottom: -0px;">
           <div class="theme-bg widget-user-header">
             <h3 class="profile-name widget-user-username">{{auth()->user()->username ?? auth()->user()->name }}</h3>
           </div>
           <div class="widget-user-image mb-2">
             <img src="@isset(auth()->user()->photo) {{ asset('storage/photos/'.auth()->user()->photo)}} @else {{ asset('backend/ui/img/avatar.png')}} @endisset" class="profile-photo img-circle shadow-concave-xs border" alt="User Image">
           </div>
           <div class="p-0 card-footer ">
             <ul class="nav flex-column">
               <li class="mt-4 border-bottom nav-item mb-2">&nbsp;</li>
               <li class="border-bottom nav-item mb-2">
                 <a href="{{route('user.profile')}}" class="nav-link ">
                   <i class="fas fa-edit"></i>
                   Customize profile <span class="float-right badge bg-default"><i class="right fas fa-angle-right"></i></span>
                 </a>
               </li>
               <li class="border-bottom nav-item">
                 <a href="#" class="nav-link">
                   <i class="fas fa-inbox"></i>
                   Inbox <span class="float-right badge bg-default"> Coming soon <i class="right fas fa-angle-right"></i></span>
                 </a>
               </li>
               <li class="nav-item ">
                 <a data-toggle="modal" data-target="#signOutModal" href="#" class="nav-link">
                   <i class="fas fa-power-off"></i>
                   Sign Out <span class="float-right badge bg-default"><i class="right fas fa-angle-right"></i></span>
                 </a>
               </li>
             </ul>
           </div>
         </div>
       </div>
     </li>
   </ul>
 </nav>