<?php

namespace App\Http\Controllers;

use App\Http\Requests\CHeckRequest;
use App\Http\Requests\ManagerRequest;
use App\Http\Services\LawyerService;
use App\Models\User;
use Illuminate\Http\Request;

class LawyerController extends Controller
{
    public function create(ManagerRequest $request){
        return User::addLawyer($request->phone,$request->name,$request->password);
    }

    public function uncheckingDocs(LawyerService $service){
        return $service->getDocs();
    }

    public function approve(Request $request, LawyerService $service){
        return $service->approve($request->document_id,$request->file,$request->comment);
    }
}
