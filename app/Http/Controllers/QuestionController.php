<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // إظهار جميع الأسئلة
    public function index()
    {
        return view('pages.questions.index');
    }

    // إظهار الخيارات حسب الأسئلة
    // public function show($id)
    // {
    //     return view('pages.options');
    // }
    public function show($id)
    {
        $question = Question::find($id);
        return view('pages.questions.show', compact('question'));
    }

    // // إظهار صفحة إنشاء سؤال جديد
    // public function create()
    // {
    //     return view('questions.create');
    // }

    // // حفظ سؤال جديد في قاعدة البيانات
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'text' => 'required|string',
    //         'is_fixed' => 'required|boolean',
    //     ]);

    //     Question::create($request->all());
    //     return redirect()->route('questions.index')->with('success', 'تم إنشاء السؤال بنجاح');
    // }

    // // إظهار صفحة تعديل سؤال موجود
    // public function edit($id)
    // {
    //     $question = Question::findOrFail($id);
    //     return view('questions.edit', compact('question'));
    // }

    // // تحديث سؤال موجود
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'text' => 'required|string',
    //         'is_fixed' => 'required|boolean',
    //     ]);

    //     $question = Question::findOrFail($id);
    //     $question->update($request->all());
    //     return redirect()->route('questions.index')->with('success', 'تم تحديث السؤال بنجاح');
    // }

    // // حذف سؤال
    // public function destroy($id)
    // {
    //     $question = Question::findOrFail($id);
    //     $question->delete();
    //     return redirect()->route('questions.index')->with('success', 'تم حذف السؤال بنجاح');
    // }
}
