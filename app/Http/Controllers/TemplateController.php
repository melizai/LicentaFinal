<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Template;
use App\Rules\FutureDateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function index()
    {
       // $templates = Template::all();
        $templates = Template::orderByRaw("CASE WHEN deadline >= NOW() THEN 0 ELSE 1 END, deadline")->get();
        return view('templates.admin_home', compact('templates'));
    }

    public function create()
    {
        return view('templates.template_create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:templates',
            'deadline' =>  ['required', 'date', new FutureDateTime],
            'chapters' => 'required|array',
            'chapters.*.title' => 'required|string|max:255',
            'chapters.*.subchapters' => 'required|array',
            'chapters.*.subchapters.*.title' => 'required|string|max:255',
            'zip_description' => 'sometimes|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation Error',
                'details' => $validator->errors()
            ], 422);
        }

        Template::create([
            'name' => $request->input('name'),
            'deadline' => $request->input('deadline'),
            'content' => $request->input('chapters'),
            'zip_description' => $request->input('zip_description'),
        ]);

        return redirect()->route('templates.index')->with('success', 'Template created successfully.');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);

        if ($template->deadline->isPast()) {
            return response()->json(['error' => 'Cannot delete template past its deadline.'], 403);
        }

        $template->delete();

        return response()->json(['message' => 'Template deleted successfully.']);
    }

    public function showReports($id)
    {
        $template = Template::findOrFail($id);
        $reports = $template->documents()->with('user')->orderBy('created_at', 'desc')->get();;

        return view('templates.t_reports', compact('template', 'reports'));
    }

    public function userTemplates()
    {
        $userId = Auth::id();

        $templates = Template::orderByRaw("CASE WHEN deadline >= NOW() THEN 0 ELSE 1 END, deadline")->get();

        $completedTemplates = Document::where('user_id', $userId)
            ->pluck('template_id')
            ->toArray();

        return view('templates.user_templates', compact('templates', 'completedTemplates'));
    }


}
