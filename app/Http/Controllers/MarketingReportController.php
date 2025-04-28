<?php
namespace App\Http\Controllers;

use App\Models\MarketingReport;
use Illuminate\Http\Request;

class MarketingReportController extends Controller
{
    public function index()
    {
        return response()->json(MarketingReport::with('marketing')->get());
    }

    public function store(Request $request)
    {
        $report = MarketingReport::create($request->all());
        return response()->json($report);
    }

    public function show($id)
    {
        return response()->json(MarketingReport::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $report = MarketingReport::findOrFail($id);
        $report->update($request->all());
        return response()->json($report);
    }

    public function destroy($id)
    {
        MarketingReport::destroy($id);
        return response()->json(['message' => 'Marketing report deleted']);
    }
}
