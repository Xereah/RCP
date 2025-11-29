<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkSessionResource;
use App\Models\WorkSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class WorkSessionController extends Controller
{
    /**
     * Pobiera listę obecności pracowników dla danego dnia.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function getByDate(Request $request): AnonymousResourceCollection|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'personel_id' => 'sometimes|integer|exists:personel,id',
            'status_id' => 'sometimes|integer|exists:work_statuses,id',
        ], [
            'date.required' => 'Data jest wymagana',
            'date.date_format' => 'Data musi być w formacie YYYY-MM-DD',
            'personel_id.integer' => 'ID pracownika musi być liczbą całkowitą',
            'personel_id.exists' => 'Nie znaleziono pracownika o podanym ID',
            'status_id.integer' => 'ID statusu musi być liczbą całkowitą',
            'status_id.exists' => 'Nie znaleziono statusu o podanym ID',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Błąd walidacji',
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = WorkSession::with(['personel.position', 'personel.workPlace', 'workStatus'])
            ->where('work_date', $request->input('date'));

        // Opcjonalne filtrowanie po pracowniku
        if ($request->has('personel_id')) {
            $query->where('personel_id', $request->input('personel_id'));
        }

        // Opcjonalne filtrowanie po statusie
        if ($request->has('status_id')) {
            $query->where('status_id', $request->input('status_id'));
        }

        $workSessions = $query->orderBy('start_time')->get();

        return WorkSessionResource::collection($workSessions);
    }

    /**
     * Pobiera szczegóły pojedynczej sesji pracy.
     *
     * @param WorkSession $workSession
     * @return WorkSessionResource
     */
    public function show(WorkSession $workSession): WorkSessionResource
    {
        $workSession->load(['personel.position', 'personel.workPlace', 'workStatus']);
        
        return new WorkSessionResource($workSession);
    }

    /**
     * Pobiera obecności dla zakresu dat.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function getByDateRange(Request $request): AnonymousResourceCollection|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d|after_or_equal:date_from',
            'personel_id' => 'sometimes|integer|exists:personel,id',
            'status_id' => 'sometimes|integer|exists:work_statuses,id',
        ], [
            'date_from.required' => 'Data początkowa jest wymagana',
            'date_from.date_format' => 'Data początkowa musi być w formacie YYYY-MM-DD',
            'date_to.required' => 'Data końcowa jest wymagana',
            'date_to.date_format' => 'Data końcowa musi być w formacie YYYY-MM-DD',
            'date_to.after_or_equal' => 'Data końcowa musi być późniejsza lub równa dacie początkowej',
            'personel_id.integer' => 'ID pracownika musi być liczbą całkowitą',
            'personel_id.exists' => 'Nie znaleziono pracownika o podanym ID',
            'status_id.integer' => 'ID statusu musi być liczbą całkowitą',
            'status_id.exists' => 'Nie znaleziono statusu o podanym ID',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Błąd walidacji',
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = WorkSession::with(['personel.position', 'personel.workPlace', 'workStatus'])
            ->whereBetween('work_date', [
                $request->input('date_from'),
                $request->input('date_to'),
            ]);

        // Opcjonalne filtrowanie po pracowniku
        if ($request->has('personel_id')) {
            $query->where('personel_id', $request->input('personel_id'));
        }

        // Opcjonalne filtrowanie po statusie
        if ($request->has('status_id')) {
            $query->where('status_id', $request->input('status_id'));
        }

        $workSessions = $query->orderBy('work_date')->orderBy('start_time')->get();

        return WorkSessionResource::collection($workSessions);
    }

    /**
     * Zwraca statystyki obecności dla danego dnia.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getStatistics(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
        ], [
            'date.required' => 'Data jest wymagana',
            'date.date_format' => 'Data musi być w formacie YYYY-MM-DD',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Błąd walidacji',
                'errors' => $validator->errors(),
            ], 422);
        }

        $date = $request->input('date');
        
        $workSessions = WorkSession::where('work_date', $date)->get();
        
        $totalEmployees = $workSessions->count();
        $totalWorkMinutes = $workSessions->sum(fn($session) => $session->getAdjustedDuration());
        $employeesWithOvertime = $workSessions->filter(fn($session) => $session->has_overtime)->count();
        $incompleteShifts = $workSessions->filter(fn($session) => $session->incomplete_shift_warning !== null)->count();

        return response()->json([
            'date' => $date,
            'statistics' => [
                'total_employees' => $totalEmployees,
                'total_work_hours' => round($totalWorkMinutes / 60, 2),
                'total_work_minutes' => $totalWorkMinutes,
                'employees_with_overtime' => $employeesWithOvertime,
                'incomplete_shifts' => $incompleteShifts,
                'average_work_hours_per_employee' => $totalEmployees > 0 
                    ? round($totalWorkMinutes / 60 / $totalEmployees, 2) 
                    : 0,
            ],
        ]);
    }
}

