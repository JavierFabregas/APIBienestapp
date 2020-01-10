<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\application;
use App\restriction;
use App\Helper\Token;

class restrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //var_dump($request->max_time);exit();
        //check application
        $restriction = new restriction();

        $application = application::where('name',$request->name)->first();
        if (isset($application)) {    

            $email = $request->data_token->email;
            $user = User::where('email',$email)->first();

            if (isset($user)) {

                if (is_null($request->max_time)) {

                    if (is_null($request->start_hour_restriction) || is_null($request->finish_hour_restriction)) {

                        return response()->json(["Error" => "Debe de haber alguna restriction"]);

                    }else{     

                        $restriction->new_Restriction($request,$user->id,$application->id);
                        return response()->json(["Success" => "Se ha añadido la restriction"]);

                    }
                }else{

                    $restriction->new_Restriction($request,$user->id,$application->id);
                    return response()->json(["Success" => "Se ha añadido la restriction"]);

                }
            }else{

                return response()->json(["Error" => "El usuario no existe"]);

            }

        }else{
            return response()->json(["Error" => "La aplicacion no existe"]);
        }


        //check user


        //check max_time
        //check start-finish


        //store
        //$restriction->new_Restriction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
