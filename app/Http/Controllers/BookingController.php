<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('slot')->get();
        return response()->json($bookings);
    } 

    public function booking(Request $request){
        
       $id= auth()->user()->id;
 $booking=Booking::create([
    'slot_id'=>$request->slot_id,
    'user_id'=>$id,
    'start_date'=>$request->start_date,
    'end_date'=>$request->end_date
]);

return response()->json($booking);
    }

    public function show(){
        $id=auth()->user()->id;
        $bookings = Booking::where('user_id',$id)->get();
        return response()->json($bookings);
    }
    public function destroy($id){
        $user_id=auth()->user()->id;
        $booking = Booking::where('id', $id)->where('user_id', $user_id)->first();
        
        if (!$booking) {
            return response()->json(['message' => 'Booking not found or you do not have permission to delete it'], 404);
        }
    
        // احذف الحجز
        $booking->delete();
    
        // أعد استجابة JSON مع رسالة نجاح
        return response()->json(['message' => 'Booking deleted successfully'], 200);    }
}
