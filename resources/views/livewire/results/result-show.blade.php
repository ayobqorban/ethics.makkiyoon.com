<div>
    <style>
        .correct_answer {
            background: #71dd3721 !important;
            border: 1px solid #71dd37 !important;
        }

        .wrong_answer {
            background: #dd4b390d !important;
            border: 1px solid #ff3e1d !important
        }

        .no_checked_style {
            background: #f5f5f55c !important;
        }

        .custom-option .custom-option-content {
            cursor: default !important;
        }

        .congratulations {
            /* background: #f3ffed; */
            background: linear-gradient(98.3deg, rgb(255 255 255) 10.6%, #e5ffd8 97.7%);
        }

        .no_pass {
            /* background: #fff4f2; */
            background: linear-gradient(98.3deg, rgb(255 255 255) 10.6%, #ffe6e6 97.7%);
        }
    </style>


@if(auth()->user()->id == $exam->user_id OR auth()->user()->is_admin)
    <div class="col-12 my-3">
        <div class="row">
            {{-- success --}}
            @if($exam->status == 'completed')
            @include('livewire.results.includes.success')
            @endif
            {{-- failed --}}
            @if($exam->status == 'failed')
            @include('livewire.results.includes.failed')
            @endif
            <div class="col-2 col-sm-2 col-md-4 col-lg-3 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="card-title d-flex align-items-center justify-content-center mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                            </div>
                        </div>
                        <p class="mb-1">أسئلة مجابة</p>
                        <h3 class="card-title mb-3">{{$exam->answer_count}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-2 col-sm-2 col-md-4 col-lg-3 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="card-title d-flex align-items-center justify-content-center mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                            </div>
                        </div>
                        <p class="mb-1">أسئلة غير مجابة</p>
                        <h3 class="card-title mb-3">{{$exam->no_answer_count}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-4 col-sm-2 col-md-4 col-lg-3 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="card-title d-flex align-items-center justify-content-center mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                            </div>
                        </div>
                        <p class="mb-1">النتجية</p>
                        <h5 class="card-title mb-3">{{$exam->status == 'completed'?'تم اجتياز الاختبار':'لم يجتاز الاختبار'}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-2 col-sm-2 col-md-4 col-lg-3 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="card-title d-flex align-items-center justify-content-center mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                            </div>
                        </div>
                        <p class="mb-1">عدد المحاولات</p>
                        <h3 class="card-title mb-3">{{$exam->attempts}}</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
@else
    <div class="alert alert-danger text-center mt-5">عفواً... ليس لديك صلاحية عرض النتيجة</div>
@endif
    @if(auth()->user()->is_admin)
    @foreach ($examQuestions as $index => $examQuestion)
        <div class="col-12 mb-3" id="questions_content">
            <div class="card"
                style="border-right: 15px solid {{ $examQuestion->is_fixed ? '#d7f2c8' : '#d9dee3' }} ;">
                <h5 class="card-header">{{ $examQuestion->question->title }}</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($examQuestion->question->options as $option)
                            <div class="col-md mb-md-0 mb-5">
                                <div
                                    class="form-check custom-option custom-option-basic
                         @if ($examQuestion->selected_option_id == $option->id && !$option->is_correct) wrong_answer
                         @elseif($option->is_correct)
                            correct_answer
                         @else
                         no_checked_style @endif
                          h-100">
                                    <label class="form-check-label custom-option-content"
                                        for="option-{{ $examQuestion->question_id }}-{{ $option->id }}">
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0" style="line-height: 1.5rem;">{{ $option->title }}
                                            </span>
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
    @endif

</div>
