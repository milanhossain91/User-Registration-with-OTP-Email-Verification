<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChooseUs;
use Illuminate\Support\Facades\DB;

class ChooseUsController extends Controller
{
    public function index()
    {
        return ChooseUs::all();
    }

     public function choose_us_list()
    {
        return ChooseUs::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $record = ChooseUs::create($data);
            DB::commit();
            return response()->json($record, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create'], 500);
        }
    }

    public function show(ChooseUs $chooseUs)
    {
        return $chooseUs;
    }

    public function update(Request $request, ChooseUs $chooseUs)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $chooseUs->update($data);
            DB::commit();
            return response()->json($chooseUs);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update'], 500);
        }
    }

    public function destroy(ChooseUs $chooseUs)
    {
        $chooseUs->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function custom_update(Request $request, ChooseUs $chooseUs)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {






            $chooseUs->update($data);
            DB::commit();
            return response()->json($chooseUs);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update'], 500);
        }
    }
}
