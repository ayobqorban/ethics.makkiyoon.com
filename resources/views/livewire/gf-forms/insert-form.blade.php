<div>
    <style>
        .custom-option.checked {
            border: 1px solid #71dd37;
            background: #71dd3730 !important;
        }
        .checked_style {
            background: #71dd3721 !important;
            border: 1px solid #71dd37 !important;
        }
        .no_checked_style {
            background: #f5f5f55c !important;
        }
        .form-check-input:checked, .form-check-input[type=checkbox]:indeterminate {
            background-color: #71dd37 !important;
            border-color: #71dd37 !important;
            box-shadow: 0 2px 4px 0 rgba(67, 89, 113, 0.4) !important;
        }
        .modern-header-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            overflow: hidden;
            position: relative;
        }
        .modern-header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #71dd37, #20c997, #0dcaf0);
        }
        .form-title {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }
        .form-subtitle {
            color: #6c757d;
            font-weight: 400;
            line-height: 1.6;
            font-size: 1.1rem;
        }
        .completion-info {
            background: rgba(113, 221, 55, 0.1);
            border: 1px solid rgba(113, 221, 55, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }
        .completion-badge {
            background: linear-gradient(135deg, #71dd37, #20c997);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .illustration-wrapper {
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        .modern-header-card:hover .illustration-wrapper {
            opacity: 1;
        }
    </style>
@if($afterSend)
<div class="col-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-12">
          <div class="card-body text-center">
            <h2 class="card-title text-primary mb-3">شكرا على المشاركة</h2>
            <p>يمكنك تحميل الشهادة من خلال الضغط على الزر أدناه</p>
            {{-- <a class="btn btn-outline-dark" href="/storage/uploads/certificates/{{$downlaodCr}}">تحميل الشهادة</a> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

@else

@if(session('error'))
<div id="errorAlert" class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="col-12 mb-4 order-0">
    <div class="card modern-header-card">
        <div class="card-body py-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="form-title mb-3">{{$fg_form->title}}</h1>
                    <p class="form-subtitle mb-4">{{$fg_form->description}}</p>

                    <div class="completion-info">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center gap-3">
                                <span class="completion-badge">
                                    <i class="bx bx-check-circle"></i>
                                    نموذج تفاعلي
                                </span>
                                <small class="text-muted">
                                    <i class="bx bx-time me-1"></i>
                                    الوقت المقدر: 10-15 دقيقة
                                </small>
                            </div>
                            <div class="text-muted">
                                <small>
                                    <i class="bx bx-shield-check me-1"></i>
                                    بياناتك محمية ومؤمنة
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="illustration-wrapper">
                        <img src="{{asset('assets/img/illustrations/bulb-dark.png')}}"
                             height="140"
                             class="scaleX-n1-rtl"
                             alt="Survey Illustration"
                             style="filter: drop-shadow(0 4px 15px rgba(0,0,0,0.1));">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <form wire:submit.prevent="submitForm">
        <!-- عرض الأسئلة -->
        @foreach ($questions as $index => $question)
            <!-- أسئلة من نوع "radio" -->
            @if ($question->type === 'radio' && isset($question->options))
                <div class="col-12 mb-3" id="questions_content">
                    <div class="card">
                        <h5 class="card-header">{{ $question->title }}</h5>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($question->options as $option)
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'checked checked_style' : 'no_checked_style' }} h-100">
                                            <label class="form-check-label custom-option-content" for="option-{{ $question->id }}-{{ $option->id }}">
                                                <input
                                                    wire:model="answers.{{ $question->id }}"
                                                    name="question_{{ $question->id }}"
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="{{ $option->id }}"
                                                    id="option-{{ $question->id }}-{{ $option->id }}">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0" style="line-height: 1.5rem;">{{ $option->title }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- أسئلة من نوع "textarea" -->
        @foreach ($questions as $index => $question)
            @if ($question->type === 'textarea')
                <div class="col-12 mb-3" id="questions_content">
                    <div class="card">
                        <h5 class="card-header">{{ $question->title }}</h5>
                        <div class="card-body">
                            <textarea
                                class="form-control"
                                wire:model="answers.{{ $question->id }}"
                                rows="4"
                                placeholder="اكتب إجابتك هنا..."></textarea>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- زر الإرسال -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bx bx-send"></i> إرسال النموذج
            </button>
        </div>
    </form>
@endif
</div>
