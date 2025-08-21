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
    </style>
@if($afterSend)
<div class="col-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-12">
          <div class="card-body text-center">
            <h2 class="card-title text-primary mb-3">شكرا على المشاركة</h2>
            <p>يمكنك تحميل الشهادة من خلال الضغط على الزر أدناه</p>
            <a class="btn btn-outline-dark" href="/storage/uploads/certificates/{{$downlaodCr}}">تحميل الشهادة</a>
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
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h4 class="card-title text-primary mb-3">{{$fg_form->title}}</h4>
            <p class="mb-6 fs-6">{{$fg_form->description}}</p>

          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{asset('assets/img/illustrations/bulb-dark.png')}}" height="160" class="scaleX-n1-rtl" alt="View Badge User">
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
