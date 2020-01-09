<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class restriction extends Model
{
    
    protected $table = 'restrictions';
    protected $fillable = ['max_time','start_hour_restriction','finish_hour_restriction','user_id','application_id'];
    
    public function new_Restriction(Request $request)
    {
        $restriction = new User;
        $restriction->day = $request->day;
        $restriction->useTime = $request->useTime;
        $restriction->location = $request->location;
        $restriction->user_id = $request->user_id;
        $restriction->application_id = $request->application_id;
        $restriction->save();
    }
}
