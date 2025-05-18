   <!--**********************************
            Header start
        ***********************************-->
   <div class="header">
       <div class="header-content clearfix">

           <div class="nav-control">
               <div class="hamburger">
                   <span class="toggle-icon"><i class="icon-menu"></i></span>
               </div>
           </div>
           <div class="header-left">
               <div class="input-group icons">
                   <div class="input-group-prepend">
                   </div>
               </div>
           </div>
           <div class="header-right">
               <ul class="clearfix">
                   <li class="icons dropdown">
                       <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                           <span class="activity active"></span>
                           <img src="{{ asset('theme') }}/images/user/form-user.png" height="40" width="40"
                               alt="">
                       </div>
                       <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                           <div class="dropdown-content-body">
                               <ul>
                                   <li>{{ auth()->user()->name }}</li>
                                   <li>
                                       <a href="{{ url('/profile') }}"><i class="icon-user"></i>
                                           <span>Profile</span></a>
                                   </li>
                                   <hr class="my-2">
                                   <li>
                                       <form method="POST" action="{{ route('logout') }}" id="logout-form"
                                           style="display: none;">
                                           @csrf
                                           <button type="submit" class="btn btn-primary">Logout</button>
                                       </form>
                                       <a href="javascript:void()"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                               class="icon-key"></i> <span>Logout</span></a>
                                   </li>
                               </ul>
                           </div>
                       </div>
                   </li>
               </ul>
           </div>
       </div>
   </div>
   <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
