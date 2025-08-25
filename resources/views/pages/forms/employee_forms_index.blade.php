@extends('layouts.main')
@section('content')

<style>
.locked-form {
    opacity: 0.6;
    background-color: #f8f9fa;
}
.locked-form td {
    color: #6c757d !important;
}
.success-badge {
    background: linear-gradient(45deg, #28a745, #20c997);
}
.warning-badge {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
}
</style>

<div class="col-12 mt-3">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">
            <i class="bx bx-file-blank me-2"></i>الاختبارات والنماذج
            @if(!$allExamsPassed && isset($gfForms) && count($gfForms) > 0)
                <small class="text-muted ms-2">
                    <i class="bx bx-info-circle"></i>
                    اجتز جميع الاختبارات لفتح النماذج العامة
                </small>
            @endif

            @if(isset($userCertificate) && $userCertificate)
                <div class="float-end">
                    <a href="{{ route('certificate.download', $userCertificate->certificate_filename) }}"
                       class="btn btn-success btn-sm">
                        <i class="bx bx-download me-1"></i>تحميل الشهادة
                    </a>
                </div>
            @endif
        </h5>

            @if(count($forms) > 0)
            @php
                $userId = auth()->id(); // تأكد من ربط العمليات بالمستخدم الحالي
                $completedExamsCount = 0;
                foreach($forms as $form) {
                    $userExam = $form->exams->where('user_id', $userId)->first();
                    if($userExam && $userExam->status == 'completed') {
                        $completedExamsCount++;
                    }
                }
                $totalExams = count($forms);
                $progressPercentage = $totalExams > 0 ? ($completedExamsCount / $totalExams) * 100 : 0;
            @endphp

            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="mb-2">تقدم الاختبارات</h6>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $progressPercentage }}%"
                                 aria-valuenow="{{ $progressPercentage }}"
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $completedExamsCount }} من {{ $totalExams }} اختبارات مكتملة
                        </small>
                    </div>
                    <div class="col-md-4 text-end">
                        @if($allExamsPassed)
                            <span class="badge bg-success fs-6">
                                <i class="bx bx-check-circle me-1"></i>
                                جميع الاختبارات مكتملة!
                            </span>
                        @else
                            <span class="badge bg-warning fs-6">
                                <i class="bx bx-time me-1"></i>
                                {{ $totalExams - $completedExamsCount }} اختبارات متبقية
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
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
                            @php
                                // البحث عن آخر اختبار للمستخدم الحالي لهذا الـ form
                                $userId = auth()->id();
                                $userExam = $form->exams->where('user_id', $userId)->first();
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{route('employee.forms.info',$form->id)}}" class="text-decoration-none">
                                        <i class="bx bx-task me-1"></i>{{ $form->title }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        <i class="bx bx-book-reader me-1"></i>اختبار
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($userExam)
                                        @if($userExam->status == 'completed')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i>تم اجتياز الاختبار
                                            </span>
                                        @elseif($userExam->status == 'failed')
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x-circle me-1"></i>لم يجتاز الاختبار
                                            </span>
                                        @elseif($userExam->status == 'ongoing')
                                            <span class="badge bg-info">
                                                <i class="bx bx-time me-1"></i>جاري الاختبار
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ $userExam->status }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bx bx-play-circle me-1"></i>لم يبدأ الاختبار
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if(isset($gfForms))
                            @foreach($gfForms as $index => $gfForm)
                                <tr class="{{ !$allExamsPassed ? 'locked-form' : '' }}">
                                    <td class="text-center">{{ count($forms) + $index + 1 }}</td>
                                    <td>
                                        @if($allExamsPassed)
                                            @if($gfForm->is_completed ?? false)
                                                <a href="{{route('gf_forms.view_answers', $gfForm->id)}}" class="text-decoration-none">
                                                    <i class="bx bx-check-circle me-1 text-success"></i>{{ $gfForm->title }}
                                                    <small class="badge bg-success ms-2">مكتمل</small>
                                                </a>
                                            @else
                                                <a href="{{route('gf_forms.insert', [$gfForm->id, 0])}}" class="text-decoration-none">
                                                    <i class="bx bx-file-blank me-1"></i>{{ $gfForm->title }}
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted">
                                                <i class="bx bx-lock-alt me-1"></i>{{ $gfForm->title }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            <i class="bx bx-clipboard me-1"></i>نموذج عام
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($allExamsPassed)
                                            <span class="badge success-badge">
                                                <i class="bx bx-check-circle me-1"></i>متاح للتعبئة
                                            </span>
                                        @else
                                            <span class="badge warning-badge">
                                                <i class="bx bx-lock-alt me-1"></i>مقفل
                                            </span>
                                        @endif
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
