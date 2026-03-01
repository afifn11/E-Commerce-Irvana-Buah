<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {}

    public function index(): View
    {
        $dashboardData = $this->dashboardService->getStatistics();

        return view('dashboard', $dashboardData);
    }

    public function refreshStats(): JsonResponse
    {
        $data = $this->dashboardService->refreshStatistics();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getDataByDateRange(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $data = $this->dashboardService->getStatsByDateRange(
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay(),
        );

        return response()->json(['success' => true, 'data' => $data]);
    }
}
