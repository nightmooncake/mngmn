<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Response;

class ActivityLogController extends Controller
{

    public function index()
    {
        $activities = Activity::with('causer', 'subject')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('activity-log.index', compact('activities'));
    }

    public function export()
    {
        $filename = 'activity-logs-' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'User',
                'Action',
                'Model',
                'Changes',
                'IP Address',
                'User Agent',
                'Created At'
            ]);

            $logs = Activity::with('causer')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->causer?->name ?? 'System',
                    $log->description,
                    $log->subject_type ?? '-',
                    json_encode($log->properties->toArray(), JSON_UNESCAPED_UNICODE),
                    $log->ip_address ?? '-',
                    $log->user_agent ?? '-',
                    $log->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
