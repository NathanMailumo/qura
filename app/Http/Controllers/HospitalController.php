<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hospital = Hospital::with('departments')->find(1);
        $departments = $hospital ? $hospital->departments : collect();

        $activeTicket = null;
        $people_ahead = 0;
        $user_waitTime = 0;

        if ($user) {
            $activeTicket = Queue::where('user_id', $user->id)
                ->where('is_active', true)->first();

            if ($activeTicket) {
                $people_ahead = Queue::where('is_active', true)
                    ->where('department', $activeTicket->department)
                    ->where('created_at', '<', $activeTicket->created_at)
                    ->count();

                if ($people_ahead === 0) {
                    $user_waitTime = 0;
                } else {
                    $user_waitTime = $people_ahead * 5;
                }
            }
        }

        $peopleAhead = $people_ahead;
        $userWaitTime = $user_waitTime;

        $departmentCounts = Queue::where('is_active', true)
            ->select('department', DB::raw('count(*) as count'))
            ->groupBy('department')
            ->pluck('count', 'department');


        return view('user.index', compact(
            'hospital',
            'departments',
            'activeTicket',
            'people_ahead',
            'peopleAhead',
            'user_waitTime',
            'userWaitTime',
            'departmentCounts'
        ));
    }
}
