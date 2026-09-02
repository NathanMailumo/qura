<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Department;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    /**
     * Display the live queue tracking page.
     */
    public function showQueuePage()
    {
        $user = Auth::user();
        $activeTicket = null;
        $department = null;
        $peopleAhead = 0;
        $userWaitTime = 0;
        $hospital = Hospital::first();
        $departments = Department::all();

        if ($user) {
            $activeTicket = Queue::where('user_id', $user->id)
                ->where('is_active', true)
                ->latest()
                ->first();

            if ($activeTicket) {
                $department = Department::where('name', $activeTicket->department)->first();

                $peopleAhead = Queue::where('is_active', true)
                    ->where('department', $activeTicket->department)
                    ->where('created_at', '<', $activeTicket->created_at)
                    ->count();

                // Estimate 8 mins per patient ahead, or minimum 3 mins
                $userWaitTime = $peopleAhead === 0 ? 3 : ($peopleAhead * 8);
            }
        }

        return view('user.queue', compact(
            'activeTicket',
            'department',
            'hospital',
            'peopleAhead',
            'userWaitTime',
            'departments'
        ));
    }

    /**
     * User enters a department queue.
     */
    public function joinQueue(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please sign in to join a queue.');
        }

        $request->validate([
            'department' => 'required|string',
        ]);

        // Check if user already holds an active ticket
        $existingTicket = Queue::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        if ($existingTicket) {
            return redirect()->route('queue.show')->with('error', "You already hold an active ticket (#{$existingTicket->ticket_number}) for {$existingTicket->department}.");
        }

        // Generate next ticket number for this department today
        $maxTicket = Queue::where('department', $request->department)
            ->whereDate('created_at', today())
            ->max('ticket_number');

        $ticketNumber = $maxTicket ? $maxTicket + 1 : 101;

        $ticket = Queue::create([
            'user_id' => $user->id,
            'department' => $request->department,
            'ticket_number' => $ticketNumber,
            'status' => 'waiting',
            'is_active' => true,
        ]);

        return redirect()->route('queue.show')->with('success', "Ticket #{$ticketNumber} confirmed! You have joined the {$request->department} queue.");
    }

    /**
     * User leaves/forfeits their queue position.
     */
    public function leaveQueue(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            Queue::where('user_id', $user->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'status' => 'cancelled'
                ]);
        }

        return redirect()->route('index')->with('success', 'You have successfully left the queue.');
    }
}
