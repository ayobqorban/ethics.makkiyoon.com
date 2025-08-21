<div>
    <div class="card">
        <h5 class="card-header">عرض النموذج</h5>
        <div class="card-body">
            <!-- زر إضافة الأسئلة -->
            <button class="btn btn-primary mb-3" wire:click="openModal">
                <i class="bx bx-plus"></i> إضافة أسئلة
            </button>

            <!-- جدول عرض الأسئلة المرتبطة بالنموذج -->
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
                        @foreach($formQuestions as $index => $question)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $question->title }}</td>
                                <td>{{ $question->type == 'radio' ? 'صندوق الاختيار' : 'صندوق النص' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="button" class="btn rounded-pill btn-icon btn-label-danger" wire:click="removeQuestion({{ $question->id }})" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا السؤال؟')">
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

    <!-- نافذة منبثقة لإضافة الأسئلة -->
    <div class="modal fade @if($isModalOpen) show @endif" tabindex="-1" style="display: @if($isModalOpen) block @else none @endif;" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة أسئلة إلى النموذج</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- اختيار الأسئلة -->
                    <label class="form-label">الأسئلة المتاحة</label>
                    <div class="form-check">
                        <input type="checkbox" wire:click="toggleSelectAll" id="selectAll" class="form-check-input">
                        <label class="form-check-label" for="selectAll">تحديد الكل</label>
                    </div>
                    <div class="mt-3">
                        @foreach($availableQuestions as $question)
                            <div class="form-check">
                                <input type="checkbox" wire:model="selectedQuestions" value="{{ $question->id }}" id="question_{{ $question->id }}" class="form-check-input">
                                <label class="form-check-label" for="question_{{ $question->id }}">{{ $question->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">إغلاق</button>
                    <button type="button" class="btn btn-primary" wire:click="addQuestionsToForm">إضافة</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay for Modal -->
    @if($isModalOpen)
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
