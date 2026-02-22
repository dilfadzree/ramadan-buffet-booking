<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetCapacityRequest;
use App\Services\CapacityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    public function __construct(
        private CapacityService $capacityService
    ) {}

    /**
     * Display capacity management page
     */
    public function index(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        $capacities = $this->capacityService->getMonthCapacities($year, $month);

        return view('staff.capacity.index', compact('capacities', 'year', 'month'));
    }

    /**
     * Set capacity for a date
     */
    public function store(SetCapacityRequest $request)
    {
        $data = $request->validated();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Bulk set
            $count = $this->capacityService->setCapacityForDateRange(
                $data['start_date'],
                $data['end_date'],
                $data['max_capacity']
            );

            $message = "Capacity set to {$data['max_capacity']} for {$count} days.";
        } else {
            // Single date
            $this->capacityService->setCapacity($data['date'], $data['max_capacity']);
            $message = "Capacity for {$data['date']} set to {$data['max_capacity']}.";
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    /**
     * Get capacity data (AJAX)
     */
    public function getCapacities(Request $request): JsonResponse
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        return response()->json(
            $this->capacityService->getMonthCapacities($year, $month)
        );
    }
}
