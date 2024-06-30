<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UseZoom;
use App\Models\Appointment;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class ZoomIntegrationController extends Controller
{
    use UseZoom;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    public function createZoomLink($request)
    {

        $data = $this->create($request);
     
        return $data;
    }
    public function updateZoomLink($id, $data)
    {
        $data = $this->updatezoom($id, $data);
        return $data;
        // $path = 'meetings/' . $id;
        // $url = $this->retrieveZoomUrl();

        // $body = [
        //     'headers' => $this->headers,
        //     'body'    => json_encode([
        //         'topic'      => $data['topic'],
        //         'type'       => self::MEETING_TYPE_SCHEDULE,
        //         'start_time' => $this->toZoomTimeFormat($data['start_time']),
        //         'duration'   => $data['duration'],
        //         'agenda'     => (!empty($data['agenda'])) ? $data['agenda'] : null,
        //         'timezone'     => 'Africa/Cairo',

        //     ]),
        // ];
        // $response =  $this->client->patch($url . $path, $body);

        // return [
        //     'success' => $response->getStatusCode() === 204,
        //     'data'    => json_decode($response->getBody(), true),
        // ];
    }
    public function deleteZoomLink($request)
    {

        $data = $this->delete($request);
        // $meeting = $this->createMeeting($request);
        // $x = [
        //     'join_url' => $meeting->join_url,
        //     'id' => $meeting->id,
        //     'user_id' => $meeting->user_id
        // ];
        // $data['meeting'] = $x;
        // return response()->json($data);
        return $data;
    }


    public function linkZoomAccount(Request $req)
    {
           $response = $this->linkZoom(Auth::Id(), $req->email);
           return back()->with('message', $response['message']);


    }

    public function createMeeting($request,$doctor_id)
    {
        
    $appoint = Appointment::findOrFail($request);
    
    if( $appoint->start_url===null){
    
    
     $data = $this->create($request);
    
     $meeting_start = $data['data']['start_url'];
     $meeting_join = $data['data']['join_url'];
     

    if ($data)
    {
        $appoint->start_url = $meeting_start;
        $appoint->join_url = $meeting_join;
        $appoint->save();
        return redirect($meeting_start); 
    }else{
            return redirect()->back()->with('error','Sorry No Meeting create');
        }
        
    }else{
        return redirect($appoint->start_url);
    }

            

        return redirect()->route('doctor.profile')->with('error','Please create zoom account');
    }

 

    
    /**
     * Zoom Meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function meeting(Request $req)
    {

        return view('zoom.meeting', get_defined_vars());
    }

     /**
     * Zoom ended
     *
     * @return \Illuminate\Http\Response
     */
    public function ended(Request $req)
    {
        return view('zoom.class-end');
    }

}
