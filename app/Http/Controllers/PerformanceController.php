<?php

namespace App\Http\Controllers;

use App\Enums\Behavior;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Imports\StudentsImport;
use App\Models\Performance;
use App\Models\SchoolSession;
use App\Models\Week;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PDF;

class PerformanceController extends Controller
{
 
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $query = Performance::join('students','students.id','=','peformance_sheet.student_id')
            ->join('week','week.id','=','peformance_sheet.week')
            ->join('schoolsessions','schoolsessions.id','=','week.schoolsession_id');


            if($request->has('student') && $request->student != ''){
                $query->where('peformance_sheet.student_id',$request->student);
            }

            if($request->has('class') && $request->class != ''){
                $query->where('peformance_sheet.class',$request->class);
            }

            if($request->has('week') && $request->week != ''){
                $query->where('week.id',$request->week);
            }

            if($request->has('session') && $request->session != ''){
                $query->where('schoolsessions.id',$request->session);
            }

            if($request->has('start_date') && $request->start_date != ''){
                $query->where('week.from',$request->start_date);
            }

            if($request->has('end_date') && $request->end_date != ''){
                $query->where('week.to',$request->end_date);
            }

            
            $count = $query->count();       
            $data = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('peformance_sheet.id','desc')
            ->select([
                'peformance_sheet.*',
                'week.from',
                'week.to',
                'schoolsessions.title',
                'week.week',
                'students.sid',
                'students.first_name',
                'students.last_name',
            ])
            ->get();


            $response = [];
            foreach ($data as $key => $value) {
                

                $action = '<a href="' . URL::to('/performances/'.$value->id.'/edit').'" class="edit btn btn-primary btn-sm">';
                $action .= '<i class="fas fa-edit"></i>';
                $action .= '</a>';

                $action .= ' <a data-id="'.URL::to('/performances/'.$value->id).'" class="delete_btn btn btn-danger btn-sm">';
                $action .= '<i class="fas fa-trash-alt"></i>';
                $action .= '</a>';


                array_push($response,[
                    $value->id,
                    $value->sid,
                    $value->first_name.' '.$value->last_name,
                    date('Y-m-d',strtotime($value->from)),
                    date('Y-m-d',strtotime($value->to)),
                    $value->class,
                    $value->title,
                    $value->week,
                    $value->total,
                    $action,
                ]);        
            }

            return response()->json([
                "draw" => $request->draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                'data'=> $response,
            ]);
        }

        $data = [
            'students' => Student::all(),
            'sessions' => SchoolSession::all(),
            'weeks' => Week::all(),
        ];

        return view('pages.performances.index',$data);

    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        
        $results = Performance::select(DB::raw("CONCAT(student_id, '-', week) as student_week"))
        ->pluck('student_week')
        ->toArray();

        $data = [
            'students' => Student::all(),
            'sessions' => SchoolSession::all(),
            'weeks' => Week::all(),
            'results' => $results,
        ];
        return view('pages.performances.create',$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "student" => 'required|max:255',
            "class" => 'required|max:255',
            "week" => 'required|max:255',
            "session" => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $old = Performance::where('student_id',$request->student)
        ->where('week',$request->week)
        ->where('class',$request->class)
        ->get();

        if(count($old) > 0){
            return back()
            ->withErrors($validator)
            ->withInput()
            ->with('error','Performance Already Added');
        }



        $p = Performance::create([
            'class' => $request->class,
            'week' => $request->week,
            'student_id' => $request->student,
            'social_behavior' => json_encode([]),
            'personal_habits' => json_encode([]),
        ]);

        return redirect('performances/'.$p->id.'/edit');
        
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $data = [
            'students' => Student::all(),
            'model' => Performance::findOrFail($id),
        ];

        return view('pages.performances.edit',$data);
    }

    public function show($id)
    {
        // $student = Student::findOrFail($id);
        // return response()->json($student);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            "social_behavior" => 'required',
            "personal_habits" => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Performance::where('id',$id)->update([
            'social_behavior' => json_encode($request->social_behavior),
            'personal_habits' => json_encode($request->personal_habits),
            "act_kindness" => $request->act_kindness,
            "notebook" => $request->notebook,
            "total" => $request->total,
        ]);

        return back()->with('success','Record Updated');

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = Performance::findOrFail($id);
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