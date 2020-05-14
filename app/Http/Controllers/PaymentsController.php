<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Stripe\Plan;

class PaymentsController extends Controller
{
    public function pay(Request $request, Plan $plan)
    {
        $token = $_POST['stripeToken'];
        $user = Auth::user();
        if ($user->subscribed('primary')) {
            $user->subscription('primary')->swap($plan);
        } else {
            $user->newSubscription('main', $plan->stripe_plan)
                ->trialDays(14)
                ->withCoupon('10off')
                ->create($request->stripeToken);
        }
        return redirect('profile');
    }

    public function cancel (){
        Auth::user()->subscription('primary')->cancel();

        return redirect('profile');

    }

    public function invoice(Request $request, $invoiceId){

        return $request->user->downloadInvoice($invoiceId, [
            'vendor' => 'Cashier',
            'product' => 'Primary subscription'
        ]);

    }
}
