<div class="col-md-12 col-xxl-12 mb-12 mb-3">
    <div class="card h-100 congratulations">
        <div class="d-flex align-items-end row">
            <div class="col-7">
                <div class="card-body">
                    <h3 class="card-title mb-1 text-nowrap text-info"> تهانينا ... ألف مبروووك 🎉</h3>
                    <p class="card-subtitle text-nowrap mb-3 mt-2">نهنئك بمناسبة اجتيازك لاختبار {{$exam->form->title}}</p>

                    <h3 class="mb-3 text-success">تم اجتياز الاختبار بنجاح </h3>

                    @if($exam->gf_form != 'complete')
                    <a href="{{route('gf_forms.insert',['gf_form_id' =>$exam->form->general_form_id,'exam_id'=>$exam->id])}}" class="btn  btn-success mb-1">اضغط هنا للاستمرار والحصول على
                        شهادة الميثاق</a>
                    @else
                    <a href="/storage/uploads/certificates/{{$exam->certificated_name}}" class="btn  btn-success mb-1"
                        >اضغط هنا لتحميل شهادة الاجتياز</a>
                    @endif

                </div>
            </div>
            <div class="col-5">
                <div class="card-body pb-0 text-end">
                    <img src="../../assets/img/illustrations/prize-light.png" width="120"
                        class="rounded-start" alt="View Sales">
                </div>
            </div>
        </div>
    </div>
</div>
