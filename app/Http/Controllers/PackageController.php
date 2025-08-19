<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\TokenPackage;
use App\Models\Transaction;
use App\Services\User\PurchasePackage;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PackageController extends Controller {

    // plans page
    public function index() {
        $plans = TokenPackage::orderBy('price')->get();

        return view('plans', compact('plans'));
    }

    // plans payment method page
    public function paymentMethod(Request $request, TokenPackage $tokenPackage) {

        return view('plans-payment-methods', compact('tokenPackage'));
    }

    // purchase plan
    public function purchase(Request $request, TokenPackage $tokenPackage) {
        $userId = auth()->user()->id;
        $packageId = $tokenPackage->id;
        $amount = $tokenPackage->price;
        $paymentMethodId = $request->get('payment_id');

        $payment = PaymentMethod::whereId($paymentMethodId)->firstOrFail();

        $invoice = new Invoice;
        $invoice->amount($amount);

        return Payment::via($payment->bank_name)->purchase($invoice, function ($driver, $transactionId) use ($userId, $packageId, $amount, $paymentMethodId) {
            Transaction::create([
                'user_id' => $userId,
                'track_id' => $transactionId,
                'tr_type' => 'buy package',
                'payment_method_id' => $paymentMethodId,
                'tr_amount' => $amount,
                'tr_status' => 'pending',
                'package_id' => $packageId,
            ]);
        })->pay()->render();
    }

    // payment callback
    public function callback(Request $request) {
        $trackId = $request->get('trackId');
        $receipt = null;
        $view = '';

        $tr = Transaction::query()
            ->whereTrackId($trackId)
            ->whereTrStatus('pending')
            ->wherePaymentMethodId(function ($query) {
                $query->select('id')->from('payment_methods')->whereBankName('zibal');
            })->firstOrFail();
        $package = TokenPackage::whereId($tr->package_id)->first();

        try {
            $receipt = Payment::amount($package->price)->transactionId($tr->track_id)->verify();
            (new PurchasePackage)->afterSuccessfulPackagePayment($tr->user_id, $package->id);
            $tr->tr_status = 'success';
            $tr->save();
            $view = 'payment-successfull';
        } catch (InvalidPaymentException $exception) {
            $tr->tr_status = 'failed';
            $tr->comment = $exception->getMessage();
            $tr->save();
            $view = 'payment-unsuccessfull';
        }

        return view($view, compact('package', 'tr', 'receipt'));
    }

    // payment callback saderat
    public function callback2(Request $request) {
        $receipt = null;
        $view = '';

        $tr = Transaction::query()
            ->whereUserId(auth()->user()->id)
            ->whereTrStatus('pending')
            ->wherePaymentMethodId(2)
            ->orderBy('id', 'desc')
            ->firstOrFail();
        $package = TokenPackage::whereId($tr->package_id)->first();

        try {
            $receipt = Payment::via('sepehr')->amount($package->price)->transactionId($tr->track_id)->verify();
            (new PurchasePackage)->afterSuccessfulPackagePayment($tr->user_id, $package->id);
            $tr->tr_status = 'success';
            $tr->save();
            $view = 'payment-successfull';
        } catch (InvalidPaymentException $exception) {
            $tr->tr_status = 'failed';
            $tr->comment = $exception->getMessage();
            $tr->save();
            $view = 'payment-unsuccessfull';
        }

        return view($view, compact('package', 'tr', 'receipt'));

        // $data = [
        //     "respmsg" => "تراکنش توسط کاربر لغو شد.",
        //     "respcode" => "-1",
        //     "terminalid" => "98194075",
        //     "invoiceid" => "85cdb611-ea6a-4bfd-a475-3f1e34399dfb",
        //     "amount" => "500000",
        //     "payload" => "null",
        // ];

        //   "terminalid" => "98194075"
        //     "invoiceid" => "8169f1a6-4919-4fff-a4c5-3ae069927768"
        //     "amount" => "500000"
        //     "cardnumber" => "603799******3861"
        //     "payload" => "null"
        //     "rrn" => "126069595026"
        //     "tracenumber" => "907798"
        //     "digitalreceipt" => "3cfb9793-3551-4339-9eda-2dd041963ab5"
        //     "datepaid" => "1402-02-25 17:13:50"
        //     "respcode" => "0"
        //     "respmsg" => "0 - تراکنش موفق انجام شده است"
        //     "issuerbank" => "بانک ملی"

    }
}
