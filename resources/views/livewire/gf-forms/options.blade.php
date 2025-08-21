<div>
    <!-- Options Form Section -->
    <div class="card">
        <h5 class="card-header">إضافة خيار جديد للسؤال</h5>
        <form class="card-body" wire:submit.prevent="addOption">
            <div class="mb-3">
                <label for="title" class="form-label">عنوان الخيار</label>
                <input wire:model="title" type="text" class="form-control" id="title" placeholder="أدخل عنوان الخيار" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bx bx-plus"></i> إضافة الخيار
            </button>
        </form>
    </div>

    <!-- Options List Section -->
    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع الخيارات المرتبطة بالسؤال</h5>
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
                                <th>عنوان الخيار</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $index => $option)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $option->title }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-warning" wire:click="editOption({{ $option->id }})">
                                                <span class="tf-icons bx bx-edit-alt bx-22px"></span>
                                            </button>
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-danger" wire:click="deleteOption({{ $option->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا الخيار؟')">
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
