<div>
    @if(auth()->user()->kyc_level == 'none')
    <div class="content-header">
        <div class=" warning-bg radius-4 container-fluid" >
            <div class=" d-flex justify-content-between p-1">
                <ol class="breadcrumb float-sm-left">
                    <span class="text-danger btn btn-xxs small-size"><i class="fas fa-info-circle"></i> Unverified Account!</span>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    <a href="{{route('user.profile',['autoshow' => 'basic-kyc'])}}" class="text-danger btn btn-xxs border radius-8 small-size">verify <i class="right fas fa-angle-right p-1"></i></a>
                </ol>
            </div>
        </div>
    </div>
    @endif
    <!-- Main content -->
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="p-3 col-md-12">
                    <div class="shadow-none transparent card ">
                        <div class="p-2 card-body ">
                            <p class="d-flex justify-content-start">
                            <h3>Hello {{auth()->user()->username ?? first_word(auth()->user()->name)}}, </h3>
                            </p>
                            <div class="d-block">
                                <div class="m-0 row"> <strong class="large-size">@isset($traded) ${{monify($traded)}} @else $0 @endisset</strong></div>
                                <div class="m-0 row"> <small>Amount Traded</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2">
                <div class="airdrop-card">
                    @forelse($coins as $coin)
                    <div class="mb-1 small-box">
                        <div class="d-flex justify-content-between p-2">
                            <div class="inner">
                                <h5 class="capital">{{$coin->name}}</h5>
                                <small class="upper" style="margin-top:-2px">{{$coin->symbol}} </small>
                                <p class="mt-1">
                                <h5>@ ${{monify($coin->rate)}}/USD </h5>
                                <h6><small>Minimum Amount {{$coin->minimum}}</small></h6>
                                </p>
                            </div>
                            <div class="p-2">
                                <img class="image-circle-80" src="{{ asset('storage/coins/'.$coin->icon)}}" alt="{{$coin->name}} Image">
                            </div>
                        </div>
                        <div class="small-box-footer d-flex justify-content-center  border-top p-2">
                            @if(auth()->user()->kyc_level == 'none')
                            <small wire:click="open('updatedprofile')" class="btn btn-default  btn-xs " style="border-radius: 20px !important; padding-left:9px">Sell Your Tron <i class="fas fa-arrow-right p-2"></i></small>
                            @else
                            <small wire:click="openBuy({{$coin->id}})" class="btn btn-default  btn-xs " style="border-radius: 20px !important; padding-left:9px">Sell Your Tron <i class="fas fa-arrow-right p-2"></i></small>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="empty">
                        <div class="text-center p-2">
                            <i class="fas fa-info-circle mt-2 auto-margin-rl opacity-0-4" style="font-size: 60px;"></i>
                            <div class="card-body text-center p-2 ">
                                <span>Sorry No tradable coin is available at the moment</span>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="noSellModal" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-danger card-danger">
                <div class="modal-body text-center p-2">
                    <i class="fas fa-exclamation-circle mt-2 text-danger " style="font-size:80px"></i>
                    <div class="card-body text-center p-2">
                        Hey! No buyer is available for this coin at the moment. Check others or try again later
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <span wire:click="close('noSellModal')" class="radius-4 btn elevation-1 btn-danger">
                        Ok, Close
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sellCoinModal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content border-top">
                @isset($selected->payaddress->network)
                <div class="modal-header">
                    <h4 class="modal-title">
                        Sell {{strtoupper($selected->symbol)}} ({{strtoupper($selected->payaddress->network)}})
                    </h4>
                    <span wire:click="close('sellCoinModal')" class="close">&times;</span>
                    </span>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$steps== 0 ?'sellCoin':'uploadPOP';}}">
                    @if($steps== 1)
                    <div class="scroll-y card-body">
                        <div class="text-center" style="margin-top: -10px;">
                            <p>Pay ${{monify($transaction->amount)}} to this address</p>
                            <img style="width:150px; height:150px;" class="radius-8 p-2 border"
                                src="@if ($qrCodeGenerated && $qrCodeDataUri) {{ $qrCodeDataUri }} 
                                    @else {{asset('storage/qrs/'.(($transaction->qrcode == NULL)? 'errorqr.png' : $transaction->qrcode))}} @endif
                                " alt="{{strtoupper($selected->name)}} Image">
                            <h4 class="m-0">Scan QRCode</h4>
                            <p class="text-center p-0"><strong>OR</strong></p>
                            <div class="d-flex justify-content-between">
                                <span class="btn btn-xs btn-default elevation-1 mb-1" onclick="copy('#toca');">Copy Address</span>
                                <span wire:click="cancelTransaction({{$transaction->id}})" class="btn btn-xs theme-bg elevation-1 mb-1">Cancel Transaction</span>
                            </div>
                            <p class="text-center small-size p-2 radius-4 border" id="toca">
                                {{$selected->payaddress->address}}
                            </p>
                            <div x-data="time_remain('{{ $transaction->duration }}','minutes')" x-init="init()" class="mb-2">
                                This Transaction Expires in
                                <template x-if="getTime() > 0"><span x-text="formatTime(getTime())"></span> Mins </template>
                            </div>
                        </div>
                        <div class="border radius-4">
                            <div class="d-flex justify-content-between border-bottom p-2">
                                <span class="strong">Quantity you are selling</span> <span>${{monify($transaction->amount)}}</span>
                            </div>
                            <div class="d-flex justify-content-between  border-bottom p-2">
                                <span class="strong">Expected Amount</span> <span>${{monify($transaction->asset_value)}}</span>
                            </div>
                            <div class="d-flex justify-content-between  border-bottom p-2">
                                <span class="strong">status</span> <span>{{$transaction->status}}</span>
                            </div>
                        </div>
                        <p class="text-center theme-bg-light radius-4 mt-1 p-2">{{$steps== 1 ?'After making payment, Upload the screenshot by click on the ULOAD PAYMENT PROOF below':'';}}</p>
                    </div>
                    @elseif($steps== 2)
                    <div class="scroll-y card-body" style="margin-top: -10px;">
                        <p class="p-3 text-center"> Upload Proof Of Payment</p>
                        <div class="d-flex justify-content-center">
                            <img src="{{$pop?$pop->temporaryUrl():asset('storage/pops/pop.png')}}" style="width:200px;border-radius:8px;" class="{{$pop?'':'opacity-0-4'}} p-2 border-1 m-1 text-center d-block" alt="pop">
                        </div>
                        <div class="form-group p-3">
                            <div x-data="{ isUploading:false, progress:3 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="input-group mb-1">
                                    <div class="custom-file">
                                        <input type="file" wire:model="pop" accept="image/*" class="border-1 custom-file-input  @error('pop') is-invalid @enderror" id="pop">
                                    </div>
                                    <div class="input-group-append ">
                                        <label class="border-1 custom-file-label" for="pop">{{$pop?$pop->getClientOriginalName():'Upload POP'}}</label>
                                    </div>
                                </div>
                                <div x-show="isUploading" class="progress progress-xs ">
                                    <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped radius-4" role="progressbar"
                                        aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="scroll-y card-body">
                        <div class="text-center" style="margin-top: -20px;">
                            <img style="width: 45px; height: 45px;" class="image-circle-80" src="{{ asset('storage/coins/'.$selected->icon)}}" alt="{{strtoupper($selected->name)}} Image">
                            <h4>You are selling {{strtoupper($selected->symbol)}}</h4>
                            <p class="text-center">@ ${{monify($selected->rate)}} per USD</p>
                            <p class="text-center small-size"><i class="fas fa-info-circle"></i> Rate may change before transaction is completed</p>
                        </div>

                        <div class="mb-0 form-group row ">
                            <label for="amount" class="col-sm-12 col-form-label">Quantity of {{strtoupper($selected->symbol)}} you are selling? </label>
                            <div class="col-sm-12">
                                <input type="text" id="amount" wire:model="amount" class="form-control @error('amount') is-invalid @enderror " placeholder="Enter the quantity you want to sell ">
                                @error('amount')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                <p class="text-center small-size text-warning"> This is the quantity of {{strtoupper($selected->symbol)}} you want to sell. Minimum quantity is {{monify($selected->minimum)}} {{strtoupper($selected->symbol)}}</p>
                            </div>
                        </div>
                        <div class="mt-0 form-group row">
                            <label for="expectedamount" class="col-sm-12 col-form-label">Expected Amount</label>
                            <div class="col-sm-12">
                                <input readonly type="text" id="expectedamount" wire:model="expectedamount" class="form-control ">
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="modal-footer justify-content-center">
                        @if($steps== 1)
                        <span wire:click="openPOP(2)" class="padding-10x20 radius-24 btn elevation-1 theme-bg"> Upload Payment Proof </span>
                        @else
                        <button type="submit" class="padding-10x20 radius-24 btn elevation-1 theme-bg">
                            {{$steps== 0 ?' Continue ':' Save Payment Proof ';}}
                            <x-small-spinner condition="delay" target="{{$steps== 0 ?'sellCoin':'uploadPOP';}}" />
                        </button>
                        @endif

                    </div>
                </form>
                @endisset
            </div>
        </div>
    </div>

    <div class="modal fade" id="noBankNoticeModal" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-body text-center p-2">
                    <i class="fas fa-info-circle mt-2 text-warning " style="font-size:80px"></i>
                    <div class="card-body text-center p-2">
                        Hey! No payment bank found for receiving funds.
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <span wire:click="close('noBankNoticeModal')" class="radius-8 btn elevation-1 btn-danger">
                        Close
                    </span>
                    <span wire:click="goto('{{route('user.payment')}}')" class="radius-8 btn elevation-1 theme-bg">
                        Add Bank Account
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>