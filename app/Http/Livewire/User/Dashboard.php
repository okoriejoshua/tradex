<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\{Coin, Transaction, Payment};
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Color\Color;


class Dashboard extends UserComponent
{
    use WithFileUploads;
    public $coins = null;
    public $selectedCoin = null;
    public $expectedamount = '';
    public $amount = '';
    public $expiresIn = 30;
    public $steps = 0;
    public $transaction = null;
    public $paydata = null;
    public $pop;
    public $qrCodeDataUri;
    public $qrCodeGenerated = false;
    public $expiredtransactions;
    public $totalAmountTraded;


    public function mount()
    {
        $this->calculateTotalAmount();
    }


    public function hydrate()
    {
        $this->checkExpirations();
    }

    public function render()
    {

        $this->coins = Coin::where('status', true)->latest()->get();

        return view('livewire.user.dashboard', [
            'coins'    => $this->coins,
            'selected' => $this->selectedCoin,
            'steps' => $this->steps,
            'transaction' => $this->transaction,
            'traded' => $this->totalAmountTraded,
        ]);
    }


    public function calculateTotalAmount()
    {
        $this->totalAmountTraded = Transaction::where('user_id',auth()->user()->id)->where('status', 'successful')->sum('asset_value');
    }
    

    public function openBuy($id)
    {
        $this->reset();
        $this->paydata  = Payment::where('user_id',auth()->user()->id)->where('is_default', true)->first();
        
        if ($this->paydata) {
            $this->selectedCoin    = Coin::with('payaddress')->where('id', $id)->first();
            $this->transaction    = Transaction::where('asset', $this->selectedCoin->symbol)
                ->where('user_id', auth()->user()->id)
                ->where('status', 'waiting for pop')
                ->first();

            $this->steps = $this->transaction ? 1 : 0;
           isset( $this->selectedCoin->payaddress->address) ? $this->open('sellCoinModal'): $this->open('noSellModal');
        } else {
            $this->open('noBankNoticeModal');
        }
    }



    public function updatedAmount($value)
    {
        $cleanedValue = preg_replace('/[^0-9.]/', '', $value);
        if (substr_count($cleanedValue, '.') > 1) {
            $cleanedValue = substr($cleanedValue, 0, strrpos($cleanedValue, '.'));
        }
        $this->amount = $cleanedValue;

        if ($cleanedValue !== '' && is_numeric($cleanedValue)) {
            $this->expectedamount = round($cleanedValue * $this->selectedCoin->rate, PHP_ROUND_HALF_UP, 3);
        } else {
            $this->expectedamount = '';
        }
    }


    public function sellCoin()
    {
        $Query = Transaction::create([
            'user_id' =>  auth()->user()->id,
            'payment_id' => $this->paydata->id,
            'asset'   => $this->selectedCoin->symbol,
            'amount'  => $this->amount,
            'asset_value' => $this->expectedamount,
            'transaction_id' => unik(),
            'duration' => Carbon::now()->addMinutes($this->expiresIn),
            'status' => 'waiting for pop',
            'destination'   => $this->selectedCoin->payaddress->address,
            'network'   => $this->selectedCoin->payaddress->network,
            'steps' => 1,
        ]);

        $this->steps = $Query ? 1 : 0;
        $this->transaction = $Query ? $Query  : null;
        if ($Query) {
            $this->generateQrCode($this->selectedCoin->payaddress->address);
            $this->qrCodeGenerated = true;
        }
    }

    private function generateQrCode($address)
    {

        if (!$address) {
            $this->qrCodeDataUri = null;
            $this->qrCodeGenerated = false;
            return;
        }

        if (Storage::disk('qrs')->exists($address)) {
            return $address;
        }

        try {
            $qrCode = QrCode::create($address)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->setSize(300)
                ->setMargin(10)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $this->qrCodeDataUri = $result->getDataUri();
            $image = $result->getString();
            $qrname = $address . '.png';
            //save qr
            Storage::disk('qrs')->put($qrname, $image);
            $this->transaction->fill([
                'qrcode' => $qrname
            ])->save();
            return $address;
        } catch (\Exception $e) {
            $this->qrCodeDataUri = null;
            $this->qrCodeGenerated = false;
        }
    }

    public function uploadPOP()
    {

        $popname =  $this->transaction->user_id . '_' . $this->transaction->transaction_id . '_pop' . '.png';

        $validatedData = $this->validate(['pop' => 'required|image|max:1024']);
        Storage::disk('pops')->delete([$this->transaction->pop]);
        $validatedData['pop']->storeAs('/', $popname, 'pops');
        $this->transaction->fill([
            'pop' => $popname,
            'status' => 'processing',
            'steps' => 3,
        ])->save();
        $this->dispatchBrowserEvent('modal-hide', ['status' => true, 'modalid' => 'sellCoinModal', 'message' => 'POP Uploaded successfully, Funds will be transfered to your Bank after Confirmation']);
        $this->reset();
    }

    public function openPOP($step)
    {
        $this->steps = $step;
    }

    public function cancelTransaction($id)
    {
        $this->transaction->where('id', $id)->first()->delete();
        $this->openBuy($this->selectedCoin->id);
    }



    private function checkExpirations()
    {
        $expiredTransactions = Transaction::where('status', 'waiting for pop')
            ->where('duration', '<', Carbon::now())
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $transaction->status = 'expired';
            $transaction->save();
        }
    }
}
