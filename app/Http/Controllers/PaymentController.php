<?php

namespace App\Http\Controllers;

use App\Dto\Payments\PayDto;
use App\Dto\Payments\PaymentListRequestDto;
use App\Dto\Payments\PaymentStoreDto;
use App\Helpers\DateHelper;
use App\Http\Requests\Pay\PayStoreRequest;
use App\Http\Requests\Payment\PaymentListRequest;
use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private PaymentService $paymentService;
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentService $paymentService, PaymentRepository $paymentRepository)
    {
        $this->paymentService = $paymentService;
        $this->paymentRepository = $paymentRepository;
    }

    public function index(PaymentListRequest $request)
    {
        [$amount, $uuid, $status] = $request->validate();

        $errors = $request->getErrors();

        $payments = $this->paymentRepository->list(new PaymentListRequestDto(
                Auth::id(),
                $amount,
                $uuid,
                $status,
            )
        );

        $statuses = Payment::getStatuses();

        return view('payments.index', [
            'payments' => $payments,
            'errors' => $errors,
            'statuses' => $statuses,
            'filters' => [
                'amount' => $amount,
                'uuid' => $uuid,
                'status' => $status
            ]
        ]);
    }

    public function show($id)
    {
        $payment = $this->paymentRepository->show(Auth::id(), $id);
        return view('payments.show', ['payment' => $payment]);
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(PaymentStoreRequest $request): RedirectResponse
    {
        $this->paymentRepository->store(new PaymentStoreDto(
            Auth::id(),
            $request->get('amount'),
            $request->get('phone'),
            $request->get('email')
        ));

        return redirect()->route('payments.index');
    }

    public function payShow($uuid)
    {
        $payment = $this->paymentRepository->getPaymentByUuid($uuid);

        if (!$payment || $this->paymentService->checkPaid($payment)) {
            abort(404);
        }

        $months = DateHelper::$months;

        return view('payments.pay.show', [
            'payment' => $payment,
            'months' => $months
        ]);
    }

    public function pay($uuid, PayStoreRequest $payStoreRequest)
    {
        $payment = $this->paymentRepository->getPaymentByUuid($uuid);

        if (!$payment || $this->paymentService->checkPaid($payment)) {
            abort(404);
        }

        $isPaid = $this->paymentService->pay(new PayDto(
            $payment,
            $payStoreRequest->get('cardNumber'),
            $payStoreRequest->get('cardMonth'),
            $payStoreRequest->get('cardYear'),
        ));

        return view('payments.pay.finish', [
            'isPaid' => $isPaid,
            'payment' => $payment
        ]);
    }
}
