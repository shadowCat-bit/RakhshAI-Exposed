<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\TokenPackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PackageController extends Controller {

    public function packages() {

        $packages = TokenPackage::orderBy('price')->get();

        return response()->json($packages);
    }

    public function paymentMethods() {

        $paymentMethods = PaymentMethod::whereIsActive(1)->get();

        return response()->json($paymentMethods);
    }

    public function purchase(Request $request) {

        $userId = auth()->user()->id;
        $tokenPackage = TokenPackage::findOrFail($request->package_id);
        $packageId = $tokenPackage->id;
        $amount = $tokenPackage->price;
        $paymentMethodId = $request->payment_id;

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
}
