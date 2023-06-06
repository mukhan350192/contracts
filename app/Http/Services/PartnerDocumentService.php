<?php

namespace App\Http\Services;

use App\Models\Document;
use App\Models\DocumentStatusHistory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartnerDocumentService
{
    /**
     * @param $doc
     * @param string $name
     * @param int $userID
     * @return JsonResponse
     */
    public function addDocs($doc, string $name, int $userID): JsonResponse
    {
        $fileName = sha1(Str::random(50)) . "." . $doc->extension();
        $doc->storeAs('uploads', $fileName, 'public');
        $doc->move(public_path('uploads'), $fileName);

        $docID = $this->createDocumentData($userID, $fileName, $name);

        $this->documentStatus($docID);

        return response()->success();
    }

    /**
     * @param int $userID
     * @param string $fileName
     * @param string $name
     * @return int
     */

    public function createDocumentData(int $userID, string $fileName, string $name): int
    {
        return DB::table('documents')->insertGetId([
            'user_id' => $userID,
            'document' => $fileName,
            'name' => $name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function documentStatus(int $docID){
        return   DocumentStatusHistory::create([
            'status_id' => 1,
            'doc_id' => $docID,
        ]);
    }

    /**
     * @param int $userID
     * @return JsonResponse
     */
    public function getActiveDocs(int $userID): JsonResponse
    {
        $doc = Document::where('user_id',$userID)
            ->join('document_status_histories','document_status_histories.doc_id','=','documents.id')
            ->select('documents.id','documents.name')
            ->where('document_status_histories.status_id',4)
            ->get()->toArray();

        if (!$doc) {
            return response()->fail('Пока у вас нету документов');
        }

        $balance = DB::table('balance')->where('user_id', $userID)->first();
        if (!$balance || $balance->amount < 1) {
            return response()->fail('У вас не хватает баланса');
        }

        $data['doc'] = $doc;
        return response()->success($data);
    }

    /**
     * @param int $userID
     * @return JsonResponse
     */
    public function getDocs(int $userID): JsonResponse
    {
        $doc = Document::with('status')->where('user_id', $userID)->get()->toArray();;
        if (!$doc) {
            return response()->fail('Пока у вас нету документов');
        }
        $data['doc'] = $doc;
        return response()->success($data);
    }


    /**
     * @param int $documentID
     * @return JsonResponse
     */
    public function approveDoc(int $documentID)
    {
        DocumentStatusHistory::create([
            'status_id' => 4,
            'doc_id' => $documentID,
        ]);
        return response()->success();
    }
}
