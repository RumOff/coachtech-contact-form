<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->paginate(7)->onEachSide(20)
            ->withQueryString();;
                    
        return view('admin.index', compact('categories', 'contacts'));
    }

    public function destroy(Request $request, $id)
    {
        Contact::findOrFail($id)->delete();

        return redirect('/admin?keyword=' . $request->keyword . '&page=' . $request->page);
    }

    public function export(Request $request)
    {
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->get();

        $callback = function () use ($contacts) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                '名前',
                'メール',
                '性別',
                'カテゴリー',
                '作成日'
            ]);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->last_name . ' ' . $contact->first_name,
                    $contact->email,
                    $contact->gender,
                    $contact->category->content ?? '',
                    $contact->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'contacts.csv');
    }
}
