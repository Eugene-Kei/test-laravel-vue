<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $tasksQuery = Task::query()
            ->select([
                'users.name',
                DB::raw('ROUND(AVG(price), 2) avg_price'),
                DB::raw('MAX(price) max_price'),
                DB::raw('MIN(price) min_price')])
            ->join('users', 'tasks.executor_id', '=', 'users.id')
            ->where('status', Task::STATUS_COMPLETED)
            ->groupBy('executor_id')
        ;

        return BaseResource::collection($tasksQuery->get());
    }
}
