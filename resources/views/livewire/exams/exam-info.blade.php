

<div>
<div class="col-12 my-3">
    <div class="row">
        <div class="col-2 col-sm-2 col-md-3 col-lg-2 mb-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="card-title d-flex align-items-center justify-content-center mb-4">
                        <div class="avatar flex-shrink-0">
                            <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                        </div>
                    </div>
                    <p class="mb-1">الأسئلة غير المحلولة</p>
                    <h3 class="card-title mb-3">{{ $question_count - $answer_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-2 col-sm-2 col-md-3 col-lg-2 mb-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="card-title d-flex align-items-center justify-content-center mb-4">
                        <div class="avatar flex-shrink-0">
                            <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                        </div>
                    </div>
                    <p class="mb-1">الأسئلة المحلولة</p>
                    <h3 class="card-title mb-3">{{ $answer_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-2 col-sm-2 col-md-3 col-lg-2 mb-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="card-title d-flex align-items-center justify-content-center mb-4">
                        <div class="avatar flex-shrink-0">
                            <img src="../../assets/img/icons/unicons/computer.png" alt="computer" class="rounded">
                        </div>
                    </div>
                    @if ($timeout)
                    <p class="mb-1">الوقت المتبقي</p>
                    <h3 class="card-title mb-3" id="countdown"></h3>
                    @else
                    <h4 class="card-title mb-3 mt-2 text-danger">انتهى الوقت</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-4 col-sm-8 col-md-3 col-lg-6 mb-2">

            <div class="card h-100">
                <div class="card-body">
                    <div>
                        <div class="mt-3">
                            <small class="d-block mb-1">نسبة إنجاز الإختبار</small>
                            <div class="d-flex align-items-center">
                                <div class="progress w-100 me-2" style="height: 8px;">
                                    <div class="progress-bar bg-success shadow-none"
                                        style="width: {{ $completed_count }}%" role="progressbar"
                                        aria-valuenow="{{ $completed_count }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ $completed_count }}%</small>
                            </div>
                        </div>

                        @if ($timeout)
                        <div class="mt-3">
                            <small class="d-block mb-1">نسبة الزمن المتبقي الإختبار</small>
                            <div class="d-flex align-items-center">
                                <div class="progress w-100 me-2" style="height: 3px;">
                                    <div class="progress-bar bg-warning shadow-none" id="progressbar_sn" style="width: 0%"
                                        role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small id="counter_sn">0%</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="progress w-100 me-2" style="height: 8px;">
                                    <div class="progress-bar bg-info shadow-none" id="progressbar_mn" style="width: 0%"
                                        role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small id="counter_mn">0%</small>
                            </div>
                        </div>
                        @else
                        <div class="mt-3">
                            <small class="d-block mb-1 text-danger">نأسف يبدوا الوقت قد نفذ بالفعل</small>
                            <div class="d-flex align-items-center">
                                <div class="progress w-100 me-2" style="height: 3px;">
                                    <div class="progress-bar bg-warning shadow-none" id="progressbar_sn" style="width: 0%"
                                        role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small id="counter_sn">0%</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="progress w-100 me-2" style="height: 8px;">
                                    <div class="progress-bar bg-info shadow-none" id="progressbar_mn" style="width: 0%"
                                        role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small id="counter_mn">0%</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($question_count - $answer_count === 0)
<div class="col-lg-12">
    <button wire:click="completeExam" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#backDropModal"
    style="
    position: fixed;
    bottom: 0;
    z-index: 100;"
    >
        <i class="bx bx-send me-1"></i>
        <span class="align-middle">اعتمد الإجابات</span>
    </button>
</div>
@endif
</div>



