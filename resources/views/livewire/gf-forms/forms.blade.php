<div>
    <!-- Form Section -->
    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث النموذج' : 'إضافة نموذج جديد' }}</h5>
        <form class="card-body" wire:submit.prevent="{{ $isEditMode ? 'updateForm' : 'addForm' }}">
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

    <!-- Table Section -->
    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع النماذج</h5>
            <div class="card-body">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
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
                                <th>العنوان</th>
                                <th>التفاصيل</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $index => $form)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td><a href="{{route('gf_forms.show',$form->id)}}">{{ $form->title }}</a></td>
                                    <td>{{ $form->description }}</td>
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
