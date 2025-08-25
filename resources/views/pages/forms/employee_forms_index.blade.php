@extends('layouts.main')
@section('content')
<div class="col-12 mt-3">
    <div class="card">
        <h5 class="card-header">الاختبارات</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px">م</th>
                            <th>عنوان النموذج</th>
                            <th>نوع النموذج</th>
                            <th>حالة الاختبار</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $index => $form)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><a href="{{route('employee.forms.info',$form->id)}}">{{ $form->title }}</a></td>
                                <td class="text-center">
                                    <span class="badge bg-primary">اختبار</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        // البحث عن آخر اختبار للمستخدم الحالي لهذا الـ form
                                        $userExam = $form->exams->where('user_id', auth()->id())->first();
                                    @endphp

                                    @if($userExam)
                                        @if($userExam->status == 'completed')
                                            <span class="badge bg-success">تم اجتياز الاختبار</span>
                                        @elseif($userExam->status == 'failed')
                                            <span class="badge bg-danger">لم يجتاز الاختبار</span>
                                        @elseif($userExam->status == 'ongoing')
                                            <span class="badge bg-info">جاري الاختبار</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $userExam->status }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">لم يبدأ الاختبار</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if(isset($gfForms))
                            @foreach($gfForms as $index => $gfForm)
                                <tr>
                                    <td class="text-center">{{ count($forms) + $index + 1 }}</td>
                                    <td><a href="{{route('gf_forms.show', $gfForm->id)}}">{{ $gfForm->title }}</a></td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">نموذج عام</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">متاح للعرض</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
