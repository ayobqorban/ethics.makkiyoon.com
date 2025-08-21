<div>
    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث الشهادة' : 'إضافة شهادة جديدة' }}</h5>
        <form class="card-body" wire:submit.prevent="{{ $isEditMode ? 'updateCertificate' : 'addCertificate' }}">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="certificate_name" class="form-label">اسم الشهادة</label>
                    <input wire:model="name" type="text" class="form-control" id="certificate_name" placeholder="أدخل اسم الشهادة" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3 col-12">
                    <label for="certificate_img" class="form-label">خلفية الشهادة</label>
                    <input wire:model="img" type="file" class="form-control" id="certificate_img" accept="image/*">
                    @error('img') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} me-1"></i>
                    <span class="align-middle">{{ $isEditMode ? 'تحديث الشهادة' : 'إضافة شهادة' }}</span>
                </button>
                @if($isEditMode)
                    <button type="button" class="btn btn-secondary" wire:click="resetForm">
                        إلغاء التعديل
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div>
        @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            <a href="{{ session('pdf_path') }}" target="_blank" class="btn btn-primary mt-3">عرض ملف PDF</a>
        @elseif (session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>




    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">قائمة الشهادات</h5>
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
                                <th>اسم الشهادة</th>
                                <th>خلفية الشهادة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ التحديث</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $index => $certificate)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $certificate->name }}</td>
                                    <td>
                                        @if ($certificate->img)
                                            <img
                                                src="{{ asset('storage/' . $certificate->img) }}"
                                                alt="خلفية الشهادة"
                                                style="width: 50px; height: 50px; cursor: pointer;"
                                                onclick="showImage('{{ asset('storage/' . $certificate->img) }}')">
                                        @else
                                            لا توجد صورة
                                        @endif
                                    </td>

                                    <td>{{ $certificate->created_at }}</td>
                                    <td>{{ $certificate->updated_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-warning" wire:click="editCertificate({{ $certificate->id }})" onclick="scrollToForm()">
                                                <span class="tf-icons bx bx-edit-alt bx-22px"></span>
                                            </button>
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-danger" wire:click="deleteCertificate({{ $certificate->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذه الشهادة؟')">
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


    <div>
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">عرض الشهادة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="الصورة" style="max-width: 100%; height: auto;">
                    </div>
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
<script>
    function showImage(imageUrl) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
</script>
