@extends('layouts.main')
@section('content')

<style>
:root {
    --primary-dark: #233446;
    --primary-medium: #334155;
    --primary-light: #475569;
    --primary-very-light: #64748b;
    --accent-soft: #e2e8f0;
    --accent-lighter: #f1f5f9;
}

.locked-form {
    opacity: 0.6;
    background-color: var(--accent-lighter);
}
.locked-form td {
    color: var(--primary-very-light) !important;
}
.success-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    font-weight: 500;
}
.warning-badge {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    font-weight: 500;
}

/* تحسين التصميم العام */
.main-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(35, 52, 70, 0.1);
    overflow: hidden;
}

.card-header-modern {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-medium));
    color: white;
    border: none;
    padding: 1.5rem;
}

.card-header-modern h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.25rem;
}

.progress-section {
    background: var(--accent-lighter);
    border: none;
    padding: 1.5rem;
}

.modern-table {
    margin: 0;
}

.modern-table thead th {
    background: var(--primary-dark);
    color: white;
    border: none;
    padding: 1rem;
    font-weight: 600;
    text-align: center;
    position: relative;
}

.modern-table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-color: var(--accent-soft);
    background: white;
}

.modern-table tbody tr:hover {
    background: var(--accent-lighter);
    transition: background-color 0.2s ease;
}

.modern-table tbody tr.locked-form:hover {
    background: var(--accent-lighter);
}

/* تحسين الشارات */
.badge {
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 500;
    border-radius: 6px;
}

.badge.bg-primary {
    background: var(--primary-medium) !important;
}

.badge.bg-secondary {
    background: var(--primary-light) !important;
}

.badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
}

.badge.bg-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
}

.badge.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
}

.badge.bg-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
}

/* تحسين الروابط */
.text-decoration-none {
    color: var(--primary-dark) !important;
    font-weight: 500;
    transition: color 0.2s ease;
}

.text-decoration-none:hover {
    color: var(--primary-medium) !important;
}

/* تحسين شريط التقدم */
.progress {
    background-color: var(--accent-soft);
    border-radius: 6px;
    height: 10px !important;
}

.progress-bar {
    background: linear-gradient(90deg, var(--primary-dark), var(--primary-medium));
    border-radius: 6px;
}

/* تحسين الأزرار */
.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* تحسين التنبيهات */
.alert {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.25rem;
}

.alert-danger {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #dc2626;
    border-left: 4px solid #ef4444;
}

/* تأثيرات إضافية */
.card-body {
    padding: 0;
}

.table-responsive {
    border-radius: 0 0 12px 12px;
    overflow: hidden;
}

/* أيقونات محسنة */
.bx {
    font-size: 1.1em;
}

/* تحسين المساحات */
.badge.ms-2 {
    margin-left: 0.5rem !important;
}

.me-1 {
    margin-right: 0.3rem !important;
}

.me-2 {
    margin-right: 0.5rem !important;
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

    <div class="card main-card">
        <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="bx bx-file-blank me-2"></i>الاختبارات والنماذج
                    </h5>
                    @if(!$allExamsPassed && isset($gfForms) && count($gfForms) > 0)
                        <small class="text-white-50 mt-1 d-block">
                            <i class="bx bx-info-circle me-1"></i>
                            اجتز جميع الاختبارات لفتح النماذج العامة
                        </small>
                    @endif
                </div>

                @if(isset($userCertificate) && $userCertificate)
                    <div>
                        <a href="{{ route('certificate.download', $userCertificate->certificate_filename) }}"
                           class="btn btn-success">
                            <i class="bx bx-download me-1"></i>تحميل الشهادة
                        </a>
                    </div>
                @endif
            </div>
        </div>

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

            <div class="card-body progress-section">
                <div class="row align-items-center p-4">
                    <div class="col-md-8">
                        <h6 class="mb-2 text-muted" style="color: var(--primary-dark) !important;">
                            <i class="bx bx-trending-up me-1"></i>تقدم الاختبارات
                        </h6>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $progressPercentage }}%"
                                 aria-valuenow="{{ $progressPercentage }}"
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <small style="color: var(--primary-very-light);">
                            <i class="bx bx-check-circle me-1"></i>
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
                <table class="table ">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>عنوان النموذج</th>
                            <th style="width: 150px">نوع النموذج</th>
                            <th style="width: 180px">حالة الاختبار</th>
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
                                        @if(!$allExamsPassed)
                                            <span class="badge warning-badge">
                                                <i class="bx bx-lock-alt me-1"></i>مقفل
                                            </span>
                                        @elseif($gfForm->is_completed ?? false)
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i>تم التسجيل
                                            </span>
                                        @else
                                            <span class="badge success-badge">
                                                <i class="bx bx-edit me-1"></i>متاح للتعبئة
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
