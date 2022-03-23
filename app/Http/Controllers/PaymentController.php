<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentApprovalRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\PaymentApproval;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function read()
    {
        try {
            $payments = Payment::where('user_id', auth()->user()->id)
                ->get();
            if ($payments->count()) {
                return response()->json(PaymentResource::collection($payments));
            } else {
                return response()->noContent();
            }
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(PaymentRequest $paymentRequest)
    {
        try {
            $validated = $paymentRequest->validated();
            $payment = new Payment($validated);
            auth()->user()->payments()->save($payment);

            return response()->json([
                'message' => 'Payment successfully created.'
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(PaymentRequest $paymentRequest, int $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            if ($payment->user_id === auth()->user()->id) {
                $validated = $paymentRequest->validated();
                $payment->fill($validated);
                if ($payment->isDirty()) {
                    $payment->update();
                }
                return response()->json([
                    'message' => 'Payment successfully updated.'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "message" => "You cannot update this payment."
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                "message" => "Payment not found."
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            if ($payment->user_id === auth()->user()->id) {
                $payment->delete();
                return response()->json([
                    'message' => 'Payment successfully deleted.'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "message" => "You cannot delete this payment."
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                "message" => "Payment not found."
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function approval(PaymentApprovalRequest $paymentApprovalRequest, int $id)
    {
        try {
            $payment = Payment::with('payment_approval')->findOrFail($id);
            if($payment->payment_approval === null){
                $validated = array_merge($paymentApprovalRequest->validated(), [
                    'user_id' => auth()->user()->id,
                    'payment_type' => 'payment',
                ]);
                $paymentApproval = new PaymentApproval($validated);
                $payment->payment_approval()->save($paymentApproval);

                return response()->json([
                    'message' => 'Payment successfully approved.'
                ], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'message' => 'Payment already approved.'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                "message" => "Payment not found."
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
