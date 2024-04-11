<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services, Response::HTTP_OK);
    }

    public function show(Service $service)
    {
        return response()->json($service, Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'features' => 'nullable|json',
            'price' => 'required|numeric|min:0', // Consider adding validation for decimal 
            'demoURL' => 'required',
            'URL' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'features' => $request->has('features') ? json_encode($request->features) : null,
            'price' => $request->price,
            'user_id' => $user->id,
            'demoURL' => $request->demoURL,
            'URL' => $request->URL,
        ]);

        return response()->json($service, Response::HTTP_CREATED);
    }

    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'features' => 'nullable|json',
            'price' => 'nullable|numeric|min:0', // Consider adding validation for decimal places
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $service->update($request->all()); // Update existing service instance

        return response()->json($service, Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $service = Service::find($id);
            $service->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Failed to delete service'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function clear(Request $request)
    {
        // **Caution: Destructive action!**

        if (!$request->has('confirm')) {
            return response()->json(['message' => 'Confirmation required to delete all services'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            Service::truncate(); // Deletes all services without firing model events
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Failed to delete all services'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    


}
