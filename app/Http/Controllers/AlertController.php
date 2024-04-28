<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Alert;

use Carbon\Carbon;

class AlertController extends Controller
{
    public function addAlert(Request $request)
    {
        try
        {
            $alert = new Alert([
                'idAnimal' => $request->input('idAnimal'),
                'inProgress' => $request->boolean('inProgress'),
                'dateStart' => Carbon::now()->format('Y-m-d'),
                'dateEnd' => $request->input('dateEnd')
            ]);

            $alert->save();

            return response()->json(true);
        }
        catch(QueryException $e)
        {
            return response()->json(['Message' => 'An error has occured: ' . $e->getMessage()], 500);            
        }
    }

    public function getAlert($idAlert)
    {
        try
        {
            $alert = Alert::findOrFail($idAlert);
            return $alert;
        }
        catch (\Exception $e)
        {
            return response()->json(['Message' => 'Alert not found'], 404);
        }
    }
}
