<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function count(Request $request)
    {
        $logs = (new Log())->newQuery();
        $logs = $logs->when($request->get("service_names", false),
            function ($q) use ($request) {
                return $q->where("service_names", $request->service_names);
            })->when($request->get("start_date", false),
            function ($q) use ($request) {
                return $q->whereDate("date_at", "=<", $request->start_date);
            })->when($request->get("status_code", false),
            function ($q) use ($request) {
                return $q->where("status_code", $request->status_code);
            })->when($request->get("end_date", false),
            function ($q) use ($request) {
                return $q->where("date_at", "=>", $request->end_date);
            });

        return [
            "count" => $logs->count()
        ];
    }
}
