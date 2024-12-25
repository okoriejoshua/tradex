<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Profile
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left col -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile Details
                            </h4>
                        </div>
                        <div class="p-0 card-body">
                            <div class="card card-widget widget-user mb-0">
                                <div style="border-top-left-radius:0px; border-top-right-radius:0px;" class="widget-user-header theme-bg">
                                    <h5 class="widget-user-username capital">{{$ud->name}}</h5>
                                </div>
                                <div style="top:75px" class="widget-user-image mb-2">
                                    <img src="{{ $photo?$photo->temporaryUrl() : ($ud->photo ? asset('storage/photos/'.$ud->photo): asset('storage/photos/default.png'))}}" class="auto-margin-rl img-circle elevation-2" alt="User Image">
                                    <i wire:click.prevent="openChangePhotoTab({{$ud->id}})" class="fas fa-camera border  img-circle elevation-2 p-1 theme-bg-light " style="margin-left: -13px;"></i>
                                    <div wire:loading.delay wire:target="openChangePhotoTab" class="mt-1 pr-1">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="sr-only">...</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if(auth()->user()->kyc_level=='none')
                                        <a href="{{route('user.profile',['autoshow' => 'basic-kyc'])}}" class="theme-bg  shadow-concave-xs radius-8 capital mb-3 small-size px-2 mt-1">verify KYC now </a>
                                        @else
                                        <span class="theme-bg  shadow-concave-xs radius-8 capital mb-3 small-size px-2 mt-1"> KYC: {{auth()->user()->kyc_level}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div x-data="{ isUploading:false, progress:3 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <div x-show="isUploading" class="progress progress-xs ">
                                        <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                            aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                    <p class="p-1">&nbsp;</p>
                                    <div wire:ignore.self id="uploadtab" class="p-2 active" style="display: none;">
                                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="savePhoto">
                                            <div class="form-group">
                                                <label for="changephoto">Change Photo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input wire:model="photo" type="file" accept="image/*" class="custom-file-input" id="changephoto">
                                                        <label class="custom-file-label" for="changephoto">{{$photo?$photo->getClientOriginalName():'Choose file'}}</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="input-group-text btn theme-bg ">Upload</button>
                                                    </div>
                                                </div>
                                                @error('photo')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer p-2">
                                    <ul class="list-group my-2 mb-3 radius-8">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            <strong>Account</strong>
                                            <strong class="badge  badge-pill capital">Information</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            Email
                                            <span class="badge  badge-pill  text-muted">{{auth()->user()->email}} @if(auth()->user()->email_verified_at)
                                                <i class="fas fa-check-circle text-success"></i> verified
                                                @else
                                                <span wire:click="verifyMailModal" class="btn btn-default btn-xs border radius-8"><i class="fas fa-exclamation-circle text-warning"></i> verify
                                                    <i class="fas fa-angle-right "></i>
                                                </span>
                                                @endif </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            Phone
                                            <span class="badge  badge-pill capital  text-muted">{{auth()->user()->phone ?? ''}} </span>
                                        </li>
                                        <li wire:click="changeNickNameModal" class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            Display Name
                                            <span class="badge  badge-pill capital  text-muted">{{auth()->user()->username ?? first_word(auth()->user()->name)}} <i class="fas fa-angle-right "></i></span>
                                        </li>
                                    </ul>
                                    <ul class="list-group my-2 mb-3 radius-8">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            KYC Levels
                                            <span class="badge  badge-pill capital" wire:click="stageSwap('Identity')">{{$ud->kyc_level}} <i class="fas fa-angle-right "></i> </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            Fullname
                                            <span class="badge  badge-pill  text-muted">{{auth()->user()->name}} </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            Gender
                                            <span class="badge  badge-pill  text-muted">{{auth()->user()->gender}} </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            <span>Date Of Birth</span>
                                            <span class="badge  badge-pill  text-muted">{{auth()->user()->dob}} </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            <span>Address</span>
                                            <p wire:click="stageSwap('Address')" class="break-word  text-muted small-size m-2">
                                                {{auth()->user()->address}}
                                            </p>
                                            <span wire:click="stageSwap('Address')" class="badge  badge-pill  text-muted"><br>
                                                <i class="fas fa-angle-right "></i>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom ">
                                            <span>Occupation</span>
                                            <span class="badge  badge-pill  text-muted">{{auth()->user()->occupation}} </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Left col -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item "><a class="nav-link" href="#password-tab" data-toggle="tab"><strong>Security</strong> Update Password</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div wire:ignore.self class="tab-pane active" id="password-tab">
                                    <form class="form-horizontal" autocomplete="off" wire:submit.prevent="updatePassword">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="current_password" class="col-sm-2 col-form-label">Old Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" id="current_password" wire:model.defer="state.current_password" class="form-control @error('current_password') is-invalid @enderror " placeholder="Current Password ">
                                                    @error('current_password')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="userpassword" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" wire:model.defer="state.password" id="pw" class="form-control  @error('password') is-invalid @enderror" id="userpassword"
                                                        placeholder="Enter new password ">
                                                    @error('password')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-0 form-group row">
                                                <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" wire:model.defer="state.password_confirmation" id="psw" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                                        placeholder=" Confirm new password ">
                                                    @error('password_confirmation')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class=" mt-0 form-group row ">
                                                <label for="password_confirmation" class="col-sm-2 col-form-label">&nbsp;</label>
                                                <div class="col-sm-10">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" id="showpassword" class="toggle-password">
                                                        <label for="showpassword">
                                                            Show Password
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end"> <button type="submit" class="btn btn-primary"><i class="right fas fa-save mr-1"></i>
                                                <span>Save Password</span>
                                                <div wire:loading wire:target="updatePassword">
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="changeNickName" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-header">
                    <h4 class="modal-title"> Update Display Name </h4>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="nickName">
                    <div class="modal-body">
                        <div class="form-group row mb-0">
                            <label for="nickname" class="col-sm-12 col-form-label">Display Name (Nickname)</label>
                            <div class="col-sm-12">
                                <input type="text" wire:model.defer="state.nickname" class="form-control  @error('nickname') is-invalid @enderror"
                                    id="nickname" placeholder="nickname">
                                @error('nickname')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="padding-10x20 radius-24 btn elevation-1 theme-bg mb-3"> Confirm Update
                            <x-small-spinner condition="delay" target="nickName"></x-small-spinner>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="verifyEmail" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-header">
                    <h4 class="modal-title"> Verify Email </h4>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="getVerified">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <label for="verifycode" class="col-sm-12 col-form-label">Enter code sent to your email</label>
                            <input type="text" wire:model.defer="state.verifycode" class="form-control  @error('verifycode') is-invalid @enderror"
                                id="verifycode" placeholder="verification from email">
                            <div class="input-group-append">
                                <span wire:click="sendEmailCode" class="input-group-text"> Send Code
                                    <x-small-spinner condition="delay" target="sendEmailCode" />
                                </span>
                            </div>
                        </div>
                        @error('verifycode')
                        <span class="invalid-feedback">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="padding-10x20 radius-24 btn elevation-1 theme-bg mb-3"> Verify Code
                            <x-small-spinner condition="delay" target="getVerified" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($autoShowModal == true)
    <div class="modal fade  show" id="updatedProfileModal" wire:ignore.self aria-modal="true" role="dialog" style="display: block;">
        @else
        <div class="modal fade" id="updatedProfileModal" wire:ignore.self>
            @endif
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content card-warning card-outline">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Update Your information
                        </h4>
                    </div>
                    <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$stage}}">
                        <div class="modal-body scroll-y"> 
                            @if($stage == 'bioData')
                            <fieldset class="{{$stage}}">
                                <legend>BIO DATA</legend>
                                <div class="form-group row mb-0">
                                    <label for="fullname" class="col-sm-12 col-form-label">Fullname</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.defer="state.name" class="form-control  @error('name') is-invalid @enderror"
                                            id="fullname" placeholder="fullname">
                                        @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <small class="text-warning small-size p-2">Fullname must match record on your ID </small>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="username" class="col-sm-12 col-form-label">Display Name (Nickname)</label>
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.defer="state.username" class="form-control  @error('username') is-invalid @enderror"
                                            id="username" placeholder="username">
                                        @error('username')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-12 col-form-label">Gender</label>
                                    <div class="col-sm-12">
                                        <select id="gender" wire:model.defer="state.gender" class="border-1 custom-select @error('gender') is-invalid @enderror">
                                            <option selected>-- Select --</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        @error('gender')
                                        <small class="invalid-feedback">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-sm-12  col-form-label">Date Of Birth</label>
                                    <div class="col-sm-12 ">
                                        <input type="date" wire:model.defer="state.dob"
                                            class="form-control  @error('dob') is-invalid @enderror" id="dob" placeholder="Date Of Birth">
                                        @error('dob')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="text-warning small-size p-2">Date Of Birth must match record on your ID </div>
                                </div>

                            </fieldset>
                            @elseif($stage =='Address')
                            <fieldset class="{{$stage}}">
                                <legend>Contact Address </legend>
                                @if($isnotify)
                                <div class="form-group row mb-0">
                                    <span class="warning-bg col-sm-12  col-form-label radius-4 ">
                                        Changing address now will make you lose KYC status
                                    </span>
                                </div>
                                @endif
                                <div class="form-group row mb-0">
                                    <label for="email" class="col-sm-12  col-form-label">Email Address</label>
                                    <div class="col-sm-12 ">
                                        <input type="email" wire:model.defer="state.email"
                                            class="form-control  @error('email') is-invalid @enderror" id="email" disabled>
                                        @error('email')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="phone" class="col-sm-12  col-form-label">Phone</label>
                                    <div class="col-sm-12 ">
                                        <input type="number" wire:model.defer="state.phone"
                                            class="form-control  @error('phone') is-invalid @enderror" id="phone" placeholder="Phone Number">
                                        @error('phone')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="country" class="col-sm-12 col-form-label">Country</label>
                                    <div class="col-sm-12">
                                        <select id="country" wire:model.defer="state.country" class="border-1 custom-select @error('country') is-invalid @enderror">
                                            <x-country-list />
                                        </select>
                                    </div>
                                    @error('country')
                                    <small class="invalid-feedback">{{$message}}</small>
                                    @enderror
                                    <small class="text-warning small-size p-2">Country That Issued your ID </small>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-12 col-form-label">Address</label>
                                    <div class="col-sm-12">
                                        <textarea type="text" wire:model.defer="state.address" class="form-control  @error('address') is-invalid @enderror"
                                            id="address" placeholder=" Home Address as contained in your ID"></textarea>
                                        @error('address')
                                        <small class="invalid-feedback">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <small class="text-warning small-size p-2">Address must match record on your ID </small>
                                </div>

                            </fieldset>
                            @elseif($stage=='Identity')
                            <fieldset class="{{$stage}}">
                                <legend>Verify Identity</legend>
                                <!---end verify kyc --->
                                <div id="data_tab" class="mt-1">
                                    @if($isnotify)
                                    <div class="form-group row mb-0">
                                        <span class="warning-bg col-sm-12  col-form-label radius-4 ">
                                            Changing ID information now will make you lose KYC status
                                        </span>
                                    </div>
                                    @endif
                                    <label for="card_type">Select Card</label>
                                    <div class="input-group mb-3">
                                        <select id="card_type" wire:model.defer="state.card_type" class="custom-select @error('card_type') is-invalid @enderror">
                                            <option selected>-- Select --</option>
                                            <option value="national_id">National ID</option>
                                            <option value="driver_license">Driver License</option>
                                            <option value="international_passport">International Passport</option>
                                        </select>
                                    </div>
                                    @error('card_type')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror

                                    <!--label for="country_issued">Isseud Card Country</!--label>
                                    <div-- class="input-group mb-3">
                                        <select id="country_issued" wire:model.defer="state.country_issued" class="custom-select @error('country_issued') is-invalid @enderror">
                                            <x-country-list></x-country-list>
                                        </select>
                                    </div-->


                                    <label for="name_on_card">Name On Card</label>
                                    <div class="input-group mb-3">
                                        <input type="text" wire:model.defer="state.name_on_card" id="name_on_card" class="form-control @error('name_on_card') is-invalid @enderror" placeholder="Name on Your Card">
                                    </div>
                                    @error('name_on_card')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror

                                    <label for="expiry">Expiry Date (Optional)</label>
                                    <div class="input-group mb-3">
                                        <input type="date" wire:model.defer="state.expiry" id="expiry" class="form-control @error('expiry') is-invalid @enderror">
                                    </div>
                                    @error('name_on_card')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror

                                    <label for="serial_number">Number On Card</label>
                                    <div class="input-group mb-3">
                                        <input type="number" wire:model.defer="state.serial_number" id="serial_number" class="form-control @error('serial_number') is-invalid @enderror">
                                    </div>
                                    @error('serial_number')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </fieldset>
                            @elseif($stage=='UploadKYC')
                            <fieldset class="{{$stage}}">
                                <legend>Upload Identitification Card</legend>
                                <div id="photo_tab" class="mt-1">
                                    <div class=" {{$cardview == 'front'?'d-block':'d-none'}} form-group">
                                        <div x-data="{ isUploading:false, progress:3 }"
                                            x-on:livewire-upload-start="isUploading = true"
                                            x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                            x-on:livewire-upload-error="isUploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                                            <label for="cardfront">Card Front </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input wire:model="cardfront" type="file" accept="image/*" class="custom-file-input  @error('cardfront') is-invalid @enderror" id="cardfront">
                                                </div>
                                                <div class="input-group-append">
                                                    <label class="custom-file-label" for="cardfront">{{$cardfront?$cardfront->getClientOriginalName():'Choose Card Front'}}</label>
                                                </div>
                                            </div>
                                            <div x-show="isUploading" class="progress progress-xs ">
                                                <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                                    aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <img id="cardfront"
                                            src="{{$cardfront?$cardfront->temporaryUrl():asset('storage/photos/front.png')}}"
                                            style="width:50%;border-radius:8px;border-radius:4px"
                                            class="p-2 border-1 m-1 text-center {{($cardviewswap==true)?'d-none':'d-block'}}"
                                            alt="card front">

                                        <img id="cardback"
                                            src="{{$cardback?$cardback->temporaryUrl(): asset('storage/photos/back.png')}}"
                                            style="width:50%;border-radius:8px;border-radius:4px"
                                            class="p-2 border-1 m-1 text-center {{($cardviewswap==false)?'d-none':'d-block'}}"
                                            alt="card back">
                                    </div>

                                    <div class="{{$cardview=='front'?'d-none':'d-block'}} form-group">
                                        <div x-data="{ isUploading:false, progress:3 }"
                                            x-on:livewire-upload-start="isUploading = true"
                                            x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                            x-on:livewire-upload-error="isUploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <label for="cardback">Card Back</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input wire:model="cardback" type="file" accept="image/*" class="custom-file-input is-invalid" id="cardback">
                                                </div>
                                                <div class="input-group-append">
                                                    <label class="custom-file-label" for="cardback">{{$cardback?$cardback->getClientOriginalName():'Choose Card Back'}}</label>
                                                </div>
                                            </div>
                                            <div x-show="isUploading" class="progress progress-xs ">
                                                <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                                    aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            @elseif($stage=='KYCstatus')
                            <fieldset class="{{$stage}}">
                                <legend>KYC Status</legend>
                                <div id="status_tab" class="mt-1">
                                    @if($ud->kycData->status == 'rejected')
                                    <div class="p-2 card-body text-center">
                                        <p><strong>Verification Unsuccessful</strong></p>
                                        Unfortunately, we could not confirm your identity at this time.
                                        If you think there is an error , please contact <a href="mailto:support@tradex.com">support@tradex.com</a> for further assistance.
                                        <p><i class="fas fa-user-times mt-2 text-danger" style="font-size: 100px"></i></p>
                                    </div>

                                    @elseif($ud->kycData->status == 'approved')
                                    <div class="p-2 card-body text-center">
                                        <p><strong>Verification Successful</strong></p>
                                        Your KYC verification was successful
                                        <p><i class="fas fa-user-check mt-2 text-success" style="font-size: 100px"></i></p>
                                    </div>
                                    @else
                                    <div class="p-2 card-body text-center">
                                        <p><i class="fas fa-info-circle mt-2 text-orange" style="font-size: 100px"></i></p>
                                        <p><strong>Verification In Progress</strong></p>
                                        Your Data is currently under review. We will send you an email if it's approved within 48 hours
                                    </div>
                                    @endif
                                </div>
                            </fieldset>
                            @else @endif
                        </div>
                        <div class="modal-footer d-flex justify-content-end p-0">
                            @if($stage=='KYCstatus')
                            <span wire:click="goto('{{route('user.profile')}}')" class="btn elevation-1 theme-bg mb-3"> Close </span>
                            @else
                            <button type="submit" class="btn elevation-1 theme-bg mb-3"> Submit
                                <x-small-spinner condition="delay" target="{{$stage}}" />
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>