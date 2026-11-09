<?php

/**
 * Created by vsCode.
 * Use: Admin Controlling Employee
 * Admin Can CRUD Employee
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    //
    public function __construct()
    {

        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
 
        $currentDateTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $this->currentDate = $currentDate;
        $this->currentTime = $currentTime;
        $this->currentDateTime = $currentDateTime;
        
    }

    public function Employee_add_Form(){

       $emloyee_details = User::where('userType','=','1')->get();
       return view('employee/employee_add_form',compact('emloyee_details'));
    }

    public function employee_add(Request $request){

        $isactive       = 0;
        $userType       = 1;
        $name           = $request->get('name');
        $email          = $request->get('employee_email');
        $password       = $request->get('employee_password');
        $hashedPassword = Hash::make($password);
        

        User::create(
            [
                'name'              =>$name,
                'isactive'          =>$isactive,
                'email'             =>$email, 
                'userType'          =>$userType,
                'password'          =>$hashedPassword,
            ]);

        return redirect()->back()->with('success','User Added Successfully');
    }



    public function update_Employee($id){

        $emloyee_detail  = user::where('id',$id)->get();
        return view('employee/employee_update_form',compact('emloyee_detail'));
    }

    public function Employee_details_update(Request $request,$id){

        $isactive       = 0;
        $userType       = 1;

        $name           = $request->get('name');
        $email          = $request->get('employee_email');
        $password_old   = $request->get('employee_old_password');

        $password_new       = $request->get('employee_new_password');
        $hashed_password_new    = Hash::make($password_new);

        if($request->get('employee_new_password') != $password_old)
        {
            $hashedPassword = $hashed_password_new;
        }else{
            $hashedPassword =  $password_old;
        }

        $employee = User::find($id);

        $employee->update([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            return redirect('/add_employee')->with('success','User updated Successfully');
    }



    public function Inactive_Employee($id){
        $isactive  = 1;

        $employee      = User::find($id);
        $employee->update([
            'isactive' => $isactive,
        ]);

        return redirect()->back()->with('success','employee Deactivated');
    }



    public function Active_Employee($id){
        $isactive  = 0;

        $employee      = User::find($id);

        $employee->update([
            'isactive' => $isactive,
        ]);

        return redirect()->back()->with('success','employee activated');
    
    }

    ///////////////////        ADDING ---AUTHORIZER ----

    public function add_authorizerform()
    {
        $author_details = User::where('userType','=','2')->get();
        return view('employee/authorizer_add_form',compact('author_details'));
    }

    //add
    public function authorizer_add(Request $request){

        $isactive       = 0;
        $userType       = 2;
        $name           = $request->get('name');
        $email          = $request->get('author_email');
        $password       = $request->get('author_password');
        $hashedPassword = Hash::make($password);
        

        User::create(
            [
                'name'              =>$name,
                'isactive'          =>$isactive,
                'email'             =>$email, 
                'userType'          =>$userType,
                'password'          =>$hashedPassword,
            ]);

        return redirect()->back()->with('success','User Added Successfully');
    }

    //update
    public function update_Author_Form($id){

        $author_detail  = user::where('id',$id)->get();
        return view('employee/author_update_form',compact('author_detail'));
    }

    public function Authorizer_details_update(Request $request,$id){

        $isactive       = 0;
        $userType       = 2;

        $name           = $request->get('name');
        $email          = $request->get('author_email');
        $password_old   = $request->get('author_old_password');

        $password_new       = $request->get('author_new_password');
        $hashed_password_new    = Hash::make($password_new);

        if($request->get('author_new_password') != $password_old)
        {
            $hashedPassword = $hashed_password_new;
        }else{
            $hashedPassword =  $password_old;
        }

        $author = User::find($id);

        $author->update([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            return redirect('/add_authorizer')->with('success','User updated Successfully');
    }



    public function Inactive_Authorizer($id){
        $isactive  = 1;

        $author      = User::find($id);
        $author->update([
            'isactive' => $isactive,
        ]);

        return redirect()->back()->with('success','employee Deactivated');
    }



    public function Active_Authorizer($id){
        $isactive  = 0;

        $author      = User::find($id);

        $author->update([
            'isactive' => $isactive,
        ]);

        return redirect()->back()->with('success','employee activated');
    
    }


    // add ADMIN-------- (userType=>3)
     public function Admin_add_Form(){

       $admin_details = User::where('userType','=','3')->get();
       return view('employee/admin_add_form',compact('admin_details'));
    }

    public function addtoAdmin(Request $request){

        $isactive       = 0;
        $userType       = 3;
        $name           = $request->get('name');
        $email          = $request->get('admin_email');
        $password       = $request->get('admin_password');
        $hashedPassword = Hash::make($password);
        

        User::create(
            [
                'name'              =>$name,
                'isactive'          =>$isactive,
                'email'             =>$email, 
                'userType'          =>$userType,
                'password'          =>$hashedPassword,
            ]);

        return redirect()->back()->with('success','User Added Successfully');
    }



    public function update_Admin_Form($id){

        $emloyee_detail  = user::where('id',$id)->get();
        return view('employee/admin_edit_form',compact('emloyee_detail'));
    }

    public function Admin_details_update(Request $request,$id){

        $isactive       = 0;
        $userType       = 3;

        $name           = $request->get('name');
        $email          = $request->get('admin_email');
        $password_old   = $request->get('admin_old_password');

        $password_new       = $request->get('admin_new_password');
        $hashed_password_new    = Hash::make($password_new);

        if($request->get('admin_new_password') != $password_old)
        {
            $hashedPassword = $hashed_password_new;
        }else{
            $hashedPassword =  $password_old;
        }

        $employee = User::find($id);

        $employee->update([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            return redirect('/add_admin_form')->with('success','User updated Successfully');
    }



    public function Inactive_Admin_1($id){
        $isactive  = 1;

        $admin      = User::find($id);
        $admin->update([
            'isactive' => $isactive,
        ]);

        return redirect()->back()->with('success','Admin Deactivated');
    }



    public function Active_Admin_1($id){
        $isactive  = 0;

        $admin      = User::find($id);

        $admin->update([
            'isactive' => $isactive,
        ]);

        return redirect()->back()->with('success','Admin activated');
    
    }
// end super admin adding admin---------


}
