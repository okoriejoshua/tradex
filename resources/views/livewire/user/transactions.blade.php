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
                    Transactions
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="transparent card  shadow-0">
                        <div class=" p-2 card-body all">
                            @forelse($transactions as $transact)
                            <div wire:click.prevent="getDetails({{$transact->id}})">
                                <div class="info-box mb-2 shadow-xs ">
                                    <span style="width: 30px; font-size: 1.4rem" class="info-box-icon">
                                        <img style="width:30px;height:30px" src="{{ asset('storage/coins/'.$transact->icon)}}" class="img-circle" alt="{{ $transact->asset}}">
                                    </span>
                                    <div class="info-box-content capital">
                                        <span class="info-box-text"><small class="small-size strong">{{monify($transact->amount)}} {{$transact->name}} ({{strtoupper($transact->symbol)}})</small></span>
                                        <span class="info-box-text"><small style="font-size:10px" class="{{$transact->status == 'successful'?'success-light':'danger-light'}} btn btn-xs radius-24"> {{$transact->status}}</small></span>
                                    </div>
                                    <div style="text-align: end;" class="info-box-content capital">
                                        <span class="info-box-text strong">@ ${{monify($transact->asset_value)}} </span>
                                        <span class="info-box-text"><small class="small-size">{{format_date($transact->created_at)}}</small></span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="empty">
                                <div class="text-center p-2">
                                    <i class="fas fa-clock mt-2 auto-margin-rl opacity-0-4" style="font-size: 60px;"></i>
                                    <div class="card-body text-center p-2">
                                        <span>No Transaction Found</span>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        @if ($transactions->count() == $this->perPage)<div class="card-footer text-center" wire:click="loadMore">Load More <x-small-spinner condition="delay" target="loadMore" />
                        </div> @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade " id="transactionDetails" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content">
                @isset($details)
                <div class="d-flex justify-content-center" style="margin-top: -30px;">
                    <img class="theme-bg-2" style="width:60px;height:60px;border-radius:50%;" src="{{ asset('storage/coins/'.$details->asset.'.png')}}" alt="">
                </div>
                <div class="title text-center">
                    <label class="text-center">Transaction Details </label>
                </div>
                <div class="card-body scroll-y border-top p-2">
                    <div class=" radius-8 text-center mb-2">
                        <h2 class="strong mb-0 mt-2 upper">
                            {{monify($details->amount)}} {{$details->asset}}<br> Sale
                        </h2>
                        <label class="text-center">
                            <small class="py-2 {{($details->status=='successful')?'text-success':'text-danger'}}">
                                {{ucwords($details->status)}}
                            </small>
                        </label>

                    </div>
                    <div class="d-flex justify-content-between p-2 mb-2"></div>
                    <div class="border-1 radius-8 ">
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Amount</span>
                            <span class="upper"> {{monify($details->amount)}} {{str_replace('-',' ',$details->asset)}} </span>
                        </div>
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Sold</span>
                            <span class="upper">@ ${{monify($details->asset_value)}}</span>
                        </div>
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Transaction ID</span>
                            <span class="">#{{$details->transaction_id}} </span>
                        </div>
                        <div class="d-flex justify-content-between p-2 ">
                            <span class="">Date</span>
                            <span class="">{{format_date($details->created_at)}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 d-flex justify-content-center  border-top">
                    <label wire:click="close('transactionDetails')" class="theme-bg mt-2 border-1 btn padding-10x20 shadow-xs text-center m-1 radius-24">
                        Close
                    </label>
                </div>
                @endisset
            </div>
        </div>
    </div>
</div>