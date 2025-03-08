<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookedTable;
use Illuminate\Http\Request;

class RequestController extends Controller
{


    public function getbookings(Request $request){
        $user = $request->user();
        $pendingBookings = BookedTable::where('user_id', $user->id)
        ->where('status', 'pending')
        ->get();

        $bookedTables = BookedTable::where('user_id', $user->id)
        ->where('status', 'accepted')
        ->get();

        $rejectedBookings = BookedTable::where('user_id', $user->id)
        ->where('status', 'rejected')
        ->get();

        return response()->json([
            'pendingBookings' => $pendingBookings,
            'acceptedBookings' => $bookedTables,
            'rejectedBookings' => $rejectedBookings
        ]);
    }
}
