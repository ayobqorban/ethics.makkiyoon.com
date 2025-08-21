<div>
    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث السؤال' : 'إضافة سؤال جديد' }}</h5>
        <form class="card-body" wire:submit.prevent="addQuestion">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="question_title" class="form-label">نص السؤال</label>
                    <input wire:model="title" type="text" class="form-control" id="question_title" required>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} me-1"></i>
                    <span class="align-middle">{{ $isEditMode ? 'تحديث السؤال' : 'إضافة سؤال' }}</span>
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
            <h5 class="card-header">أسئلة الميثاق الأخلاقي</h5>
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
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ التحديث</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $index => $question)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td><a href="{{route('questions.show',$question->id)}}">{{ $question->title }}</a></td> <!-- نص السؤال -->
                                    <td>{{ $question->created_at }}</td> <!-- تاريخ الإنشاء -->
                                    <td>{{ $question->updated_at }}</td> <!-- تاريخ التحديث -->
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-warning" wire:click="editQuestion({{ $question->id }})" onclick="scrollToForm()">
                                                <span class="tf-icons bx bx-edit-alt bx-22px"></span>
                                            </button>
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-danger" wire:click="deleteQuestion({{ $question->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا السؤال؟')">
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
