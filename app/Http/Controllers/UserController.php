<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function calcTax($salary,$taxPercentage=0.15){
        return floor($salary * $taxPercentage);
    }

    public function netSalary($salary){
        return $salary - $this->calcTax($salary);
    }

    public function index(){
        $users = User::where("nation","mm")->paginate(5)->through(function ($user){
            $user->tax = $this->calcTax($user->salary);
            $user->net_salary = $this->netSalary($user->salary);
            return $user;
        });

//        dd($users);
        return $users;
    }
}
