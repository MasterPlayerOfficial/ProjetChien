<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PhpMqtt\Client\Facades\MQTT;

use App\Models\Alert;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class AlertController extends Controller
{
    public function addAlert(Request $request)
    {
        try
        {
            $alert = new Alert([
                'idAnimal' => $request->input('idAnimal'),
                'inProgress' => true,
                'dateStart' => Carbon::now()->format('Y-m-d')
            ]);

            $alert->save();
            $mqtt = MQTT::connection();
            $mqtt->publish("alert", "trigger_start", 2, true);
            $mqtt->loop(true, true);

            return response()->json(true);
        }
        catch(QueryException $e)
        {
            return json_encode(['Message' => 'An error has occured: ' . $e->getMessage()], 500);            
        }
    }
}
