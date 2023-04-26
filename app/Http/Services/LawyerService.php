<?php

namespace App\Http\Services;

use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\DocumentStatusHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LawyerService
{
    public function getDocs()
    {
        $doc = Document::with('status')->get();
        if (!$doc) {
            return response()->fail('Пока у вас нету документов');
        }
        $data['doc'] = $doc;
        return response()->success($data);
    }


    public function approve(int $document_id, $file, string|null $comment)
    {
        if ($file) {
            $fileName = sha1(Str::random(50)) . "." . $file->extension();
            $file->storeAs('uploads', $fileName, 'public');
            $file->move(public_path('uploads'), $fileName);
            $doc = Document::where('id', $document_id)->first();
            $old_name = $doc->document;
            $doc->document = $fileName;
            $doc->updated_at = Carbon::now();
            $doc->save();

            Storage::delete('uploads/' . $old_name);
        }
        $create = DocumentStatusHistory::create([
            'status_id' => 2,
            'doc_id' => $document_id,
            'comment' => $comment,
        ]);
        if (!$create) {
            return response()->fail('Попробуйте позже');
        }
        return response()->success();
    }
}
