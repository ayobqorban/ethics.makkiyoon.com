
<div>
    <style>
        .checked_style{
            background:#71dd3721!important;
            border:1px solid #71dd37!important;
        }
        .no_checked_style{
            background:#f5f5f55c!important;
        }
        .form-check-input:checked, .form-check-input[type=checkbox]:indeterminate{
            background-color: #71dd37!important;
            border-color: #71dd37!important;
            box-shadow: 0 2px 4px 0 rgba(67, 89, 113, 0.4)!important;
        }


    </style>
    @foreach ($examQuestions as $index => $examQuestion)
<div class="col-12 mb-3" id="questions_content">
    <div class="card" style="border-right: 15px solid {{ $examQuestion->is_fixed ? '#d7f2c8' : '#d9dee3' }} ;">
        <h5 class="card-header">{{ $examQuestion->question->title }}</h5>
        <div class="card-body">
            <div class="row">
                @foreach ($examQuestion->question->options as $option)
                    <div class="col-md mb-md-0 mb-5">
                        <div class="form-check custom-option custom-option-basic {{$examQuestion->selected_option_id == $option->id ? 'checked checked_style':' no_checked_style' }} h-100">
                            <label class="form-check-label custom-option-content"
                                for="option-{{ $examQuestion->question_id }}-{{ $option->id }}">
                                <input wire:click="answer_option({{ $examQuestion->id }}, {{ $option->id }})"
                                    name="question_{{ $examQuestion->question_id }}" class="form-check-input"
                                    type="radio" value="{{ $option->id }}"
                                    id="option-{{ $examQuestion->question_id }}-{{ $option->id }}" {{$examQuestion->selected_option_id == $option->id ? 'checked':'' }}>
                                <span class="custom-option-header">
                                    <span class="h6 mb-0"
                                        style="line-height: 1.5rem;">{{ $option->title }}</span>
                                </span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endforeach

</div>


