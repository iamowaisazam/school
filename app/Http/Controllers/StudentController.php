<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PDF;

class StudentController extends Controller
{
 
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Student::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function ($row) {

                $editUrl = URL::to('/students/'.$row->id.'/edit');
                $deleteUrl = URL::to('/students/'.$row->id);

                $btn = '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">';
                $btn .= '<i class="fas fa-edit"></i>';
                $btn .= '</a>';

                $btn .= ' <a href="' . $deleteUrl . '" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">';
                $btn .= '<i class="fas fa-trash-alt"></i>';
                $btn .= '</a>';

                $btn .= ' <button class="view btn btn-info btn-sm" data-id="' . $row->id . '" data-toggle="modal" data-target="#viewStudentModal">';
                $btn .= '<i class="fas fa-eye"></i>';
                $btn .= '</button>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('pages.students.index');

    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.students.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sid' => 'required|string|max:255',
            'campus' => 'required|string|max:100',
            'class' => 'required|string|max:100',
            'father_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'student_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'dob' => 'nullable|string',
            'address' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_registered' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public_disk');
            $validatedData['image'] = '/storage/' . $imagePath;
        }

        $validatedData['is_registered'] = $request->input('is_registered') == '1' ? 0 : 1;
        $student = Student::create($validatedData);

        return back()->with('success','Record Created');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.students.edit', compact('student'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sid' => 'required|string|max:255',
            'campus' => 'required|string|max:100',
            'class' => 'required|string|max:100',
            'father_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'student_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'dob' => 'nullable|string',
            'address' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_registered' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Student::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($student->image) {
                $oldImagePath = str_replace('/storage/', '', $student->image);
                Storage::disk('public_disk')->delete($oldImagePath);
            }
            $imagePath = $request->file('image')->store('images', 'public_disk');
            $data['image'] = '/storage/' . $imagePath;
        }

        $data['is_registered'] = $request->input('is_registered') == '1' ? 0 : 1;

        $student->update($data);

        return back()->with('success','Record Updated');

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json(['message' => 'Student deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Student', 'error' => $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);
        try {
            Excel::import(new StudentsImport, $request->file('file'));
            return back()->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import students: ' . $e->getMessage());
        }

    }



}