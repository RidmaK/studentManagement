<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('guardian', 'courses')->get();
        $guardians = Guardian::all();
        $courses = Course::all();
        return view('student.index', compact('students', 'guardians', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'guardian_id' => 'required|exists:guardians,id',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ]);

        // Create a new student
        $student = Student::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'guardian_id' => $validated['guardian_id'],
        ]);
        // Attach the selected courses to the student
        $student->courses()->attach($validated['courses']);

        // Redirect back with a success message
        return redirect()->route('student.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // Load the student with courses and guardian
        $student->load('courses', 'guardian');

        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        // Load the student with their courses and guardian
        $student->load('courses', 'guardian');

        // Get all courses and guardians for the dropdown
        $courses = Course::all();
        $guardians = Guardian::all();

        // Format the data for the JSON response
        $response = [
            'student' => $student,
            'courses' => $courses,
            'guardians' => $guardians
        ];

        // Return JSON response
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id,
            'guardian_id' => 'required|exists:guardians,id',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ]);

        // Update the student
        $student->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'guardian_id' => $validated['guardian_id'],
        ]);

        // Sync the selected courses with the student
        $student->courses()->sync($validated['courses']);

        // Redirect back with a success message
        return redirect()->route('student.index')->with('success', 'Student updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Detach the student from courses
        $student->courses()->detach();

        // Delete the student
        $student->delete();

        // Redirect back with a success message
        return redirect()->route('student.index')->with('success', 'Student deleted successfully.');
    }
}
