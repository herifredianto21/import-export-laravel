<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function welcome()
    {
        $users = User::paginate(10);
        // $users = User::all()->paginate(5);

        // dd($users);
        return view('welcome', compact('users'));
    }

    public function rangepegawai(){
        
        // $tampilPendaftaran = DB::table('pendaftaran_perawat')
        //     ->where('status_aktif', '=', '1')
        //     ->orderBy('id_pendaftaran_perawat', 'desc')
        //     ->get();
        
        if (request()->start_date || request()->end_date) {
        $start_date = Carbon::parse(request()->start_date)->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse(request()->end_date)->format('Y-m-d 23:59:59');
        $users = DB::table('users')->whereBetween('created_at',[$start_date,$end_date])->get();
        } else {
            $users = DB::table('users')->latest()->get();
        }

        return view('welcome', ['users' => $users]);
    
}

    public function export()
    {   
        // $startDate = request()->input('startDate') ;
        // $endDate   = request()->input('endDate') ;

        

        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request) 
    {
        $request->validate(['users' => ['required']]);
        Excel::import(new UsersImport, $request->file('users'));
        
        return redirect('/')->with('success', 'All good!');
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $users = User::where('name', 'like', "%" . $keyword . "%")->paginate(5);
        return view('welcome', compact('users'))->with('users', (request()->input('page', 1) - 1) * 5);
    }
}
