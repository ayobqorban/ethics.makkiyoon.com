<div>
    <style>
        .dont_pass {
            background: rgba(255, 0, 0, 0.072) !important;
            --bs-table-striped-bg: rgba(255, 0, 0, 0.034) !important;
        }
    </style>
    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع المشاركين</h5>
            <div class="card-body">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الموظف</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">الإجابات الصحيحة</th>
                                <th class="text-center">الإجابات الخاطئة</th>
                                <th class="text-center">لم يتم الاجابة عليها</th>
                                <th class="text-center">النسبة</th>
                                <th class="text-center">مشاركة الاستبيان</th>
                                <th class="text-center">تاريخ المشاركة</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($exams as $index => $exam)
                                <tr class="{{ $exam->status == 'failed' ? 'dont_pass' : '' }}">
                                    <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td class="text-right"><a
                                            href="{{ route('result.exam', $exam->id) }}">{{ $exam->user->name }}</a>
                                    </td>
                                    <td class="text-center">
                                        @if ($exam->status == 'ongoing')
                                            <p class="text-info"> قيد الاختبار</p>
                                        @elseif($exam->status == 'failed')
                                            <p class="text-danger">لم يتجاوز</p>
                                        @else
                                            <p class="text-success">تم الاجتياز</p>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $exam->correct_answers_count }}</td>
                                    <td class="text-center">{{ $exam->incorrect_answers_count }}</td>
                                    <td class="text-center">{{ $exam->no_aswers_count }}</td>
                                    <td class="text-center" style="width: 10%;">
                                        <div class="d-flex align-items-center">
                                            <div div="" class="progress w-100" style="height: 8px;">
                                                <div class="
                                                progress-bar
                                                @if($exam->result > 89)
                                                bg-success
                                                @elseif($exam->result > 69)
                                                bg-warning
                                                @elseif($exam->result < 70)
                                                bg-danger
                                                @endif
                                                " role="progressbar" style="width:{{$exam->result}}%;"
                                                    aria-valuenow="24" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="text-body ms-3">{{$exam->result ? $exam->result : '0'}}%</div>
                                        </div>
                                    </td>
                                    @if ($exam->gf_form == 'complete')
                                        <td class="text-center"><span class=" badge bg-label-success">تمت
                                                المشاركة</span></td>
                                    @elseif($exam->status == 'ongoing')
                                        <td class="text-center"><span class=" badge bg-label-secondary">في
                                                الانتظار</span></td>
                                    @else
                                        <td class="text-center"><span class=" badge bg-label-danger">لم يشارك</span>
                                        </td>
                                    @endif
                                    <td class="text-center">{{ $exam->start_time }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <h5 class="card-header">الموظفين الغير مشاركين</h5>
            <div class="card-body">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الموظف</th>
                                <th class="text-center">رقم الجوال</th>
                                <th class="text-center">البريد الالكتروني</th>
                                <th class="text-center">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($noExam as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td class="text-right"><a>{{ $item->name }}</a></td>
                                    <td class="text-center">{{ $item->mobile }}</td>
                                    <td class="text-center">{{ $item->mail }}</td>
                                    <td class="text-center">لم يشارك في الاختبار</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
