
<div>

    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث حساب' : 'إضافة حساب جديد' }}</h5>
        <form class="card-body" wire:submit.prevent="addForm">
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="name" class="form-label">اسم الموظف</label>
                    <input wire:model="name" type="text" class="form-control" id="name" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-3">
                    <label for="mail" class="form-label">البريد الالكتروني</label>
                    <input wire:model="mail" type="text" class="form-control" id="mail" required>
                    @error('mail') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-3">
                    <label for="mobile" class="form-label">رقم الجوال</label>
                    <input wire:model="mobile" type="text" class="form-control" id="mobile" required>
                    @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} me-1"></i>
                    <span class="align-middle">{{ $isEditMode ? 'تحديث المستخدم' : 'إضافة المستخدم' }}</span>
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
                                <th>اسم الموظف</th>
                                <th class="text-center">البريد الالكتروني</th>
                                <th class="text-center">رقم الجوال</th>
                                @if($is_admin)
                                <th class="text-center">تحويل إلى موظف</th>
                                @else
                                <th class="text-center">تحويل إلى إداري</th>
                                @endif
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)

                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                        <td ><a>{{ $user->name }}</a></td>
                                        <td class="text-center">{{ $user->mail }}</td>
                                        <td class="text-center">{{ $user->mobile }}</td>
                                        <td>
                                        @if($user->is_admin)
                                            <label class="switch switch-square">
                                                <input type="checkbox" class="switch-input"
                                                    {{ !$user->is_admin ? 'checked' : '' }}
                                                    wire:click="toggleFixed({{ $user->id }})" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="bx bx-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="bx bx-x"></i>
                                                    </span>
                                                </span>
                                            </label>
                                        @else
                                        <label class="switch switch-square">
                                            <input type="checkbox" class="switch-input"
                                                {{ $user->is_admin ? 'checked' : '' }}
                                                wire:click="toggleFixed({{ $user->id }})" />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </span>
                                        </label>
                                        @endif

                                        </td>




                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <button type="button" class="btn rounded-pill btn-icon btn-label-warning" wire:click="editForm({{ $user->id }})" onclick="scrollToForm()">
                                                    <span class="tf-icons bx bx-edit-alt bx-22px"></span>
                                                </button>
                                                <button type="button" class="btn rounded-pill btn-icon btn-label-danger" wire:click="deleteForm({{ $user->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا النموذج؟')">
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

