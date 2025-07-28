<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function index()
    {
        return Training::all();
    }

    public function trainings_list()
    {
        return Training::all();
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'nullable|integer',
            'batch_size'  => 'nullable|integer',
            'certificate' => 'nullable|string',
            'image'       => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('trainings', 'public');
            }

            $training = Training::create($data);

            DB::commit();

            return response()->json($training, 201);
        } catch (\Exception $e) {

            DB::rollback();

            if (! empty($data['image']) && Storage::disk('public')->exists($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            return response()->json(['error' => 'Failed to create training', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Training $training)
    {
        return $training;
    }

    public function update(Request $request, Training $training)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'nullable|integer',
            'batch_size'  => 'nullable|integer',
            'certificate' => 'nullable|string',
            'image'       => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($training->image && Storage::disk('public')->exists($training->image)) {
                    Storage::disk('public')->delete($training->image);
                }

                $data['image'] = $request->file('image')->store('trainings', 'public');
            }

            $training->update($data);
            DB::commit();
            return response()->json($training);
        } catch (\Exception $e) {
            DB::rollback();
            if (! empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }
            return response()->json(['error' => 'Failed to update training'], 500);
        }
    }

    public function destroy(Training $training)
    {
        if ($training->image) {
            Storage::disk('public')->delete($training->image);
        }

        $training->delete();
        return response()->json(['message' => 'Training deleted']);
    }

    public function custom_update(Request $request, Training $training)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'nullable|integer',
            'batch_size'  => 'nullable|integer',
            'certificate' => 'nullable|string',
            'image'       => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($training->image && Storage::disk('public')->exists($training->image)) {
                    Storage::disk('public')->delete($training->image);
                }

                $data['image'] = $request->file('image')->store('trainings', 'public');
            }

            $training->update($data);
            DB::commit();
            return response()->json($training);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update training'], 500);
        }
    }
}
