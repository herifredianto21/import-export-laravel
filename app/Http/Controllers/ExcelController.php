<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function welcome()
    {
        $users = User::all()->paginate(5);

        // dd($users);
        return view('welcome', compact('users'));
    }

    public function export()
    {
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
