<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\MemberVote;
use App\Models\Option;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use App\Models\VotingForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MembersController extends Controller
{
    public function votes()
    {
        try {
            $userId = Auth::guard('api')->id();

            if (!$userId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }



            $notVotedForms = VotingForm::where('status', '1')
                ->whereHas('memberVotes', function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                    ->where('end_date', '>', now());
                })
                ->whereDoesntHave('votes', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            $votedForms = VotingForm::whereHas('memberVotes', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                ->where('end_date', '>', now())
                ->where('status', '1');
            })
                ->whereHas('votes', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            return response()->json([
                'notVotedForms' => $notVotedForms,
                'votedForms' => $votedForms,
            ], 200);
        } catch (\Exception $e) {
            // \Log::error('Error fetching voting forms: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }



    public function form($id)
    {

        try {
            $userId = Auth::guard('api')->id();

            if (!$userId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }


            $access = MemberVote::where('form_id', $id)
            ->where('user_id', $userId)
            ->whereHas('votingForm', function ($query) {
                $query->where('status', 1)
                      ->where('end_date', '>', now());
            })
            ->exists();

            if(!$access){
                return response()->json(['error' => 'access_error'], 401);
            }

            $checkVoteSumit = Vote::where('form_id',$id)->where('user_id',$userId)->first();
            if($checkVoteSumit){
                return response()->json(['error'=>'hasVotesInput'],401);
            }

            $formdata =   VotingForm::findOrFail($id);
            $questions = Question::where('form_id', $id)->get();
            $options = Option::all();
            return response()->json(
                [
                    'formdata' => $formdata,
                    'questions' => $questions,
                    'options' => $options
                ],
                200
            );
        } catch (\Exception $e) {
            // \Log::error('Error fetching voting forms: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function result($id)
    {
        $votingFormId = "$id";
        $userId = auth()->user()->id;
        try {

            $checkVoteSumit = Vote::where('form_id',$id)->where('user_id',$userId)->first();
            if(!$checkVoteSumit){
                return response()->json(['error'=>'NotVotesInput'],401);
            }

            $access = MemberVote::where('form_id', $id)
            ->where('user_id', $userId)
            ->whereHas('votingForm', function ($query) {
                $query->where('status', 1)
                      ->where('end_date', '>', now());
            })
            ->exists();

            if(!$access){
                return response()->json(['error' => 'access_error'], 401);
            }

    // جلب نموذج التصويت
    $votingForm = VotingForm::findOrFail($votingFormId);

    // جلب الأسئلة المرتبطة بالنموذج
    $questions = Question::where('form_id', $votingFormId)->get();

    // جميع الخيارات والإجابات لكل سؤال
    foreach ($questions as $question) {
        // جلب الخيارات المرتبطة بكل سؤال
        $question->options = Option::where('option_group_id', $question->option_group_id)->get();

        foreach($question->options as $option){
            // تحقق إذا كان هناك تصويت لهذا الخيار
            $voteExists = Vote::where('question_id', $question->id)
                ->where('form_id', $votingFormId)
                ->where('user_id', $userId)
                ->where('option_id', $option->id) // تحقق من تطابق option_id
                ->first(); // نستخدم first بدلاً من get لأننا نريد أول نتيجة فقط

            // إذا وجد تصويت لهذا الخيار نعينه true، وإذا لم يوجد نعينه false
            $option->checked_answer = $voteExists ? true : false;
        }
    }


            // إرجاع البيانات بصيغة JSON
            return response()->json([
                'votingForm' => $votingForm,
                'questions' => $questions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }


    public function storevote(Request $request)
    {
        $userId = auth()->user()->id; // الحصول على معرف المستخدم المصادق
        $formId = $request->input('form_id');
        $votes = $request->input('votes'); // التصويتات

        foreach ($votes as $questionId => $optionIds) {
            foreach ($optionIds as $optionId) {
                 Vote::create([
                    'user_id' => $userId,      // إضافة معرف المستخدم هنا
                    'form_id' => $formId,
                    'question_id' => $questionId,
                    'option_id' => $optionId,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'تم تسجيل التصويت بنجاح', 'form' => $userId], 200);
    }










}
