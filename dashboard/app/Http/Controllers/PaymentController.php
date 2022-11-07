<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout()
    {

        if(auth()->user()->subscribed('default'))
            return redirect()->route('dashboard.system');

        return view('dashboard.index', [
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    public function store(Request $request)
    {
        $request->user()
            ->newSubscription('default', 'price_1M1BEoDizeJD4JCWVLV9BQj2')
            ->create($request->token);

        return redirect()->route('dashboard.system');
    }

    public function system()
    {
        return view('dashboard.system');
    }

    public function account()
    {
        $invoices = auth()->user()->invoices();
        return view('dashboard.account', compact('invoices'));
    }

    public function invoiceDownload($invoiceId)
    {

        return Auth::user()
                    ->downloadInvoice($invoiceId, [
                        'vendor' => config('app.name'),
                        'product' => 'Aluguel Lanchonete Ecommerce'
                    ]);
    }
}
