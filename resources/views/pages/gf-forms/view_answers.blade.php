@extends('layouts.main')
@section('content')

<style>
.answer-readonly {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 0.375rem;
    padding: 0.75rem;
    color: #495057;
}
.completed-badge {
    background: linear-gradient(45deg, #28a745, #20c997);
}
</style>

<div class="col-12 mt-3">
    <div class="row">
        <!-- معلومات النموذج -->
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bx bx-file-blank me-2"></i>{{ $gfForm->title }}
                        <span class="badge completed-badge ms-2">
                            <i class="bx bx-check me-1"></i>مكتمل
                        </span>
                    </h5>
                    <p class="card-text text-muted">{{ $gfForm->description ?? 'عرض الإجابات المقدمة سابقاً' }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bx bx-time me-1"></i>تم الإكمال:
                            @if($userCertificate->completed_at instanceof \Carbon\Carbon)
                                {{ $userCertificate->completed_at->format('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($userCertificate->completed_at)->format('d M Y') }}
                            @endif
                        </small>
                        <a href="{{ route('examps.page', $certificateId) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bx bx-arrow-back me-1"></i>العودة للشهادة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الأسئلة والإجابات -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bx bx-list-ul me-2"></i>الإجابات المقدمة
                <small class="text-muted">(للقراءة فقط)</small>
            </h5>
        </div>
        <div class="card-body">
            @if($questionsWithAnswers && count($questionsWithAnswers) > 0)
                @foreach($questionsWithAnswers as $index => $questionData)
                    <div class="mb-4 p-3 border rounded">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">
                                    <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                    {{ $questionData->question->title }}
                                </h6>

                                @if($questionData->question->type == 'radio')
                                    <div class="mb-2">
                                        <strong>نوع السؤال:</strong> <span class="badge bg-info">اختيار واحد</span>
                                    </div>
                                    <div>
                                        <strong>الإجابة المختارة:</strong>
                                        <div class="answer-readonly mt-2">
                                            @if($questionData->user_answer)
                                                @php
                                                    $selectedOption = $questionData->question->options->find($questionData->user_answer);
                                                @endphp
                                                <i class="bx bx-check-circle text-success me-2"></i>
                                                {{ $selectedOption ? $selectedOption->title : 'إجابة غير محددة' }}
                                            @else
                                                <i class="bx bx-x-circle text-danger me-2"></i>
                                                لم يتم الإجابة على هذا السؤال
                                            @endif
                                        </div>
                                    </div>

                                @elseif($questionData->question->type == 'checkbox')
                                    <div class="mb-2">
                                        <strong>نوع السؤال:</strong> <span class="badge bg-warning">اختيارات متعددة</span>
                                    </div>
                                    <div>
                                        <strong>الإجابات المختارة:</strong>
                                        <div class="answer-readonly mt-2">
                                            @if($questionData->user_answer)
                                                @php
                                                    $selectedAnswers = json_decode($questionData->user_answer, true);
                                                @endphp
                                                @if(is_array($selectedAnswers) && count($selectedAnswers) > 0)
                                                    @foreach($selectedAnswers as $answerId)
                                                        @php
                                                            $selectedOption = $questionData->question->options->find($answerId);
                                                        @endphp
                                                        @if($selectedOption)
                                                            <div class="mb-1">
                                                                <i class="bx bx-check-circle text-success me-2"></i>
                                                                {{ $selectedOption->title }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <i class="bx bx-x-circle text-danger me-2"></i>
                                                    لم يتم الإجابة على هذا السؤال
                                                @endif
                                            @else
                                                <i class="bx bx-x-circle text-danger me-2"></i>
                                                لم يتم الإجابة على هذا السؤال
                                            @endif
                                        </div>
                                    </div>

                                @elseif($questionData->question->type == 'textarea')
                                    <div class="mb-2">
                                        <strong>نوع السؤال:</strong> <span class="badge bg-secondary">نص</span>
                                    </div>
                                    <div>
                                        <strong>الإجابة:</strong>
                                        <div class="answer-readonly mt-2">
                                            @if($questionData->user_answer && trim($questionData->user_answer) !== '')
                                                <i class="bx bx-edit me-2 text-primary"></i>
                                                {{ $questionData->user_answer }}
                                            @else
                                                <i class="bx bx-x-circle text-danger me-2"></i>
                                                لم يتم الإجابة على هذا السؤال
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="bx bx-info-circle display-4 text-muted"></i>
                    <h5 class="mt-3 text-muted">لا توجد أسئلة متاحة</h5>
                </div>
            @endif
        </div>

        <div class="card-footer text-center">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('examps.page', $certificateId) }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>العودة للشهادة
                    </a>
                </div>
                @if(isset($userCertificate) && $userCertificate->certificate_filename)
                <div class="col-md-6">
                    <a href="{{ route('certificate.download', $userCertificate->certificate_filename) }}"
                       class="btn btn-success">
                        <i class="bx bx-download me-1"></i>تحميل الشهادة
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
