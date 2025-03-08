<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{


    public function getAvailableTables(Request $request)
{
    $validation = Validator::make($request->all(), [
        'resturant_id' => 'required|exists:resturants,id',
        'date' => 'required|date',
        'time' => 'required',
    ]);

    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors()], 422);
    }


    $availableTables = DB::table('available_tables')
        ->where('status', 'available')
        ->where('resturant_id', $request->resturant_id)
        ->where('date', $request->date)
        ->whereTime('time_from', '<=', $request->time)
        ->whereTime('time_to', '>=', $request->time)
        ->get();

    if ($availableTables->isEmpty()) {
        return response()->json(['message' => 'No available tables for the given time'], 401);
    }

    $tables = DB::table('tables')
        ->whereIn('id', $availableTables->pluck('table_id'))
        ->get();


    $data = $tables->map(function ($table) use ($availableTables) {
        $availableTable = $availableTables->firstWhere('table_id', $table->id);
        return [
            'id' => $table->id,
            'resturant_id' => $table->resturant_id,
            'table_number' => $table->number,
            'time_from' => $availableTable->time_from,
            'time_to' => $availableTable->time_to,
            'status' => $table->status,
        ];
    });

    return response()->json(['available_tables' => $data], 200);
}


public function bookTable(Request $request)
{
    $validation = Validator::make($request->all(), [
        'resturant_id' => 'required|exists:resturants,id',
        'table_id' => 'required|exists:tables,id',
        'date' => 'required|date',
        'time' => 'required',
        'guests' => 'required|integer|min:1',
    ]);

    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors()], 422);
    }

    $availableTable = DB::table('available_tables')
        ->where('resturant_id', $request->resturant_id)
        ->where('table_id', $request->table_id)
        ->where('date', $request->date)
        ->whereTime('time_from', '<=', $request->time)
        ->whereTime('time_to', '>=', $request->time)
        ->where('status', 'available')
        ->first();

    if (!$availableTable) {
        return response()->json(['message' => 'Table is not available for booking'], 404);
    }

    DB::transaction(function () use ($request, $availableTable) {
        DB::table('booked_tables')->insert([
            'table_id' => $request->table_id,
            'user_id' => $request->user()->id,
            'date' => $request->date,
            'time' => $request->time,
            'guests' => $request->guests,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('available_tables')
            ->where('id', $availableTable->id)
            ->update([
                'status' => 'requested',
            ]);

    });

    return response()->json(['message' => 'Book request sent Successfully , wait for approval'], 200);
}

}
