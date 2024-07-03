<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\SharedDocument;
use App\Models\Template;
use App\Models\User;
use App\Rules\FutureDateTime;
use App\Rules\ZipFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ZipArchive;


class ReportsController extends Controller
{
    public function showForm(int $templateId)
    {
        $template = Template::findOrFail($templateId);

        $content = $template->content;

        return view('reports.create', compact( 'template', 'templateId'));
    }

    public function generateReport(Request $request, int $templateId)
    {
        $template = Template::findOrFail($templateId);

        $validator = Validator::make($request->all(), [
            'university' => 'required|string',
            'professor' => 'required|string',
            'date' => ['required', 'date', new FutureDateTime],
            'signature' => 'required|string',
            'zip_file' => ['sometimes', 'file', new ZipFile],
        ]);

        if ($validator->fails()) {
            Log::error('Validation Error: ', $validator->errors()->toArray());
            return response()->json([
                'error' => 'Validation Error',
                'details' => $validator->errors()
            ], 422);
        }


        $data = [
            'title' => $template->name,
            'university' => $request->input('university'),
            'professor' => $request->input('professor'),
            'date' => $request->input('date'),
            'signature' => $request->input('signature'),
        ];

        $requestData = $request->all();

        $chapters = $template->content;

        foreach ($template->content as $chapterIndex => $chapter) {
            foreach ($chapter['subchapters'] as $subchapterIndex => $subchapter) {
                $key = "subchapter{$chapterIndex}_{$subchapterIndex}";
                if (isset($requestData[$key])) {
                    $chapters[$chapterIndex]['subchapters'][$subchapterIndex]['content'] = $requestData[$key];
                }
            }
        }

        $data['chapters'] = $chapters;

        $pdf = PDF::loadView('report', ['data' => $data, 'chapters' => $chapters])
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'DejaVuSans']);

        $fileName = Str::uuid()->toString() . '-' . $request->input('title') . '.pdf';

        Storage::put($fileName, $pdf->output());

        if (!Storage::exists($fileName)) {
            Log::error('Failed to store PDF at: ' . storage_path($fileName));
            abort(500, 'Failed to store PDF');
        }

        $document = [
            'title' => $template->name,
            'path' => Storage::path($fileName),
            'user_id' => Auth::id(),
            'template_id' => $templateId
        ];

        // Handle ZIP file upload
        if ($request->hasFile('zip_file')) {
            $zipFile = $request->file('zip_file');
            $zipFileName = Str::uuid()->toString() . '-' . $zipFile->getClientOriginalName();
            Storage::put($zipFileName, file_get_contents($zipFile->getRealPath()));

            if (!Storage::exists($zipFileName)) {
                Log::error('Failed to store ZIP file at: ' . storage_path($zipFileName));
                abort(500, 'Failed to store ZIP file');
            }

            $document['zip_path'] = Storage::path($zipFileName);
        }

        Document::create($document);

        return redirect()->route('reports.history')->with('success', 'Report created successfully.');
    }

    public function reportHistory(Request $request)
    {
        $user = Auth::user();
        $pageSize = $request->query('page_size', 8);
        $documents = Document::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);

        return view('reports.history', compact('documents'));
    }

    public function downloadReport($id)
    {
        $document = Document::findOrFail($id);

        if ($document->user_id !== Auth::id() && !SharedDocument::where('user_id', Auth::id())->exists()) {
            throw new \Exception("Unauthorized action.", 403);
        }


        if (!file_exists($document->path)) {
            abort(404, 'File not found.');
        }

        return response()->download($document->path, $document->title . '.pdf');
    }

    public function shareReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_id' => 'required|exists:documents,id',
            'username' => 'required|exists:users,username',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Error: ', $validator->errors()->toArray());
            return response()->json([
                'error' => 'Validation Error',
                'details' => $validator->errors()
            ], 422);
        }

        try {
            $validated = $validator->validated();

            $document = Document::find($validated['document_id']);

            if ($document->user_id !== Auth::id()) {
                Log::error('Unauthorized attempt to share document.');
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $recipient = User::where('username', $validated['username'])->first();

            if ($document->user_id === $recipient->id) {
                return response()->json(['error' => 'You can\'t share your document with yourself!'], 400);
            }

            SharedDocument::create([
                'user_id' => $recipient->id,
                'document_id' => $document->id,
            ]);

            return response()->json(['message' => 'Document shared successfully']);

        } catch (\Exception $e) {
            Log::error('Error sharing document: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function sharedWithMe()
    {
        $user = Auth::user();
        $documents = $user->sharedDocuments()->with('user')->get();

        return view('reports.shared', compact('documents'));
    }

    public function deleteReport($id)
    {
        $document = Document::findOrFail($id);

        if ($document->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $filename = last(explode('/', $document->path));

        if (Storage::exists($filename)) {
            Storage::delete($filename);
        }

        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }

    public function adminDownloadReport($id)
    {
        $document = Document::findOrFail($id);

        if (!file_exists($document->path)) {
            abort(404, 'File not found.');
        }

        $user = User::findOrFail($document->user_id);
        $fileName = "{$user->username}_{$document->template_id}.pdf";

        // Create a new ZipArchive instance
        $zip = new ZipArchive;

        // Define the name of the zip file
        $zipFileName = "{$user->username}_{$document->template_id}.zip";

        // Try to open the zip file
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            // Add the PDF file to the zip
            $zip->addFile($document->path, $fileName);

            // Check if the zip file exists in the document and add it to the zip
            if ($document->zip_path && file_exists($document->zip_path)) {
                $zip->addFile($document->zip_path, basename($document->zip_path));
            }

            // Close the zip file
            $zip->close();
        }

        // Download the zip file
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }

    public function adminDownloadAllReports($templateId)
    {
        $template = Template::findOrFail($templateId);
        $reports = Document::where('template_id', $templateId)->get();

        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'No reports found for this template.');
        }

        $zip = new ZipArchive;
        $fileName = $template->name . '_reports.zip';
        $zipPath = public_path($fileName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($reports as $report) {
                $user = User::findOrFail($report->user_id);
                $filePath = $report->path;

                // check if file exists
                if (!file_exists($filePath)) {
                    // skip file
                    Log::error("File not found: $filePath");
                    continue;
                }

                $relativeNameInZipFile = "{$user->username}_{$report->template_id}";
                $zip->addFile($filePath, $relativeNameInZipFile.'.pdf');

                if($report->zip_path) {
                    $zipPath1 = $report->zip_path;
                    if (!file_exists($zipPath1)) {
                        // skip file
                        Log::error("File not found: $zipPath1");
                        continue;
                    }

                    $zip->addFile($zipPath1, $relativeNameInZipFile . '_additional.zip');
                }
            }
            $zip->close();
        } else {
            return redirect()->back()->with('error', 'Could not create zip file.');
        }

        return response()->download($zipPath)->deleteFileAfterSend();
    }
}
