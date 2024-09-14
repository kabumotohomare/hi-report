<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Reason;
use App\Models\Report;
use App\Models\Status;
use App\Models\ReportStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all()->sortBy('reported_at');

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function edit(Report $report)
    {
        $categories = Category::all();
        $statuses = Status::all();
        $reasons = Reason::all();
        return view('reports.edit', compact('categories', 'statuses', 'reasons', 'report'));
    }

    public function create()
    {
        $categories = Category::all();
        $statuses = Status::all();
        $reasons = Reason::all();
        return view('reports.create', compact('categories', 'statuses', 'reasons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $report = new Report($request->all());

        $file = $request->file('image');
        // ファイル名だけだと、重複の可能性があるのでランダムな値を付与
        $report->image = \Str::orderedUuid() . '_' . $file->getClientOriginalName();

        DB::beginTransaction();
        try {
            $report->save();  // 報告の保存

            $history = new ReportStatusHistory($request->all());  // フォームの内容を取得
            $history->report_id = $report->id;  // 保存した報告のidを取得
            $history->user_id = auth()->id();  // 認証したユーザーのidを取得
            $history->save();

            if (!Storage::putFileAs('images/reports', $file, $report->image)) {
                throw new \Exception('写真の保存に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
