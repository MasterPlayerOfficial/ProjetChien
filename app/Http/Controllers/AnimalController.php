<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

use App\Models\Animal;
use App\Models\Alert;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AnimalController extends Controller
{
    public function checkString(String $str)
    {
        $pattern = "/[0-9]/";
        $result = preg_match($pattern, $str);
        Log::debug($result);
        return $result;
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
                'lost' => $request->boolean('lost')
            ]);

            if($animal->name != null)
            {
                $check = self::checkString($animal->name);
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
                $check = self::checkString($animal->race);
                if ($check == true) 
                {
                    throw new InvalidArgumentException("A number has been found found within the letters");
                }
            }

            if($animal->color != null)
            {
                $check = self::checkString($animal->color);
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

            Log::debug($animal);

            $animal->save();
            return json_encode(['message' => 'Animal successfully added to database'], 200);
        }
        catch(QueryException $e)
        {
            return json_encode(['message' => 'Failed to add animal to database: ' . $e->getMessage()], 500);
        }
        catch(InvalidArgumentException $e)
        {
            return json_encode(['message' => 'An error has occured: ' . $e->getMessage()], 500);
        }
    }

    public function getAnimal($id)
    {
        try
        {
            $animal = Animal::findOrFail($id);
            
            if ($animal->lost == 1)
            {
                $animal->lost = true;
            }
            else
            {
                $animal->lost = false;
            }

            return $animal;
        }
        catch (\Exception $e)
        {
            return json_encode(['Message' => 'Animal not found'], 404);
        }
    }

    public function getAllAnimals()
    {
        $animals = Animal::all();

        foreach($animals as $animal)
        {
            if($animal->lost == 1)
            {
                $animal->lost = true;
            }
            else
            {
                $animal->lost = false;
            }
        }

        return json_encode($animals);
    }

    public function updateAnimal(Request $request, $id)
    {
        try
        {
            $animal = Animal::where('id', $id)->get();
            $newFields = $request->only(['name', 'birth', 'race', 'color', 'lost']);

            foreach($newFields as $field => $value)
            {
                if(!empty($value))
                {
                    $animal->$field = $value;
                }
            }

            $animal->save();

            return json_encode(['message' => 'Animal updated successfully', 'data' => $animal], 200);
        }
        catch(QueryException $e)
        {
            return json_encode(['message' => 'Failed to update animal in database: ' . $e->getMessage()], 500);
        }
    }

    public function deleteAnimal($id)
    {
        try
        {
            $animal = Animal::findOrFail($id);
            $alerts = Alert::where('idAnimal',$animal->$id)->get();

            if ($alerts != null)
            {
                foreach ($alerts as $alert)
                {
                    $alert->delete();
                }
            }

            $animal->delete();
            return json_encode(true);
        }
        catch(QueryException $e)
        {
            return json_encode(['message' => 'Failed to delete animal in database: ' . $e->getMessage()], 500);
        }
    }
}
