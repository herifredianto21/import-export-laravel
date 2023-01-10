<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{

    // protected $start_date;
    // protected $end_date;

    // function __construct($start_date,$end_date)
    // {
    //     $this->start_date = $start_date;
    //     $this->end_date = $end_date;
    // }

    // public function query(){

    //     $start_date = Carbon::parse(request()->start_date)->format('Y-m-d 00:00:00');
    //     $end_date = Carbon::parse(request()->end_date)->format('Y-m-d 23:59:59');
    //     $users = DB::table('users')->whereBetween('created_at',[$start_date,$end_date])->get();

    //     return $users;
    // }

    public function view(): View
    {
        $start_date = Carbon::parse(request()->start_date)->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse(request()->end_date)->format('Y-m-d 23:59:59');
        // $users = DB::table('users')->whereBetween('created_at',[$start_date,$end_date])->get();

        return view('components.users-table', [
            
            

            'users' => DB::table('users')->whereBetween('created_at',[$start_date,$end_date])->get()
        ]);
    }
}
