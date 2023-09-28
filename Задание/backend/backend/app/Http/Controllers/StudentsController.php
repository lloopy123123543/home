<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Polzovatel;
use App\Models\Turniket;

class StudentsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function createPassword(){
        $createPas = Student::all();
        foreach($createPas as $pas){
            $pas->password =rand( 11111, 99999);
            $pas->save();
        }
        return response() -> json("success");
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            "login" => "required|string",
            "password" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => [
                    "message" => "validation failed",
                    "errors" => $validator->errors()
                ]
            ]);
        } else {

            $user = Student::all()->where("id", $request->input("login"))->first();
            if ($user != null) {
                if ($user->password == $request->input("password")) {
                    $token = bin2hex(openssl_random_pseudo_bytes(16));
                    $user->token = $token;
                    $user->save();
                    return response()->json(["token" => $token]);
                }
            } else {
                return response()->json([
                    "error" => [
                        "message" => "Login failes",
                        "errors" => "Login was not found"
                    ]
                ]);
            }
        }

    }

    public function student (Request $request){
        $bearer = $request->header("authorization");
        $token = explode(" ", $bearer)[1];
        $student = Student::where("token", $token) -> first();
        return response()->json($student);
    }

    public function createUser(Request $request){
        $user = new Polzovatel();
        $user -> name = $request->input("name");
        $user -> login = $request->input("login");
        $user -> password = $request->input("password");
        $user -> role = $request->input("role");
        $user -> group = $request->input("group");
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $user->token = $token;
        $user->save();
        return response()->json(["token" => $token]);

    }




    public function User_login(Request $request){

        $validator = Validator::make($request->all(), [
            "login" => "required|string",
            "password" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => [
                    "message" => "validation failed",
                    "errors" => $validator->errors()
                ]
            ]);
        } else {

            $user = Polzovatel::all()->where("login", $request->input("login"))->first();
            if ($user != null) {
                if ($user->password == $request->input("password")) {
                    $token = bin2hex(openssl_random_pseudo_bytes(16));
                    $user->token = $token;
                    $user->save();
                    return response()->json(["token" => $token,
                    "role" => $user->role
                ]);
                }
            } else {
                return response()->json([
                    "error" => [
                        "message" => "Login failes" ,
                        "errors" => "Login was not found"
                    ]
                ]);
            }
        }

    }

    public function director_vision(){
        $director = Polzovatel::all()->where("role", 1)->first();

        return response()->json($director);
    }

    public function show_all(){
        $students = Student::all();
        return response()->json($students);
    }


    public function showGroupTurniket(Request $request){
        $bearer = $request->header("authorization");
        $token = explode(" ", $bearer)[1];
        $user = Polzovatel::where("token", $token) -> first();
        $group = Group::where("user_curator_id", $user->group)->first();
        $students = Student::all()->where("groupId", $group->id);

        $turniket = Turniket::all();

        $arr = [];

        foreach ($turniket as $turnik){
            foreach ($students as $student){
                if($turnik -> studentId == $student->id){
                    array_push($arr, $turnik);
                }
            }
        }
        foreach($arr as $studentName){
            $studentName -> studentId = Student::find($studentName -> studentId) -> name;

        }


        return response() -> json($arr);

    }

    public function showAllPolzovatels(){
        $polzovatels = Polzovatel::all();
        $arr = [];
        foreach($polzovatels as $polzovatel){
            if($polzovatel -> role == 1){
                $polzovatel -> role = "Директор";
                array_push($arr, $polzovatel);
            }
            if($polzovatel -> role == 2){
                $polzovatel -> role = "Сисадмин";
                array_push($arr, $polzovatel);
            }
            if($polzovatel -> role == 3){
                $polzovatel -> role = "Учитель";
                array_push($arr, $polzovatel);
            }

        }
        return response() -> json($arr);
    }

    public function changeDataStudent(Request $request){
        $id = $request-> input("id");
        $student = Student::find($id);

        $student -> name = $request -> input("name");

        if ($request -> input("group") != ""){
            $student -> groupId = $request -> input("group");
        }

        if ($request -> input("password") != ""){
            $student -> password = $request -> input("password");
        }


        $student -> save();
        return response() -> json("success");


    }
}
