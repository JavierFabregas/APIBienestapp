<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\usage;
use App\User;
use App\application;

class usageController extends Controller
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
        // recivir CSV y añadirlo a la base de datos
        /*
            Day -> date (dia de hoy)
            useTime -> Time ((Hora de apertura - Hora de cierre) + useTime anterior)
            location -> string
            user_id (lo sacamos del token)
            application_id (lo sacamos con el nombre de la app)

        */

            $csv = array_map('str_getcsv' ,file('/Applications/MAMP/htdocs/APIBienestapp/storage/app/usage.csv'));
            $countArray = count($csv);

            $email = $request->data_token->email;
            $user = User::where('email',$email)->first();
            
            for ($i=1; $i < $countArray ; $i++) { 

                $openDate = new DateTime ($csv[$i][0]);
                $application = $csv[$i][1];
                $openLocation = $csv[$i][3] . "," . $csv[$i][4];

                $i++;

                $closeDate =  new DateTime ($csv[$i][0]);
                // $timeUsed se guarda en segundos 
                $timeUsed = $closeDate->getTimestamp() - $openDate->getTimestamp();

                $application = application::where('name',$application)->first();

                if (isset($application)) {

                    $newUsage = new usage();
                    $newUsage->register($openDate,$timeUsed,$openLocation,$user->id,$application->id);   
                }               


            }
            return response()->json(["Success" => "Se ha añadido el uso de todas las aplicaciones"]);


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
        $usages = usage::where('user_id',$user->id)->get();


        $idApplicationUsages = array();

        $countUsages = count($usages);
        $totalTime = array();

        foreach ($usages as $key => $usage) {
            if (!(in_array($usage->application_id, $idApplicationUsages))) {
                array_push($idApplicationUsages, $usage->application_id);
                array_push($totalTime, 0);
            }
        }

        for ($i=0; $i < count($idApplicationUsages) ; $i++) {          
            foreach ($usages as $key => $usage) {
                if ($usage->application_id == $idApplicationUsages[$i]) {
                    $totalTime[$i] += $usage->useTime;
                }
            }   
        }
        
        var_dump($totalTime);
        exit();
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
