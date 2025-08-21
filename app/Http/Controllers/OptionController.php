<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    // إظهار صفحة إضافة خيار لسؤال معين
    public function create($questionId)
    {
        $question = Question::findOrFail($questionId);
        return view('options.create', compact('question'));
    }

    // حفظ خيار جديد
    public function store(Request $request, $questionId)
    {
        $request->validate([
            'text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $question = Question::findOrFail($questionId);
        $question->options()->create($request->all());

        return redirect()->route('questions.show', $questionId)->with('success', 'تم إنشاء الخيار بنجاح');
    }

    // حذف خيار
    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return back()->with('success', 'تم حذف الخيار بنجاح');
    }
}
