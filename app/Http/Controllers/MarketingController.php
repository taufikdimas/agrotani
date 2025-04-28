<?php
namespace App\Http\Controllers;

use App\Models\Marketing;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index()
    {
        return response()->json(Marketing::all());
    }

    public function store(Request $request)
    {
        $marketing = Marketing::create($request->all());
        return response()->json($marketing);
    }

    public function show($id)
    {
        return response()->json(Marketing::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $marketing = Marketing::findOrFail($id);
        $marketing->update($request->all());
        return response()->json($marketing);
    }

    public function destroy($id)
    {
        Marketing::destroy($id);
        return response()->json(['message' => 'Marketing deleted']);
    }
}
