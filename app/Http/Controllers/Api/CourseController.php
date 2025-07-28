<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        return Course::all();
    }

    public function courses_list()
    {
        return Course::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'duration'        => 'nullable|string',
            'students_number' => 'nullable|integer',
            'price'           => 'required|numeric',
            'image'           => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $path          = $request->file('image')->store('courses', 'public');
                $data['image'] = $path;
            }

            $course = Course::create($data);

            DB::commit();
            return response()->json($course, 201);
        } catch (\Exception $e) {
            DB::rollback();

            // Optional: delete uploaded file if error after storage
            if (! empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            return response()->json(['error' => 'Failed to create course', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Course $course)
    {
        return $course;
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'           => 'sometimes|required|string|max:255',
            'description'     => 'nullable|string',
            'duration'        => 'nullable|string',
            'students_number' => 'nullable|integer',
            'price'           => 'sometimes|required|numeric',
            'image'           => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }

                $data['image'] = $request->file('image')->store('courses', 'public');
            }

            $course->update($data);

            DB::commit();
            return response()->json($course);
        } catch (\Exception $e) {
            DB::rollBack();

            if (! empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            return response()->json(['error' => 'Failed to update course', 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function custom_update(Request $request, Course $course)
    {


        $data = $request->validate([
            'title'           => 'sometimes|required|string|max:255',
            'description'     => 'nullable|string',
            'duration'        => 'nullable|string',
            'students_number' => 'nullable|integer',
            'price'           => 'sometimes|required|numeric',
            'image'           => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }

                $data['image'] = $request->file('image')->store('courses', 'public');
            }

            $course->update($data);
            DB::commit();
            return response()->json($course);
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }
            return response()->json(['error' => 'Failed to update course', 'message' => $e->getMessage()], 500);
        }
    }
}
