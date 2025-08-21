<div>
    <div class="col-lg-12">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#backDropModal">
            <i class="bx bx-plus me-1"></i>
            <span class="align-middle">إضافة أسئلة</span>
        </button>
        {{-- @livewire('CreateExamButton', ['formId' => $formId]) --}}
        @livewire('Forms.FormInfo', ['id' => $form->id], key('form-info-' . $refreshKey))

    </div>
    <div class="col-12 mt-3">

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{session('error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="m-2">
                    <label for="" class="m-2">نموذج اعتماد الاختبار</label>
                    <select class="form-control w-auto" wire:change="selectGeneralForm($event.target.value)">
                        <option  disabled>اختر النموذج</option>
                        <option value="0">لا شيء</option>
                        @foreach ($gf_forms as $item)
                            <option value="{{$item->id}}"  {{$form->general_form_id === $item->id ? 'selected' : ''}}>
                                {{$item->title}}
                                </option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2">
                    <label for="" class="m-2">نموذج الشهادة</label>
                    <select class="form-control w-auto" wire:change="selectCetificateForm($event.target.value)">
                        <option  disabled>اختر الشهادة</option>
                        <option value="0">لا شيء</option>
                        @foreach ($cr_certificates as $item)
                            <option value="{{$item->id}}"  {{$form->certificate_id === $item->id ? 'selected' : ''}}>
                                {{$item->name}}
                                </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

    </div>





    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع الأسئلة</h5>
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
                                <th>الاسم</th>
                                <th>تثبيت السؤال</th>
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ التحديث</th>
                                <th class="w-1">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questionForm as $index => $formQuestion)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td><a
                                            href="{{ route('questions.show', $formQuestion->question_id) }}">{{ $formQuestion->question->title }}</a>
                                    </td> <!-- نص السؤال -->
                                    <td>
                                        <label class="switch switch-square">
                                            <input type="checkbox" class="switch-input"
                                                {{ $formQuestion->is_fixed ? 'checked' : '' }}
                                                wire:click="toggleFixed({{ $formQuestion->id }})" />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>{{ $formQuestion->created_at }}</td> <!-- تاريخ الإنشاء -->
                                    <td>{{ $formQuestion->updated_at }}</td> <!-- تاريخ التحديث -->
                                    <td>
                                        <button type="button" class="btn btn-icon btn-label-danger"
                                            wire:click="deleteformQuestion({{ $formQuestion->id }})"
                                            onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا السؤال؟')">
                                            <span class="tf-icons bx bx-trash bx-22px"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">{{ $this->paginator($questionForm) }}</div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content" wire:submit.prevent="addQuestions">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة أسئلة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>تحديد</th>
                                    <th>م</th>
                                    <th>نص السؤال</th>
                                    <!-- أضف أعمدة أخرى حسب الحاجة -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $index => $question)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="selectedQuestions"
                                                value="{{ $question->id }}">
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $question->title }}</td>
                                        <!-- أضف أعمدة أخرى حسب الحاجة -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">{{ $this->paginator($questions) }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">إضافة الأسئلة</button>
                </div>
            </form>
        </div>
    </div>




</div>

<script>
    document.addEventListener('livewire:close-modal', () => {
        $('#backDropModal').modal('hide');
    });
</script>
