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

        $restriction = new restriction();

        $application = application::where('name',$request->name)->first();
        if (isset($application)) {    

            $email = $request->data_token->email;
            $user = User::where('email',$email)->first();

            if (isset($user)) {

                if (is_null($request->max_time)) {

                    if (is_null($request->start_hour_restriction) || is_null($request->finish_hour_restriction)) {

                        return response()->json(["Error" => "Debe de haber alguna restriction"],400);

                    }else{     

                        $restriction->new_Restriction($request,$user->id,$application->id);
                        return response()->json(["Success" => "Se ha añadido la restriction"],200);

                    }
                }else{

                    $restriction->new_Restriction($request,$user->id,$application->id);
                    return response()->json(["Success" => "Se ha añadido la restriction"],200);
                }

            }else{

                return response()->json(["Error" => "El usuario no existe"],400);
            }

        }else{
            return response()->json(["Error" => "La aplicacion no existe"],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $email = $request->data_token->email;
        $user = User::where('email',$email)->first();


        $restrictions = restriction::where('user_id',$user->id)->get();

        if (isset($restrictions)) {
            
            return response()->json(["Success" => $restrictions]);   

        }else{
          
            return response()->json(["Error" => "Debe de haber alguna restriction"]);    

        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $restriction = restriction::where('id',$request->id)->first();
         if (isset($restriction)) {

            if (is_null($request->max_time)) {

                if (is_null($request->start_hour_restriction) || is_null($request->finish_hour_restriction)) {

                    return response()->json(["Error" => "Debe de haber alguna restriction"]);

                }else{     

                    $restriction->start_hour_restriction = $request->start_hour_restriction;
                    $restriction->finish_hour_restriction = $request->finish_hour_restriction;
                    $restriction->update();
                    return response()->json(["Success" => "Se ha modificado la restriction"]);
                }
            }else{
                
                $restriction->max_time = $request->max_time;
                $restriction->update();
                return response()->json(["Success" => "Se ha modificado la restriction"]);
            }
        
                return response()->json(["Success" => "Se ha modificado la restriccion."]);
        }else{
            return response()->json(["Error" => "La restriccion no existe"]);
        } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $restriction = restriction::where('id',$request->id)->first();

        if (isset($restriction)) {
            $restriction->delete();
            return response()->json(["Success" => 'Se ha eliminado la restriccion']);   

        }else{
          
            return response()->json(["Error" => "La restriction no existe"]);    

        }
    }
}
