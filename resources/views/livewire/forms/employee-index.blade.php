<div class="col-12 mt-3">
    <div class="card">
        <h5 class="card-header">جميع الاختبارات</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>م</th>
                            <th>العنوان</th>
                            <th class="text-center">حالة النموذج</th>
                            <th class="text-center">تاريخ البداية</th>
                            <th class="text-center">تاريخ النهاية</th>
                            <th class="text-center">المدة الزمنية</th>
                            <th class="text-center">عدد المحاولات</th>
                            <th class="text-center">درجة النجاح</th>
                            <th class="text-center">الأسئلة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $index => $form)
                        @if($form->is_active)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                <td ><a href="{{route('employee.forms.info',$form->id)}}">{{ $form->title }}</a></td>
                                <td class="text-center"> {{$form->is_active ?'نشط':'غير نشط'}}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($form->start_date)->format('Y/m/d') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($form->end_date)->format('Y/m/d') }}</td>
                                <td class="text-center">{{ $form->duration }}</td>
                                <td class="text-center">{{ $form->attempts }}</td>
                                <td class="text-center">%{{ $form->result_pass }}</td>
                                <td class="text-center">{{ $form->questions_count }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
