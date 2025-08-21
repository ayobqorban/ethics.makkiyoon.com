<div>
    <div class="card">
        <h5 class="card-header">{{ $isEditMode ? 'تحديث الخيار' : 'إضافة خيار جديد' }}</h5>
        <form class="card-body" wire:submit.prevent="addOptions">
            <div class="row">
                <div class="mb-3 col-10">
                    <label for="options_title" class="form-label">اسم الخيار</label>
                    <input wire:model="title" type="text" class="form-control" id="options_title" required>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 col-2">
                    <label for="options_point" class="form-label">النقاط</label>
                    <input wire:model="point" type="number" value="1" class="form-control" id="options_point" required>
                    @error('point') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} me-1"></i>
                    <span class="align-middle">{{ $isEditMode ? 'تحديث الخيار' : 'إضافة خيار' }}</span>
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
            <h5 class="card-header">الخيارات</h5>
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
                               
                                <th>الإجابة الصحيحة</th>

                                <th>النقاط</th>
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ التحديث</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $index => $option)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td>{{ $option->title }}</td> <!-- نص السؤال -->


                                    <td>
                                        <div class="switches-stacked">
                                            <label class="switch">
                                              <input type="radio" class="switch-input" name="switches-stacked-radio"
                                                 {{$option->is_correct ?'checked':''}}
                                                  wire:click="toggleCorrect({{$option->id}})"
                                              >
                                              <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                              </span>
                                            </label>
                                          </div>
                                    </td>

                                    <td>{{ $option->points }}</td>
                                    <td>{{ $option->created_at }}</td> <!-- تاريخ الإنشاء -->
                                    <td>{{ $option->updated_at }}</td> <!-- تاريخ التحديث -->
                                    <td>
                                        <button type="button" class="btn btn-warning" wire:click="editOption({{ $option->id }})" onclick="scrollToForm()">
                                            تعديل
                                        </button>
                                        <button type="button" class="btn btn-danger" wire:click="deleteOption({{ $option->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا الخيار')">
                                            حذف
                                        </button>
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
