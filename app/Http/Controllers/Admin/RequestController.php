<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableTable;
use App\Models\BookedTable;
use Illuminate\Http\Request;

class RequestController extends Controller
{


    public function getBookings(){
        $pendingBookings = BookedTable::where('status', 'pending')
        ->get();

        $bookedTables = BookedTable::where('status', 'accepted')
        ->get();

        $rejectedBookings = BookedTable::where('status', 'rejected')
        ->get();

        return response()->json([
            'pendingBookings' => $pendingBookings,
            'acceptedBookings' => $bookedTables,
            'rejectedBookings' => $rejectedBookings
        ]);
    }

    public function acceptBooking($id){
        $booking = BookedTable::find($id);

        $avalibleTable_id = $booking->available_table_id;
        $avalibleTable = AvailableTable::find($avalibleTable_id);
        $avalibleTable->status = 'booked';
        $booking->status = 'accepted';

        $booking->save();
        $avalibleTable->save();

        
        return response()->json(['message' => 'Booking accepted successfully']);
    }

    public function rejectBooking($id){
        $booking = BookedTable::find($id);

        $avalibleTable_id = $booking->available_table_id;
        $avalibleTable = AvailableTable::find($avalibleTable_id);
        $avalibleTable->status = 'available';
        $booking->status = 'rejected';

        $booking->save();
        $avalibleTable->save();
        return response()->json(['message' => 'Booking rejected successfully']);
    }
}
