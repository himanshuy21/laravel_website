<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class textModel extends Model
{

    
    function modelOperatiions(){
        $data =  DB::table('users')->get();
        return view('list',['data' => $data]);
    }
    function countOperations(){
        return DB::table('users')->count();
    }
    function whereOperations(){
        $data =  DB::table('users')->where('name','Himanshu')->get();
        return view('list',['data' => $data]);
    }
    function insertOperations(){
         DB::table('users')->insert([
            'name' => 'amityaa',
            'email' => 'amity20aa05@gmail.com',
            'password' => '123456789011'
        ]);
        return DB::table('users')->get();
    }
    function updateOperations(){
         DB::table('users')->where('id',5)->update([
            'name' => 'amityaa',
            'email' => 'amity20aa05@gmail.com',
            'password' => '123456789011'
        ]);
        return DB::table('users')->get();
    }
    function deleteOperations(){
         return DB::table('users')->where('id',10)->delete();
    }
    use HasFactory;
}