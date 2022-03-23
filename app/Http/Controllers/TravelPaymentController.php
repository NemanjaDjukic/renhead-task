<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentApprovalRequest;
use App\Http\Requests\TravelPaymentRequest;
use App\Http\Resources\TravelPaymentResource;
use App\Models\PaymentApproval;
use Exception;
use App\Models\TravelPayment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class TravelPaymentController extends Controller
{
    public function read()
    {
        try {
            $payments = TravelPayment::where('user_id', auth()->user()->id)
                ->get();
            if ($payments->count()) {
                return response()->json(TravelPaymentResource::collection($payments));
            } else {
                return response()->noContent();
            }
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(TravelPaymentRequest $travelPaymentRequest)
    {
        try {
            $validated = $travelPaymentRequest->validated();
            $travelPayment = new TravelPayment($validated);
            auth()->user()->payments()->save($travelPayment);

            return response()->json([
                'message' => 'Travel payment successfully created.'
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(TravelPaymentRequest $travelPaymentRequest, int $id)
    {
        try {
            $travelPayment = TravelPayment::findOrFail($id);
            if ($travelPayment->user_id === auth()->user()->id) {
                $validated = $travelPaymentRequest->validated();
                $travelPayment->fill($validated);
                if ($travelPayment->isDirty()) {
                    $travelPayment->update();
                }
                return response()->json([
                    'message' => 'Travel payment successfully updated.'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "message" => "You cannot update this travel payment."
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                "message" => "Travel payment not found."
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
            $payment = TravelPayment::findOrFail($id);
            if ($payment->user_id === auth()->user()->id) {
                $payment->delete();
                return response()->json([
                    'message' => 'Travel payment successfully deleted.'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "message" => "You cannot delete this travel payment."
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                "message" => "Travel payment not found."
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
            $travelPayment = TravelPayment::with('payment_approval')->findOrFail($id);
            if($travelPayment->payment_approval === null){
                $validated = array_merge($paymentApprovalRequest->validated(), [
                    'user_id' => auth()->user()->id,
                    'payment_type' => 'travel_payment',
                ]);
                $paymentApproval = new PaymentApproval($validated);
                $travelPayment->payment_approval()->save($paymentApproval);

                return response()->json([
                    'message' => 'Travel payment successfully approved.'
                ], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'message' => 'Travel payment already approved.'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                "message" => "Travel payment not found."
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
