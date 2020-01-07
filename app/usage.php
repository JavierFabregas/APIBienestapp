<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usage extends Model
{
    protected $table = 'usage';
    protected $fillable = ['day','useTime','location'];
    
    public function register(Request $request)
    {
        $usage = new User;
        $usage->day = $request->day;
        $usage->useTime = $request->useTime;
        $usage->location = $request->location;
        $usage->save();
    }
    /*
    Public function userExists($id){
        $usages = self::where('email',$id)->get();
        
        foreach ($usages as $key => $value) {
            if($value->email == $id){
                return true;
            }
        }
        return false;
    }
    */
}
