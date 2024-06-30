<?php

namespace App\Http\Controllers;
use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{


    public function index()
    {
        
        $slots = Slot::where('available',1)->get();

     
    }
    
}
