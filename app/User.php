<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    
	protected $table = 'users';
    protected $fillable = ['name','email','password'];
    
    public function register(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->save();
    }
}
