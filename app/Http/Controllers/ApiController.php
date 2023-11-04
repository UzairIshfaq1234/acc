<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function storeleads(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address'=>'nullable|string',
            'postcode'=>'nullable',
            'product_name' => 'nullable|string',
            'message' => 'nullable|string',
            'additional_field' => 'nullable|string',
            'source' => 'required',
            
            
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => __('Please enter valid data.'),
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $validatedData = $validator->validated();
        $validatedData['type'] = "WP Form";
    
        $lead = Lead::create($validatedData);
    
        return response()->json([
            'message' => __('Data saved successful'),
        ]);
    }
}
