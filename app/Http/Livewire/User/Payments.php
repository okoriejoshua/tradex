<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Payment as ModelPayment;
use Illuminate\Support\Facades\validator;
 

class Payments extends UserComponent
{
    public $isEdit =  false; 
    public $state = [];
    public $payments = null;
    public $editData = null;
    public $type   = 'none'; 
   

    public function render()
    {
        $payQuery = ModelPayment::where('user_id', auth()->user()->id)->latest()->get();
        $this->payments = $payQuery ? $payQuery : null;

        $this->type = isset($this->state['type'])? $this->state['type'] :'none';

        return view('livewire.user.payment', [
            'payments' => $this->payments,
            'type' => $this->type,
        ]);
    }

   

    public function createBank()
    {
        $validatedData = validator::make($this->state, [
             'account_name' => 'required',
            'account_number' => 'required|numeric',
            'bank_name' => 'required',
            'type' => 'required',
        ])->validate();

        if(isset($this->state['note'])){
            $validatedData['note'] = $this->state['note'];
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['is_active']  = true; 

        if($this->payments->count() == 0){
            $validatedData['is_default'] = true;
        } 

        if(ModelPayment::create($validatedData)){
            $status = true;
            $message ='New payment bank added successfully';
        }else{
            $status = false;
            $message = 'Unable to add new payment bank';
        }
        $this->dispatchBrowserEvent('modal-hide', ['status'=>$status,'modalid' => 'newBankmodal', 'message' => $message]);
    }


      public function openEdit($id)
    {
         $this->editData    = $this->payments->where('id', $id)->first();
         $this->state       =  $this->editData->toArray();
         $this->isEdit      = true;
         $this->open('newBankmodal'); 

    }

    public function openAdd($nameOfModal)
    {
        unset($this->state);
        $this->open($nameOfModal);
    }

    public function makeDefault($id)
    {
        foreach ($this->payments as $payment) {
            $payment->fill(['is_default' => false])->save();
        }

        $update    = $this->payments->where('id', $id)->first();
        $update->fill(['is_default' => true])->save();
        $this->payments;
        $this->render();
    }

    public function deleteBank($id)
    {
        $this->payments->where('id', $id)->first()->delete();
       
    }



    public function updateBank()
    {

        $validatedData = validator::make($this->state, [
            'account_name' => 'required',
            'account_number' => 'required|numeric',
            'bank_name' => 'required',
            'type' => 'required',
        ])->validate();

        if (isset($this->state['note'])) {
            $validatedData['note'] = $this->state['note'];
        }
       
        if($this->editData->update($validatedData)) {
            $status = true;
            $message = 'Payment bank Updated successfully';
        } else {
            $status = false;
            $message = 'Bank update failed';
        }
        $this->dispatchBrowserEvent('modal-hide', ['status' => $status, 'modalid' => 'newBankmodal', 'message' => $message]);
        $this->reset();
    }
}
