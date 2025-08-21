<div class="col-md-12 col-xxl-12 mb-12 mb-3">
    <div class="card h-100 no_pass">
        <div class="d-flex align-items-end row">
            <div class="col-7">
                <div class="card-body">
                    <h3 class="card-title mb-1 text-nowrap text-danger"> نأسف لم تتجاوز الاختبار ... 😔</h3>
                    <p class="card-subtitle text-nowrap mb-3 mt-2">يؤسفنا بأن تبلغك بأنك لم تتجاوزالاختبار في {{$exam->form->title}}</p>

                    <!--<h3 class="mb-3 text-gray">حصلت على درجة %{{$exam->result}}</h3>-->

                    @livewire('CreateExamButton',['formId' => $exam->form_id,'btnName'=>'اعادة الاختبار'])
                </div>
            </div>
            <div class="col-5">
                <div class="card-body pb-0 text-end">
                    <img src="../../assets/img/illustrations/boy-with-laptop-light.png" width="180"
                        class="rounded-start" alt="View Sales">
                </div>
            </div>
        </div>
    </div>
</div>
