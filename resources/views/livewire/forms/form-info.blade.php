<div class="card h-100">
    <div class="px-5 py-4 border border-start-0 border-end-0">
      <div><h4>{{$form->title}}</h4></div>
      <div>{{$form->description}}</div>
    </div>
    <div class="card-body">
      <div class="d-flex flex-column flex-sm-row justify-content-around  text-center gap-6">
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-calendar text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">بداية الاختبار</p>
          <h6 class="text-primary mb-0 fs-5 ">{{ \Carbon\Carbon::parse($form->start_date)->format('Y-m-d') }}</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-calendar-check text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">نهاية الاختبار</p>
          <h6 class="text-primary mb-0 fs-5">{{ \Carbon\Carbon::parse($form->end_date)->format('Y-m-d') }}</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-timer text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">مدة الاختبار</p>
          <h6 class="text-primary mb-0 fs-5">{{$form->duration}} دقيقة</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bxs-flag-checkered text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">عدد المحاولات</p>
          <h6 class="text-primary mb-0 fs-5">{{$form->attempts}}</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-station text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">حالة الإختبار</p>
          <h6 class="text-primary mb-0 fs-5">{{$form->is_active ? 'نشط':'غير نشط'}}</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-list-ol text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">اجمالي الأسئلة</p>
          <h6 class="text-primary mb-0 fs-5">{{$form->question_count+$fixed}}</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-list-check text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">الإسئلة الثابتة</p>
          <h6 class="text-primary mb-0 fs-5">{{$fixed}}</h6>
        </div>
        <div class="d-flex flex-column align-items-center">
          <span><i class="bx bx-certification text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
          <p class="my-2 w-150">درجة النجاح</p>
          <h6 class="text-primary mb-0 fs-5">%{{$form->result_pass}}</h6>
        </div>
      </div>
    </div>
  </div>
