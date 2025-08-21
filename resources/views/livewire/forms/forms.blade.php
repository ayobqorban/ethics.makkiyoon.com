
<div>
    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث نموذج' : 'إضافة نموذج جديد' }}</h5>
        <form class="card-body" wire:submit.prevent="addForm">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="title" class="form-label">عنوان النموذج</label>
                    <input wire:model="title" type="text" class="form-control" id="title" required>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-12">
                    <label for="description" class="form-label">التفاصيل</label>
                    <input wire:model="description" type="text" class="form-control" id="description" required>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                 <div class="mb-3 col-2">
                    <label for="start_date" class="form-label">بداية الاختبار</label>
                    <input wire:model="start_date" type="date" class="form-control" id="start_date" required>
                    @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-2">
                    <label for="end_date" class="form-label">نهاية الاختبار</label>
                    <input wire:model="end_date" type="date" class="form-control" id="end_date" required>
                    @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-2">
                    <label for="duration" class="form-label">مدة الاختبار</label>
                    <input wire:model="duration" type="number" class="form-control" id="duration" required>
                    @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-2">
                    <label for="attempts" class="form-label">عدد المحاولات</label>
                    <input wire:model="attempts" type="number" class="form-control" id="attempts" required>
                    @error('attempts') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-2">
                    <label for="result_pass" class="form-label">درجة النجاح</label>
                    <input wire:model="result_pass" type="number" class="form-control" id="result_pass" required>
                    @error('result_pass') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-2">
                    <label for="question_count" class="form-label">عدد الأسئلة</label>
                    <input wire:model="question_count" type="number" class="form-control" id="question_count" required>
                    @error('question_count') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} me-1"></i>
                    <span class="align-middle">{{ $isEditMode ? 'تحديث النموذج' : 'إضافة النموذج' }}</span>
                </button>
                @if($isEditMode)
                    <button type="button" class="btn btn-secondary" wire:click="resetForm">
                        إلغاء التعديل
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع النماذج</h5>
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
                                <th>العنوان</th>
                                <th class="text-center">حالة النموذج</th>
                                <th class="text-center">تاريخ البداية</th>
                                <th class="text-center">تاريخ النهاية</th>
                                <th class="text-center">المدة</th>
                                <th class="text-center">المحاولات</th>
                                <th class="text-center">النجاح</th>
                                <th class="text-center">الأسئلة</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $index => $form)

                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                        <td ><a href="{{route('forms.show',$form->id)}}">{{ $form->title }}</a></td>
                                        <td class="text-center">
                                            <label class="switch switch-square">
                                            <input type="checkbox" class="switch-input"
                                            {{$form->is_active ?'checked':''}}
                                            wire:click="toggleActive({{$form->id}})"
                                            />
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
                                        <td class="text-center">{{ \Carbon\Carbon::parse($form->start_date)->format('Y/m/d') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($form->end_date)->format('Y/m/d') }}</td>
                                        <td class="text-center">{{ $form->duration }}</td>
                                        <td class="text-center">{{ $form->attempts }}</td>
                                        <td class="text-center">{{ $form->result_pass }}</td>
                                        <td class="text-center">{{ $form->question_count }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <button type="button" class="btn rounded-pill btn-icon btn-label-warning" wire:click="editForm({{ $form->id }})" onclick="scrollToForm()">
                                                    <span class="tf-icons bx bx-edit-alt bx-22px"></span>
                                                </button>
                                                <button type="button" class="btn rounded-pill btn-icon btn-label-danger" wire:click="deleteForm({{ $form->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا النموذج؟')">
                                                    <span class="tf-icons bx bx-trash bx-22px"></span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function scrollToForm() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

