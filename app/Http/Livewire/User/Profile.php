<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\KYCData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\validator;
use Livewire\WithFileUploads;

use App\Mail\SendEmailCode;
use Illuminate\Support\Facades\Mail;

class Profile extends UserComponent
{
    use WithFileUploads;
    public $state = [];
    public $ud;
    public $photo;

    public $autoShowModal = false;
    public $autoshow = null;
    public $stage = 'bioData';
    public $kycsteps = 1;
    public $cardfront;
    public $cardback;
    public $cardview = 'front';
    public $cardviewswap = false;
    public $stageswap = false;
    public $isnotify = false;

    public $receiver_email = 'reallgodlove@gmail.com';
    public $subject = 'TestMail';
    public $content = 'Yes , its working';

    protected $rules = [
        'receiver_email' => 'required|email',
        'subject' => 'required|string|max:255',
        'content' => 'required|string',
    ];



    public function openChangePhotoTab($userdata)
    {
        $userdata  = User::findOrFail(auth()->user()->id);
        $this->state = $userdata->toArray();
        $this->dispatchBrowserEvent('show-change-photo-form');
    }


    public function updateProfileInfo()
    {
        $validatedData = validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->ud->id,
            'phone' => 'required|numeric',
        ])->validate();

        $this->ud->update($validatedData);
        $profile_name = $validatedData['name'];
        $this->dispatchBrowserEvent('form-response-profile-update', ['profile_name' => $profile_name, 'message' => 'User Details Updated Successfully!']);
    }

    public function savePhoto()
    {

        $renamed = $this->ud->id . '-' . time() . '.png';
        $validatedData = $this->validate(['photo' => 'image|max:1024',]);

        Storage::disk('photos')->delete($this->ud->photo);
        $validatedData['photo'] = $this->photo->storeAs('/', $renamed, 'photos');
        $this->ud->fill(['photo' => $renamed,])->save();

        $newPhotoUrl = asset('storage/photos/' . $renamed);
        $this->reset();
        $this->dispatchBrowserEvent('form-response-photo-update', ['photo_url' => $newPhotoUrl, 'message' => 'Photo Uploaded Successfully!']);
    }


    public function updatePassword()
    {
        $validatedData = validator::make($this->state, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ])->validate();

        if (Hash::check($validatedData['current_password'], $this->ud->password)) {
            $this->ud->fill([
                'password' => Hash::make($validatedData['password']),
            ])->save();

            $isSuccess = true;
            $responseMsg = 'User Pasword Updated Successfully!';
        } else {
            $isSuccess = false;
            $responseMsg = 'The provided old password does not match your current password';
        }

        $this->dispatchBrowserEvent('form-response-password', ['status' => $isSuccess, 'message' => $responseMsg]);
    }

    /*public function oneTimeProfileUpdate()
    {
        $checkedData = validator::make($this->state, [
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'dob' => 'required',
            'username' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
        ])->validate();

        $checkedData['is_updated'] = true;
        $this->ud->update($checkedData);
        $this->dispatchBrowserEvent('notify-modal', ['status' => true, 'modalid' => 'updatedProfileModal', 'message' => 'Account Info Updated']);
        $this->redirect(route('user.profile'));
    }*/

    public function verifyMailModal()
    {
        $this->open('verifyEmail');
    }

    public function changeNickNameModal()
    {
        $this->state['nickname'] = $this->ud->username;
        $this->open('changeNickName');
    }



    public function nickName()
    {
        $checkedData = validator::make($this->state, [
            'nickname' => 'required|string|max:255',
        ])->validate();

        $iData['username'] =  $checkedData['nickname'];
        $this->ud->update($iData);
        $this->refresher();
        $this->dispatchBrowserEvent('modal-hide', ['status' => true, 'modalid' => 'changeNickName', 'message' => 'Nick Name Updated']);
    }

    public function bioData()
    {
        $checkedData = validator::make($this->state, [
            'name' => 'required|string|max:255',
            'dob' => 'required',
            'username' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
        ])->validate();

        if ($this->stageswap == false) {
            $checkedData['stage'] = 'Address';
            $this->stage = 'Address';
        }

        $this->ud->update($checkedData);
        $this->notify('Bio Data Submitted');
    }

    public function Address()
    {
        $checkedData = validator::make($this->state, [
            'country' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
        ])->validate();

        if ($this->stageswap == false) {
            $checkedData['stage'] = 'Identity';
            $this->stage = 'Identity';
        }

        $checkedData['kyc_level'] = 'none';
        $this->ud->update($checkedData);
        $this->notify('Verifiable Address Submitted');
    }


    public function Identity()
    {
        $validatedData = validator::make($this->state, [
            'card_type' => 'required',
            'name_on_card' => 'required',
            'expiry' => 'sometimes',
            'serial_number' => 'sometimes|numeric',
        ])->validate();

        $validatedData['country_issued'] = auth()->user()->country;
        if ($this->ud->kycData) {
            $validatedData['expiry']        = isset($validatedData['expiry']) ? $validatedData['expiry'] : null;
            $validatedData['serial_number'] = isset($validatedData['serial_number']) ? $validatedData['serial_number'] : null;

            $this->ud->kycData->card_type      = $validatedData['card_type'];
            $this->ud->kycData->name_on_card   = $validatedData['name_on_card'];
            $this->ud->kycData->country_issued = $validatedData['country_issued'];
            $this->ud->kycData->expiry = $validatedData['expiry'];
            $this->ud->kycData->serial_number = $validatedData['serial_number'];
            $this->ud->kycData->steps = 2;
            $this->ud->kycData->save();
        } else {
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['steps'] = 2;
            KYCData::create($validatedData);
        }

        $checkedData['stage'] = 'UploadKYC';
        $checkedData['kyc_level'] = 'none';
        $this->ud->update($checkedData);
        $this->stage = 'UploadKYC';
        $this->notify('Identification Data Submitted');
    }

    public function UploadKYC()
    {

        $cardfront = $this->ud->kycData->user_id . '_kyc_' . $this->ud->kycData->card_type . '_front' . '.png';
        $cardback  = $this->ud->kycData->user_id . '_kyc_' . $this->ud->kycData->card_type . '_back' . '.png';

        $this->validate(['cardfront' => 'required|image|max:1024', 'cardback' => 'required|image|max:1024',]);

        Storage::disk('kyc')->delete([$this->ud->kycData->card_front, $this->ud->kycData->card_back]);

        $this->cardfront->storeAs('/', $cardfront, 'kyc');
        $this->cardback->storeAs('/', $cardback, 'kyc');

        $this->ud->kycData->fill([
            'card_front' => $cardfront,
            'card_back' => $cardback,
            'status' => 'pending',
            'steps' => 3,
        ])->save();

        $checkedData['stage'] = 'KYCstatus';
        $checkedData['kyc_level'] = 'none';
        $this->ud->update($checkedData);
        $this->stage = 'KYCstatus';
        $this->notify('Verifiable Identity Data Submitted');
    }


    public function updatedCardfront()
    {
        $this->validate([
            'cardfront' => 'image|max:1024',
        ]);

        $this->cardview = 'back';
    }

    public function updatedCardback()
    {
        $this->validate([
            'cardfront' => 'image|max:1024',
        ]);

        $this->cardview = 'back';
        $this->cardviewswap = true;
    }

    public function notify($msg)
    {
        $this->dispatchBrowserEvent('notify-modal', ['message' => $msg]);
    }


    public function stageSwap($stage)
    {
        $this->stage = $stage;
        $this->stageswap = true;
        $this->isnotify = $this->ud->kycData ? true : false;
        $this->open('updatedProfileModal'); 
    }

    public function sendEmailCode()
    {
        $this->validate();

        /* $uservcode  = User::with('verifycode')->find(auth()->user()->id);
        $isSend = Mail::to($this->receiver_email)->send(new SendEmailCode([
            'receiver_email' => $this->receiver_email,
            'subject' => $this->subject,
            'content' => $this->content,
        ]));

        if ($isSend) {
            $this->notify('Verification Code Sent');
        } else {
            $this->notify('Verification Code Not Sent');
        }*/
    }

    public function render()
    {

        $this->ud  = User::with('kycData')->find(auth()->user()->id);
        $this->state = $this->ud->toArray();

        if ($this->autoshow == 'basic-kyc') {
            $this->autoShowModal =  true;
            $this->stage = $this->ud->stage ? $this->ud->stage : $this->stage;
        }

        if ($this->ud->kycData) {
            $this->state = array_merge($this->state, $this->ud->kycData->toArray());
            $this->kycsteps = $this->ud->kycData->steps;
        }

        isset($this->cardfront) ? $this->updatedCardfront() : '';
        isset($this->cardback) ? $this->updatedCardback() : '';

        return view('livewire.user.profile', [
            'ud' => $this->ud,
            'stage' => $this->stage,
            'autoShowModal' => $this->autoShowModal,
            'kycsteps' => $this->kycsteps,
            'cardview' => $this->cardview,
            'cardviewswap' => $this->cardviewswap,
            'isnotify' => $this->isnotify,
        ]);
    }

    
}
