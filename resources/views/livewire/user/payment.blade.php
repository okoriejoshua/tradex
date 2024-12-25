<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right strong">
                    Bank & Payment
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="modal-header ">
                        <h3 class="card-title"><strong>My Banks</strong></h3>
                        <span wire:click="openAdd('newBankmodal')" class="btn theme-bg radius-24 elevation-1">
                            <i class="fas fa-plus"></i> Add New
                        </span>
                        <x-small-spinner condition="delay" target="makeDefault, deleteBank, openEdit" />
                    </div>
                    <div class="p-2  card-body pending">
                        @forelse($payments as $payment)
                        <div>
                            <div class="radius-8 theme-bg-linear-card info-box mb-2 shadow-xs  ">
                                <div class="info-box-content capital">
                                    <span class="info-box-text">{{$payment->bank_name}}</span>
                                    <span class="info-box-text"><small class="small-size">{{$payment->account_name}}</small></span>
                                    <span class="info-box-text"><small class="small-size">{{$payment->account_number}}</small></span>
                                </div>
                                <div style="text-align: end;" class="info-box-content">
                                    @if($payment->is_default ==true)
                                    <span class="btn btn-sm small-size radius-24" style="background-color:#0000003d; color:#fff"><i class="fas fa-check-circle small-size text-success"></i> Default</span>
                                    @else
                                    <span wire:click.prevent="makeDefault({{$payment->id}})" class="btn btn-sm small-size radius-24" style="background-color:#0000003d; color:#fff">Make default</span>@endif
                                    <span wire:click.prevent="deleteBank({{$payment->id}})" class="info-box-text"><i class="fas fa-trash"></i></span>
                                    <span wire:click.prevent="openEdit({{$payment->id}})" class="info-box-text"><i class="fas fa-edit"></i></span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty">
                            <div class="text-center p-2">
                                <i class="fas fa-info-circle mt-2 auto-margin-rl opacity-0-4" style="font-size: 60px;"></i>
                                <div class="card-body text-center p-2 ">
                                    <span>You do not have any payment bank</span>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="card-footer text-center">
                        <span> View all</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="newBankmodal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content border-top">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{$isEdit?'Update Bank Details ':' Add New Bank  '}}
                    </h4>
                    <span wire:click="close('newBankmodal')" class="close">&times;</span>
                    </span>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$isEdit?'updateBank':'createBank'}}">
                    <div class="scroll-y card-body">
                        <div class="form-group row">
                            <label for="account_name" class="col-sm-12 col-form-label">Account Name </label>
                            <div class="col-sm-12">
                                <input type="text" id="account_name" wire:model.defer="state.account_name" class="form-control @error('account_name') is-invalid @enderror " placeholder="Account Name ">
                                @error('account_name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account_number" class="col-sm-12 col-form-label">Account Number </label>
                            <div class="col-sm-12">
                                <input type="text" id="account_number" wire:model.defer="state.account_number" class="form-control @error('account_number') is-invalid @enderror " placeholder="Account Number ">
                                @error('account_number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-12 col-form-label">Bank Name </label>
                            <div class="col-sm-12">
                                <input type="text" id="bank_name" wire:model.defer="state.bank_name" class="form-control @error('bank_name') is-invalid @enderror " placeholder=" Destination Bank ">
                                @error('bank_name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Account Type </label>
                            <div class="btn-group-toggle">
                                <label class="border-1 btn {{$type=='savings'?'theme-bg':'btn-default'}} shadow-xs text-center m-1 radius-24">
                                    <input type="radio" wire:model="state.type" name="type" autocomplete="off" value="savings">
                                    <small>Savings</small>
                                </label>
                                <label class="border-1 btn {{$type=='current'?'theme-bg':'btn-default'}}  shadow-xs text-center m-1 radius-24">
                                    <input type="radio" wire:model="state.type" name="type" autocomplete="off" value="current">
                                    <small>Current</small>
                                </label>
                            </div>
                            @error('type')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Additional Details (Optional)</label>
                            <textarea wire:model.defer="state.note" class="form-control @error('note') is-invalid @enderror " rows="3" placeholder="Additional Details (Optional)"></textarea>
                            @error('note')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="padding-10x20 radius-24 btn elevation-1 theme-bg">
                            {{$isEdit?'Update Account ':'Add Account '}}
                            <x-small-spinner condition="delay" target="{{$isEdit?'updateBank':'createBank'}}" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>