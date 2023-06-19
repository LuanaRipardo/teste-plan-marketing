<?php

namespace App\Http\Controllers;

use App\Models\Appliance;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApplianceController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $brand = $request->input('brand');

        $query = Appliance::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        if ($brand) {
            $query->where('brand', 'like', "%$brand%");
        }

        $appliances = $query->get();

        return response()->json($appliances);
    }

    public function store(Request $request)
    {
        try {
            $this->validateAppliance($request);
            
            $appliance = new Appliance();
            $appliance->name = $request->input('name');
            $appliance->description = $request->input('description');
            $appliance->voltage = $request->input('voltage');
            $appliance->brand = $request->input('brand');
            $appliance->save();
            
            return response()->json($appliance, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create appliance'], 500);
        }
    }

    public function show($id)
    {
        try {
            $appliance = Appliance::findOrFail($id);
            return response()->json($appliance);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao obter o aparelho'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validateAppliance($request);
            
            $appliance = Appliance::find($id);
            if (!$appliance) {
                return response()->json(['message' => 'Appliance not found'], 404);
            }
            
            $appliance->name = $request->input('name');
            $appliance->description = $request->input('description');
            $appliance->voltage = $request->input('voltage');
            $appliance->brand = $request->input('brand');
            $appliance->save();
            
            return response()->json($appliance);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update appliance'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $appliance = Appliance::find($id);
            if (!$appliance) {
                return response()->json(['message' => 'Appliance not found'], 404);
            }
            
            $appliance->delete();
            
            return response()->json(['message' => 'Appliance deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete appliance'], 500);
        }
    }
    
    private function validateAppliance(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'voltage' => 'required',
            'brand' => 'required',
        ];
        
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        
        $this->validate($request, $rules, $messages);
    }
}