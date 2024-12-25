<form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$stage}}">
    <div class="modal-body scroll-y">
        @if($stage=='bioData')
        <fieldset class="{{$stage}}"> <legend>BIO DATA</legend>
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
                <small class="text-warning small-size p-2">Fullname must match record on your ID </small>
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
            </div>
        </fieldset>
        @elseif($stage=='Address')
        @elseif($stage=='Finance')
        @elseif($stage=='Identity')
        @else @endif
    </div>
    <div class="modal-footer d-flex justify-content-end p-0">
        <button type="submit" class="btn elevation-1 theme-bg mb-3"> Submit
            <x-small-spinner condition="delay" target="{{$stage}}" />
        </button>
    </div>
</form>