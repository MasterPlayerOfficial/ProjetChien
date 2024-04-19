<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Animal;
use App\Models\Alert;

use Carbon\Carbon;

class AnimalController extends Controller
{
    public function checkString(String $str)
    {
        $pattern = "/[0-9]/";
        $result = preg_match($pattern, $str);
        if($result = 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function addAnimal(Request $request)
    {
        try
        {
            $animal = new Animal([
                'name' => $request->input('name'),
                'birth' => $request->input('birth'),
                'race' => $request->input('race'),
                'color' => $request->input('color'),
                'lost' => $request->input('lost')
            ]);

            if($animal->name != null)
            {
                $check = checkString($animal->name);
                if ($check == true) 
                {
                    throw new InvalidArgumentException("A number has been found found within the letters");
                }
            }

            if($animal->birth != null)
            {
                $animal->birth = Carbon::parse($animal->birth)->format('Y-m-d');
            }

            if($animal->race != null)
            {
                $check = checkString($animal->race);
                if ($check == true) 
                {
                    throw new InvalidArgumentException("A number has been found found within the letters");
                }
            }

            if($animal->color != null)
            {
                $check = checkString($animal->color);
                if ($check == true) 
                {
                    throw new InvalidArgumentException("A number has been found found within the letters");
                }
            }

            if($animal->lost = true)
            {
                $animal->lost = 1;
            }
            else
            {
                $animal->lost = 0;
            }

            $animal->save();
            return response()->json($animal->idAnimal);
        }
        catch(QueryException $e)
        {
            return response()->json(['message' => 'Failed to add animal to database: ' . $e->getMessage()], 500);
        }
        catch(InvalidArgumentException $e)
        {
            return response()->json(['message' => 'An error has occured: ' . $e->getMessage()], 500);
        }
    }
}
