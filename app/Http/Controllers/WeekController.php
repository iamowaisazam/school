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
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PDF;

class WeekController extends Controller
{
 
    public function index(Request $request)
    {

        if ($request->ajax()) {


            $query = Week::join('schoolsessions','schoolsessions.id','=','week.schoolsession_id');

            // $search = $request->get('search')[0];
            // if($search != ""){
            //    $query = $query->where(function ($s) use($search) {
            //        $s->where('title','like','%'.$search.'%');
            //    });
            // }

            
            if($request->has('session') && $request->session != ''){
                $query->where('week.schoolsession_id',$request->session);
            }

            if($request->has('week') && $request->week != ''){
                $query->where('week.week',$request->week);
            }

            if($request->has('from') && $request->from != ''){
                $query->where('week.from',$request->from);
            }

            if($request->has('to') && $request->to != ''){
                $query->where('week.to',$request->to);
            }
            
            $count = $query->count();       
            $data = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('week.id','desc')
            ->select([
                'week.*',
                'schoolsessions.title',
            ])
            ->get();


            $response = [];
            foreach ($data as $key => $value) {
                

                $action = '<a href="' . URL::to('/weeks/'.$value->id.'/edit').'" class="edit btn btn-primary btn-sm">';
                $action .= '<i class="fas fa-edit"></i>';
                $action .= '</a>';

                $action .= ' <a data-id="'.URL::to('/weeks/'.$value->id).'" class="delete_btn btn btn-danger btn-sm">';
                $action .= '<i class="fas fa-trash-alt"></i>';
                $action .= '</a>';

                array_push($response,[
                    $value->id,
                    $value->title,
                    $value->week,
                    date('Y-m-d',strtotime($value->from)),
                    date('Y-m-d',strtotime($value->to)),
                    $action,
                ]);        
            }

            // dd($response);

            return response()->json([
                "draw" => $request->draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                'data'=> $response,
            ]);
        }




        $data = [
            'sessions' => SchoolSession::all(),
        ];
        return view('pages.weeks.index',$data);

    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'sessions' => SchoolSession::all(),
        ];

        return view('pages.weeks.create',$data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "from_date" => 'required|max:255',
            "end_date" => 'required|max:255',
            "week" => 'required|max:255',
            "session" => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $p = Week::create([
            "from" => $request->from_date,
            "to" => $request->end_date ,
            "week" => $request->week,
            "schoolsession_id" => $request->session,
        ]);
        return redirect('weeks');
        
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $data = [
            'sessions' => SchoolSession::all(),
            'model' => Week::findOrFail($id),
        ];

        return view('pages.weeks.edit',$data);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            "from_date" => 'required|max:255',
            "end_date" => 'required|max:255',
            "week" => 'required|max:255',
            "session" => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Week::where('id',$id)->update([
            "from" => $request->from_date,
            "to" => $request->end_date ,
            "week" => $request->week,
            "schoolsession_id" => $request->session,
        ]);

        return back()->with('success','Record Updated');

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = Week::findOrFail($id);
            $student->delete();
            return response()->json(['message' => 'Student deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Student', 'error' => $e->getMessage()], 500);
        }
    }

}