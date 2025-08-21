@extends('layouts.main')
@section('content')
<style>

    h2 {
        text-align: center;
        color: #007BFF;
    }

    h5 {
        color: #0056b3;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    ul {
        list-style-type: disc;
        margin-right: 20px;
    }
    li {
        margin-bottom: 10px;
    }
</style>
<div>
    @livewire('Forms.FormInfo', ['id' => $formId])
</div>
<div class="card mt-3">
     @if(count($exams) != 0)
    <div class="card-header">
        <h4 class="mt-3">قائمة الاختبارات</h4>
    </div>
    <div class="card-body text-center">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>م</th>
                        <th class="text-right">اسم الاختبار</th>
                        <th class="text-center">رقم الاختبار</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="">{{ $item->form->title }}</td>
                            <td class="">{{ $item->id }}</td>
                            <td class="">
                                @if($item->status == 'ongoing')
                                <i>جاري الاختبار</i>
                                @elseif($item->status == 'completed')
                                <i class="text-success">تم اجتياز الاختبار</i>
                                @elseif($item->status == 'failed')
                                <i class="text-danger">لم تجتاز الاختبار</i>
                                @endif
                            </td>
                            <td class="">
                                <div class="">
                                    <div class="btn-group m-1" role="group" aria-label="Basic example">
                                    @if($item->status == 'ongoing')
                                      <a href="/exams/{{$item->id}}" class="btn btn-label-primary">
                                        <span class="tf-icons bx bx-pie-chart-alt bx-18px me-2"></span>عرض الاختبار
                                      </a>
                                    @endif
                                    @if($item->status == 'completed' || $item->status =='failed')
                                    <a href="/result/{{$item->id}}/show" class="btn btn-label-linkedin">
                                        <span class="tf-icons bx bx-bell bx-18px me-2"></span>عرض النتيجة
                                      </a>
                                      @endif
                                    </div>
                                  </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endif
</div>
<div class="card mt-3">
    <div class="card-body text-right">
        <h2 class="mt-3">تعليمات والتزامات دخول الاختبار</h2>
        <div class="instructions">
            <h5>الوقت المحدد للاختبار:</h5>
            <ul>
                <li>الالتزام بالمدة المحددة للاختبار.</li>
                <li>لن يتم تمديد الوقت إلا في ظروف طارئة وفق ما يقرره المسؤولون.</li>
            </ul>

            <h5>الأجهزة والبرمجيات:</h5>
            <ul>
                <li>يُمنع استخدام أي جهاز إلكتروني غير مصرح به (الهاتف المحمول، الأجهزة اللوحية، الساعات الذكية).</li>
                <li>يُمنع فتح أي برامج أو صفحات غير متعلقة بالاختبار أثناء الأداء.</li>
            </ul>

            <h5>الهدوء والانضباط:</h5>
            <ul>
                <li>يجب الالتزام بالهدوء أثناء الاختبار.</li>
                <li>يمنع التحدث أو التعاون مع زملائك بأي شكل من الأشكال.</li>
            </ul>

            <h5>الغش والمخالفات:</h5>
            <ul>
                <li>يحظر تمامًا الغش أو محاولة الغش بأي وسيلة.</li>
                <li>ستتم معاقبة أي مخالفة وفقًا للوائح المؤسسة المنظمة للاختبار.</li>
            </ul>

            <h5>الإجابة على الأسئلة:</h5>
            <ul>
                <li>يجب قراءة الأسئلة بعناية والإجابة بوضوح.</li>
                <li>تأكد من مراجعة إجاباتك قبل تسليم الاختبار.</li>
            </ul>

            <h5>التزام أخلاقي:</h5>
            <ul>
                <li>أتعهد بأن جميع الإجابات التي سأقدمها هي ناتجة عن جهدي الشخصي دون مساعدة من أحد.</li>
            </ul>


            <h5>الإقرار:</h5>
             <ul>
                <li>بالنقر على الزر دخول الاختبار أقر وأتعهد بالالتزام بجميع التعليمات المذكورة أعلاه.</li>
            </ul>
        </div>

        @livewire('CreateExamButton',['formId' => $formId])
    </div>
</div>
@endsection
