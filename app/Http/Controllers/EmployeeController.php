<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    //---[ SHOW_ALL_EMPLOYEE ]---
    public function show_all_employee(Request $request)
    {
        $employees = Employee::all();
        return response()->json($employees, 200);
    }
    //---[ SHOW_SINGLE_EMPLOYEE ]---
    public function show_single_employee(Request $request, $id)
    {
        $employee = Employee::find($id);
        return response()->json($employee, 200);
    }

    //---[ CREATE_EMPLOYEE ]---
    public function create_employee(Request $request)
    {
        $request->validate(
            [
                'image' => 'required',
                'employee_type' => 'required|in:director,management',
                'employee_name' => 'required',
                'employee_designation' => 'required',
                'employee_contact_number' => 'required',
                'employee_about' => 'required',
                'user_id' => 'required|integer|exists:users,id'
            ]
        );
        //decode the Input Image
        $encoded_employee_image = base64_decode($request->input('image'));
        //store the decoded image data in the "Create_Employee_Images" directory
        $decoded_employee_image_path = 'Create_Employee_Images/' . time() . '.png';
        Storage::disk('public')->put($decoded_employee_image_path, $encoded_employee_image);

        $employee = Employee::create(
            [
                'image' => $decoded_employee_image_path,
                'employee_type' => $request->employee_type,
                'employee_name' => $request->employee_name,
                'employee_designation' => $request->employee_designation,
                'employee_contact_number' => $request->employee_contact_number,
                'employee_about' => $request->employee_about,
                'user_id' => $request->user_id
            ]
        );
        return response()->json(
            [
                'message' => 'Employee Created Successfully',
                'status' => 'success'
            ],200);
    }
    //---[ UPDATE_EMPLOYEE ]---
    public function update_employee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        //update the employee fields
        $employee->employee_type = $request->input('employee_type');
        $employee->employee_name = $request->input('employee_name');
        $employee->employee_designation = $request->input('employee_designation');
        $employee->employee_contact_number = $request->input('employee_contact_number');
        $employee->employee_about = $request->input('employee_about');
        
        //update the employee_image file if wanna uploaded new image

        if($request->hasFile('image')){
            $destination = public_path('Create_Employee_Images/'. $employee->image);
            if (File::exists($destination)) {
                File::delete($destination);
            }
        }

        //Decode->encoded input image
        $base64_encoded_employee_image = $request->input('image');
        $image_data = base64_decode($base64_encoded_employee_image);

        //Naming and Storing File
        $employee_image_name ='KSL_Employee_Image_' . time() . '.png';
        Storage::disk('public')->put('Updated_Employee_Images/{$employee_image}',$image_data);

        $employee->image = "Updated_Employee_Images/{$employee_image_name}";
        $employee->save();

        return response()->json(
            [
                'message' => 'Employee Updated Successfully',
                'status' => 'updated'
            ]
            );
    }

    //---[ DELETE_EMPLOYEE ]---
    public function delete_employee(Request $request,$id)
    {
        return Employee::destroy($id);
    }
}
