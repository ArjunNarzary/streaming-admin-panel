@extends('layouts.master') @section('content')
<div class="container">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <section class="pt-5 pb-5 bg-gradient-primary text-white pl-4 pr-4 inner-profile mb-4">
           <div class="row gutter-2 gutter-md-4 align-items-end">
              <div class="col-md-6 text-center text-md-left">
                 <h1 class="mb-1">{{ auth::user()->name }}</h1>
                 {{-- <span class="text-muted text-gray-500"><i class="fas fa-map-marker-alt fa-fw fa-sm mr-1"></i> India, Punjab</span> --}}
              </div>
              <div class="col-md-6 text-center text-md-right">
                 <a href="#" data-toggle="modal" data-target="#logoutModal" class="btn btn btn-light">Sign out</a>
              </div>
           </div>
        </section>
        <div class="row">
           <div class="col-xl-3 col-lg-3">
              <div class="bg-white p-3 widget shadow rounded mb-4">
                 <div class="nav nav-pills flex-column lavalamp" id="sidebar-1" role="tablist">
                    <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('user.profile') }}" role="tab" ><i class="fas fa-user-circle fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
                    <a class="nav-link {{ request()->is('profile/password') ? 'active' : '' }}" href="{{ route('profile.password') }}" role="tab"><i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i> Account Settings</a>
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout</a>
                 </div>
              </div>
           </div>
           <div class="col-xl-9 col-lg-9">
              <div class="bg-white p-3 widget shadow rounded mb-4">
                 <div class="tab-content" id="myTabContent">
                    <!-- profile -->
                    <div class="tab-pane fade {{ request()->is('profile') ? 'show active' : '' }}" id="sidebar-1-1" role="tabpanel" aria-labelledby="sidebar-1-1">
                       <!-- Page Heading -->
                       <div class="d-sm-flex align-items-center justify-content-between mb-3">
                          <h1 class="h5 mb-0 text-gray-900">Profile</h1>
                       </div>
                       <form method="post" action="{{ route('profile.save') }}">
                           @csrf
                       <div class="row gutter-1">
                          <div class="col-md-6">
                             <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? auth::user()->name }}" required>

                                @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                             </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                               <label for="email">Email</label>
                               <input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? auth::user()->email }}" required>

                               @error('email')
                               <div class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                               </div>
                               @enderror
                            </div>
                         </div>
                         @if($distributor)
                          <div class="col-md-6">
                             <div class="form-group">
                                <label for="company">Company Name</label>
                                <input id="company" type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') ?? $distributor->company }}" required>

                                @error('company')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                             </div>
                          </div>
                          <div class="col-md-6">
                             <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="Male" {{ old('gender') == 'Male' ||  old('gender') == '' && $distributor->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ||  old('gender') == '' && $distributor->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>

                                @error('gender')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                             </div>
                          </div>
                          @endif
                         
                       </div>
                       <div class="row">
                          <div class="col">
                             <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
                       </div>
                    </form>
                    </div>

                    <!-- payments -->
                    <div class="tab-pane fade {{ request()->is('profile/password') ? 'show active' : '' }}" id="sidebar-1-4" role="tabpanel" aria-labelledby="sidebar-1-4">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-3">
                           <h1 class="h5 mb-0 text-gray-900">Account Settings</h1>
                        </div>
                        <form method="post" action="{{ route('profile.password.change') }}">
                            @csrf
                        <div class="row gutter-1">
                           <div class="col-12">
                              <div class="form-group">
                                 <label for="current_password">Current Password</label>
                                 <input id="current_password" type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Password" autocomplete="off">
 
                                 @error('current_password')
                                 <div class="invalid-feedback" role="alert">
                                     <strong>{{  $message }}</strong>
                                 </div>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="password">New Password</label>
                                 <input id="password" type="password" name="password" class="form-control  @error('password') is-invalid @enderror" placeholder="New Password">
 
                                 @error('password')
                                 <div class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </div>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="password_confirmation">Retype New Password</label>
                                 <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                              </div>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col">
                               <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                         </div>
                        </form>

                 </div>
              </div>
           </div>
        </div>

    </div>

</div>
@endsection
