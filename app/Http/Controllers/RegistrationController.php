<?php

namespace App\Http\Controllers;

use App\Enums\Classes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;
use App\Models\Student;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PDF;

class RegistrationController extends Controller
{
 
      public function students_registration(Request $request)
    {

        if ($request->ajax()) {
            
            $classFilter = $request->input('class_filter');
            $query = Student::where('is_registered', 1);
            if ($classFilter) {
                $query->where('class', $classFilter);
            }

            $data = $query->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn() // Automatically adds an index column
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="student-checkbox" value="' . $row->id . '">';
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('M d, Y h:i A');
                })
                ->addColumn('action', function ($row) {
                    // Start the button container with center alignment
                    $btn = '<div class="d-flex justify-content-center align-items-center">';

                    // View button with modal trigger
                    $btn .= '<button class="view btn btn-info btn-sm mr-2" data-id="' . $row->id . '" data-toggle="modal" data-target="#viewStudentModal">';
                    $btn .= '<i class="fas fa-eye"></i>';
                    $btn .= '</button>';

                    // Delete Registration button with a form or a delete request
                    $btn .= '<form action="' .URL::to('students/delete-registration/'.$row->id) . '" method="POST" class="d-inline">';
                    $btn .= csrf_field(); // Include CSRF token for security
                    $btn .= method_field('DELETE'); // Use DELETE method
                    $btn .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this registration?\')">';
                    $btn .= '<i class="fas fa-trash-alt"></i>'; // Trash icon for delete
                    $btn .= '</button>';
                    $btn .= '</form>';

                    $btn .= '</div>'; // Close button container div
                    return $btn;
                })

                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }

        return view('pages.registrations.students-registration');
    }



    public function userRegistration(Request $request)
    {
        try {
            if ($request->has('student_id')) {
                // Admin updating an existing student
                $student = Student::findOrFail($request->student_id);

                $validatedData = $request->validate([
                    'student_name' => 'required|string|max:255',
                    'father_name' => 'required|string|max:255',
                    'phone' => 'required|string|min:8',
                    'dob' => 'required|string|min:8',
                    'address' => 'required|string|min:8',
                    'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Validation for image

                ]);

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('images', 'public');
                    $validatedData['image'] = asset('/storage/' . $imagePath);
                }

                
                $validatedData['is_registered'] = 1;
                $student->update($validatedData);

                return redirect()->route('registration')->with('message', 'Student registered successfully');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', 'Validation failed')->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation failed');
        }
    }


  

    public function getStudentsByClass($classId,$campus)
    {
        $students = Student::where('class', $classId)->where('campus', $campus)->get();
        return response()->json(['students' => $students]);
    }

    public function studentView($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.registrations.student-id', compact('student'));
    }
    
    public function parentView($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.registrations.parent-id', compact('student'));
    }


    public function handleSelectedStudents(Request $request)
    {

        $type = $request->type;
        $selectedIds = $request->input('selected_ids');
        $idsArray = explode(',', $selectedIds);
        $students = Student::whereIn('id', $idsArray)->get();

        return view('pages.registrations.print-view', compact('students', 'type'));
    }



    public function classList(Request $request)
    {
        if ($request->ajax()) {
            // Define the class names array
            $classes = Classes::DATA;

            // Manually create an array to simulate data
            $data = collect($classes);

            return DataTables::of($data) // Convert array to a collection
                ->addIndexColumn() // Automatically adds an index column
                ->addColumn('class_name', function ($row) {
                    return $row['name']; // Access the class name from the array
                })
                ->addColumn('action', function ($row) {
                    // Create the "View" button, passing the class name as a filter
                    return '<a href="'.URL::to('students-registration?class_filter='.$row['name']).'"class="btn btn-info btn-sm">View</a>';
                })
                ->rawColumns(['class_name', 'action']) // Allow raw HTML in the action column
                ->make(true);
        }

        return view('pages.registrations.class-list');
    }


    public function deleteRegistration($id)
    {
        $student = Student::findOrFail($id);

        // dd($id);
        $student->update([
            'is_registered' => 0,
            'father_name' => null,
            'dob' => null,
            'phone' => null,
            'address' => null,
            'image' => null,
        ]);

        return redirect()->back()->with('success', 'Registration deleted successfully.');
    }


}