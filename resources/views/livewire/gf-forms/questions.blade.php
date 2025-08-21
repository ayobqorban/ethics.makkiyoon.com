<div>
    <!-- Form Section -->
    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث السؤال' : 'إضافة سؤال جديد' }}</h5>
        <form class="card-body" wire:submit.prevent="{{ $isEditMode ? 'updateQuestion' : 'addQuestion' }}">
            <div class="mb-3">
                <label for="title" class="form-label">عنوان السؤال</label>
                <input wire:model="title" type="text" class="form-control" id="title" placeholder="اكتب عنوان السؤال" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">نوع السؤال</label>
                <select wire:model="type" class="form-control" id="type" required>
                    <option value="">-- اختر نوع السؤال --</option>
                    <option value="radio">صندوق الاختيار</option>
                    <option value="textarea">صندوق النص</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} me-1"></i>
                    <span class="align-middle">{{ $isEditMode ? 'تحديث السؤال' : 'إضافة السؤال' }}</span>
                </button>
                @if($isEditMode)
                    <button type="button" class="btn btn-secondary" wire:click="resetForm">
                        إلغاء التعديل
                    </button>
                @endif
            </div>

        </form>
    </div>


    <!-- Table Section -->
    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع الأسئلة</h5>
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>عنوان السؤال</th>
                                <th>نوع السؤال</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $index => $question)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td><a href="{{route('gf_options.index', $question->id)}}">{{ $question->title }}</a></td>
                                    <td>{{ $question->type == 'radio' ? 'صندوق الاختيار' : 'صندوق النص' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-warning" wire:click="editQuestion({{ $question->id }})">
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
