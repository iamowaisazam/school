<?php

namespace App\Http\Controllers;

use App\Enums\Behavior;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Imports\StudentsImport;
use App\Models\Performance;
use Illuminate\Support\Facades\Crypt;
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

            $query = Performance::join('students','students.id','=','peformance_sheet.student_id');

     

            if($request->has('student') && $request->student != ''){
                $query->where('peformance_sheet.student_id',$request->student);
            }

            if($request->has('week_number') && $request->week_number != ''){
                $query->where('peformance_sheet.week',$request->week_number);
            }

            if($request->has('start_date') && $request->start_date != ''){
                $query->where('peformance_sheet.from',$request->start_date);
            }

            if($request->has('end_date') && $request->end_date != ''){
                $query->where('peformance_sheet.to',$request->end_date);
            }



            // $search = $request->get('search');
            // if($search != ""){
            //    $query = $query->where(function ($s) use($search) {
                //    $s->where('week','like','%'.$search.'%');
                //    ->orwhere('customer_email','like','%'.$search.'%')
                //    ->orwhere('company_name','like','%'.$search.'%')
                //    ->orwhere('customer_phone','like','%'.$search.'%');
            //    });
            // }
            
            $count = $query->count();       
            $data = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('id','desc')
            ->select([
                'peformance_sheet.*',
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
                    $value->week,
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
        ];

        return view('pages.performances.index',$data);

    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'students' => Student::all(),
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
            "from_date" => 'required|max:255',
            "end_date" => 'required|max:255',
            "class" => 'required|max:255',
            "week_number" => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $social_behavior = [];
        $personal_habits = [];

        foreach (Behavior::DATA['social_behavior'] as $key => $value) {
            $social_behavior[$key]['name'] = $value['name'];
            $social_behavior[$key]['mon'] = 0;
            $social_behavior[$key]['tue'] = 0;
            $social_behavior[$key]['wed'] = 0;
            $social_behavior[$key]['thu'] = 0;
            $social_behavior[$key]['fri'] = 0;
            $social_behavior[$key]['sat'] = 0;
            $social_behavior[$key]['sun'] = 0;
        }

        foreach (Behavior::DATA['personal_habits'] as $key => $value) {
            $personal_habits[$key]['name'] = $value['name'];
            $personal_habits[$key]['mon'] = 1;
            $personal_habits[$key]['tue'] = 2;
            $personal_habits[$key]['wed'] = 3;
            $personal_habits[$key]['thu'] = 4;
            $personal_habits[$key]['fri'] = 5;
            $personal_habits[$key]['sat'] = 5;
            $personal_habits[$key]['sun'] = 6;
        }

        // dd($personal_habits);






        $p = Performance::create([
            'student_id' => $request->student,
            'from' => $request->from_date,
            'to' => $request->end_date,
            'class' => $request->class,
            'week' => $request->week_number,
            'social_behavior' => json_encode($social_behavior),
            'personal_habits' => json_encode($personal_habits),
        ]);

        return redirect('admin/performances/'.Crypt::encryptString($p->id).'/edit');



        // return back()->with('success','Record Created');
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

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            "from_date" => 'required|max:255',
            "end_date" => 'required|max:255',
            "week_number" => 'required|max:255',
            "social_behavior" => 'required',
            "personal_habits" => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Performance::where('id',$id)->update([
            'from' => $request->from_date,
            'to' => $request->end_date,
            'week' => $request->week_number,
            'social_behavior' => json_encode($request->social_behavior),
            'personal_habits' => json_encode($request->personal_habits),
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