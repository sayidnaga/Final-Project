<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    # method index - get all resource
    public function index()
    {
        #menggunakan model Patients untuk select data
        $patient = Patients::all();

        if($patient){
            $data = [
                'message' => 'Get all patients',
                'data' => $patient
            ];

            #menggunakan respons json laravel
            #otomatis set header content type json
            #otomatis mengubah data array ke json
            #mengatur status code
            return response()->json($data, 200);
        } else{
            $data = [
                'message' => 'Data patient is empty'
            ];

            #mengembalikan data (json) status code 200
            return response()->json($data, 200);
        }
    }

    # method show - mendapatakan detail patient
    public function show($id){
        # cari id patient yang ingin dicari
        $patient = Patients::find($id);

        if($patient){
            $data = [
                'message' => 'Get detail patient id ' . $id,
                'data' => $patient
            ];

            #mengembalikan data (json) status code 200
            return response()->json($data, 200);
        } else{
            $data = [
                'message' => 'Data patient id ' . $id . ' not found'
            ];

            #mengembalikan data (json) status code 404
            return response()->json($data, 404);
        }
    }

     #method store - menambahkan resource
     public function store(Request $request)
     {
 
         # membuat validasi
         $validateData = $request->validate([
             # kolom => rules/rules 
             'name' => 'required',
             'phone' => 'numeric|required',
             'address' => 'required',
             'status' => 'required',
             'in_date_at' => 'required|date',
             'out_date_at' => 'required|date|after:in_date_at'
         ]);
 
         # menggunakan variable patient untuk insert data
         $patient = Patients::create($validateData);
 
         $data = [
             'message' => 'patient is created succesfully',
             'data' => $patient
         ];
 
         # mengembalikan data (json) dan status code 201
         return response()->json($data, 201);
     }

     # method update - mengupdate resource
     public function update(Request $request, $id){
        # cari id patient yang ingin dicari
        $patient = Patients::find($id);
        
        if($patient){
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];

            #melakukan update data
            $patient->update($input);

            $data = [
                'message' => 'Patient id '. $id . ' is updated',
                'data' => $patient
            ];

            #mengembalikan data (json) status code 200
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Data patient id ' . $id . ' not found'
            ];

            #mengembalikan data (json) status code 404
            return response()->json($data, 404);
        }

    }

    # method destroy - menghapus resource (id)
    public function destroy($id)
    {
        # cari id patient yang ingin dicari
        $patient = Patients::find($id);

        if($patient){
            $patient->delete();

            $data = [
                'message' => 'Patient with id '. $id . ' is removed'
            ];

            #mengembalikan data (json) status code 200
            return response()->json($data, 200);
        } else{
            $data = [
                'message' => 'Data patient id ' . $id . ' not found'
            ];

            #mengembalikan data (json) status code 404
            return response()->json($data, 404);
        }
    }

    # method positive - mencari data patient yang statusnya positive
    public function search($name)
    {
        # menggunakan model Patients
        $patient = Patients::where('name', $name)->get();
        $countPatient = count($patient);

        if($countPatient > 0){
            $data = [
                'message' => 'Get patient resource by name '. $name,
                'total' => $countPatient,
                'data' => $patient
            ];

             # mengembalikan data (json) status code 200
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Data patient ' . $name . ' not found'
            ];

            #mengembalikan data (json) status code 404
            return response()->json($data, 404);
        }
    }

    # method positive - mencari data patient yang statusnya positive
    public function positive()
    {
        # menggunakan model Patients
        $patient = Patients::where('status', 'positive')->orderBy('name')->get();

        $data = [
            'message' => 'Get resource positive patient',
            'total' => $patient->count(),
            'data' => $patient
        ];

        # mengembalikan data (json) status code 200
        return response()->json($data, 200);
    }

    # method recovered - mencari data patient yang statusnya recovered
    public function recovered()
    {
        # menggunakan model Patients
        $patient = Patients::where('status', 'recovered')->orderBy('name')->get();
 
        $data = [
            'message' => 'Get resource recovered patient',
            'total' => $patient->count(),
            'data' => $patient
        ];
 
        # mengembalikan data (json) status code 200
        return response()->json($data, 200);
    }

    # method dead - mencari data patient yang statusnya dead
    public function dead()
    {
        # menggunakan model Patients
        $patient = Patients::where('status', 'dead')->orderBy('name')->get();
 
        $data = [
            'message' => 'Get resource dead patient',
            'total' => $patient->count(),
            'data' => $patient
        ];
 
        # mengembalikan data (json) status code 200
        return response()->json($data, 200);
    }

      
}
