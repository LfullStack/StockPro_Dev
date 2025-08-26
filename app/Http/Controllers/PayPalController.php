<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\{Amount, Item, ItemList, Payer, Payment, PaymentExecution, RedirectUrls, Transaction};
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );
        $this->apiContext->setConfig([
            'mode' => config('services.paypal.mode'),
        ]);
    }

    public function checkout(Request $request)
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) return redirect()->route('carrito.mostrar');

        $direccion = json_decode($request->input('direccion'), true);
        $metodo = $request->input('metodo');

        if ($metodo === 'contraentrega') {
            return redirect()->route('paypal.success')->with([
                'direccion' => $direccion,
                'metodo' => 'contraentrega',
                'carrito' => $carrito
            ]);
        }

        // === Iniciar pago con PayPal ===

        // 1. Crear el objeto Payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // 2. Crear los items del carrito
        $items = [];
        $total = 0;
        foreach ($carrito as $producto) {
            $item = new Item();
            $item->setName($producto['nombre'])
                 ->setCurrency('USD')
                 ->setQuantity($producto['cantidad'])
                 ->setSku("SKU_" . uniqid())
                 ->setPrice(number_format($producto['precio'], 2, '.', ''));

            $items[] = $item;

            $total += $producto['precio'] * $producto['cantidad'];
        }

        // 3. Crear lista de items
        $itemList = new ItemList();
        $itemList->setItems($items);

        // 4. Crear el objeto Amount
        $amount = new Amount();
        $amount->setCurrency("USD")
               ->setTotal(number_format($total, 2, '.', ''));

        // 5. Crear la transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription("Pago en BazurtoShop");

        // 6. Configurar URLs de redirección
session([
    'direccion_pago' => $direccion,
    'metodo_pago' => 'paypal',
    'carrito_pago' => $carrito,
]);

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(route('paypal.execute'));
$redirectUrls->setCancelUrl(route('carrito.mostrar'));

        // 7. Crear el pago
        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        // 8. Ejecutar la solicitud a PayPal
        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el pago con PayPal: ' . $e->getMessage());
        }
    }

    public function execute(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        try {
            $payment = Payment::get($paymentId, $this->apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);
            $result = $payment->execute($execution, $this->apiContext);
        } catch (\Exception $e) {
            return redirect()->route('carrito.mostrar')->with('error', 'Pago no aprobado.');
        }

        $carrito = session('carrito', []);
        $carrito = array_values($carrito);

        $direccion = json_decode(urldecode($request->input('direccion')), true);
        $metodo = $request->input('metodo');

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        session()->forget('carrito');

        return view('compra.success', [
             'carrito' => $carrito,
            'direccion' => $direccion,
            'metodo' => $metodo,
            'total' => number_format($total, 2, '.', '')
        ]);
    }

public function success(Request $request)
{
    $orderId = $request->get('orderID');
    $direccion = json_decode($request->get('direccion'), true);
    $carrito = json_decode($request->get('carrito'), true);
    $total = $request->get('total');

    // Vaciar carrito (si lo usas desde sesión)
    session()->forget('carrito');

    return view('paypal.success', compact('orderId', 'direccion', 'carrito', 'total'));
}


}
