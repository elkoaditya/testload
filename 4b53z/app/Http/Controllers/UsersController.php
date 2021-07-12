<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class UsersController extends Controller
{
    public function index(){
        $all_users = DB::table('data_user')->get();


        

        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();
        return view('all_users', compact('menu', 'all_users'));
    }
}
