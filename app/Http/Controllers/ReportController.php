<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('type', 'APPROVER')
                ->select([
                    'id',
                    'first_name',
                    'last_name',
                    'type',
                ])
                ->withCount([
                    'payment_approvals' => function ($query) {
                        $query->where('status', 'APPROVED');
                    }
                ], 'id')
                ->get();

            $payment_approvals_total_count = $users->sum('payment_approvals_count');
            return response()->json([
                'payment_approvals_total_count' => $payment_approvals_total_count,
                'payment_approvals_per_user' => $users->toArray(),
            ]);

        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
