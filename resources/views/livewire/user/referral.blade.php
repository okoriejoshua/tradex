<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small">
                        <span wire:click="goBack"><i class="right fas fa-angle-left"></i></span>
                    </li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Referrals
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card card-default">
                        <div class="p-2 card-body all">
                            @if(isset($referral->referredUser))
                            @forelse($referrals as $referral)
                            <div class="info-box mb-2 shadow-xs ">
                                <span style="width: 30px; font-size: 1.4rem" class="theme-color info-box-icon ">
                                    <i class="fas fa-user-plus"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span> You referred <strong class="upper">{{$referral->referredUser->name}}</strong> </span>
                                    <span class="info-box-text strong">On {{ $referral->referredUser->created_at->format('F j, Y, g:i A') }} </span>
                                </div>
                            </div>
                            @empty
                            <div class="empty">
                                <div class="text-center p-2">
                                    <i class="fas fa-clock mt-2 auto-margin-rl opacity-0-4" style="font-size: 60px;"></i>
                                    <div class="card-body text-center p-2">
                                        <span>No activity Found</span>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                            @endisset
                        </div>
                        @if ($referrals->count() == $this->perPage)<div class="card-footer text-center" wire:click="loadMore">Load More <x-small-spinner condition="delay" target="loadMore" />
                        </div> @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>