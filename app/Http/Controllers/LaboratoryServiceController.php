<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class LaboratoryServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = LaboratoryService::query();

        // Check if there's a search query
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $searchBy = $request->get('search_by');

            // Perform search based on selected field
            if ($searchBy === 'service_name') {
                $query->where('service_name', 'like', '%' . $searchTerm . '%');
            } elseif ($searchBy === 'descriptions') {
                $query->where('descriptions', 'like', '%' . $searchTerm . '%');
            } elseif ($searchBy === 'fee') {
                $query->where('fee', 'like', '%' . $searchTerm . '%');
            }
        }

        // Retrieve filtered services with their categories
        $services = $query->with('category')->get();

        return view('laboratory_services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('laboratory_services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'descriptions' => 'required|string',
            'fee' => 'required|numeric|between:0,999999.99',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service = new LaboratoryService();
        $service->service_name = $request->service_name;
        $service->descriptions = $request->descriptions;
        $service->fee = $request->fee;
        $service->category_id = $request->category_id;

        $service->save();

        return redirect()->route('laboratory_services.index')
            ->with('success', 'Laboratory Service created successfully.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function show($id)
    {
        $laboratoryService = LaboratoryService::findOrFail($id);

        return view('laboratory_services.show', compact('laboratoryService'));
    }

    public function edit($id)
    {
        $laboratoryService = LaboratoryService::findOrFail($id);
        $categories = Category::all();
        
        return view('laboratory_services.edit', compact('laboratoryService', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
            'fee' => 'required|numeric|between:0,999999.99',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service = LaboratoryService::findOrFail($id);
        $service->service_name = $request->service_name;
        $service->descriptions = $request->descriptions;
        $service->fee = $request->fee;
        $service->category_id = $request->category_id;

        $service->save();

        return redirect()->route('laboratory_services.index')
            ->with('success', 'Laboratory service updated successfully.');
    }

    public function destroy($id)
    {
        $laboratoryService = LaboratoryService::findOrFail($id);
        $laboratoryService->delete();

        return redirect()->route('laboratory_services.index')
            ->with('success', 'Laboratory service has been deleted successfully.');
    }

    public function getAmount($service)
    {
        $service = LaboratoryService::findOrFail($service);
        return response()->json(['data' => ['amount' => $service->fee]]);
    }
}
