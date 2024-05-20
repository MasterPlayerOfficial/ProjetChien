<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

use App\Models\Animal;
use App\Models\Alert;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;


class AnimalController extends Controller
{
    public function checkString(String $str)
    {
        $pattern = "/[0-9]/";
        $result = preg_match($pattern, $str);
        Log::debug($result);
        return $result;
    }

    public function uploadImage(String $imageData)
    {
        try
        {
            Log::debug($imageData);
            $imageExtracted = json_decode($imageData);
            $nameOfImage = 'image_' . time() . '.png';
            file_put_contents(public_path('img/' . $nameOfImage), $imageExtracted);
        }
        catch (\Exception $e)
        {
            Log::debug($e);
            return response()->json("Something went wrong");
        }
    }

    public function addAnimal(Request $request)
    {
        Log::debug($request->getRequestUri());
        try
        {
            $animal = new Animal([
                'name' => $request->input('name'),
                'birth' => $request->input('birth'),
                'race' => $request->input('race'),
                'color' => $request->input('color'),
                'lost' => $request->boolean('lost'),
                'picture' => $request->input('picture')
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

            $animal->lost = 0;

            $trueFilePath = null;
            if($animal->picture != null)
            {
                $trueFilePath = self::uploadImage($animal->picture);
            }
            $animal->picture = $trueFilePath;

            $animal->save();
            return response()->json(true);
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
        Log::debug("Test");
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
        Log::debug($request->getRequestUri());
        try
        {
            $animal = Animal::where('id', $id)->first();
            $filePath = null;

            if($request->picture != null)
            {
                $filepath = self::uploadImage($request->picture);
            }

            $animal->update([
                'name' => $request->name,
                'birth' => Carbon::parse($request->birth)->format('Y-m-d'),
                'race' => $request->race,
                'color' => $request->color,
                'lost' => $request->lost,
                'picture' => $filePath
            ]);

            return json_encode(['message' => 'Animal updated successfully', 'data' => $animal], 200);
        }
        catch(QueryException $e)
        {
            Log::debug($e->getMessage());
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
