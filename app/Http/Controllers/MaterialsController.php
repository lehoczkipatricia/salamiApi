<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Validator;

class MaterialsController extends BaseController
{
    public function index()
    {
        $materials = Material::all();
        return $this->sendResponse($materials, "Materials successfully fetched.");
    }
    public function show($id)
    {
        $material = Material::find($id);
        return $this->sendResponse($material, "Material successfully fetched.");
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meat' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors(), 403);
        }
        $material = Material::create($request->all());
        return $this->sendResponse($material, 'Material successfully created.');
    }
    public function update(Request $request, $id)
    {
        try {
            $material = Material::find($id);
            $material->update($request->all());
            return $this->sendResponse($material, 'Material successfully updated.');
        } catch (\Throwable $th) {
            return $this->sendError("Error in updating of material", $th, 403);
        }
    }
    public function delete($id)
    {
        $material = Material::destroy($id);
        return $this->sendResponse($material, "Material successfully deleted.");
    }

}
