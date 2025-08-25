<div>
    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">جميع الشهادات من جدول cr_certificates</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px">م</th>
                                <th>ID</th>
                                <th>اسم الشهادة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ التحديث</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($certificates as $index => $certificate)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $certificate->id }}</td>
                                    <td>{{ $certificate->name }}</td>
                                    <td class="text-center">{{ $certificate->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-center">{{ $certificate->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">لا توجد شهادات مسجلة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <p class="text-muted small">إجمالي الشهادات: {{ count($certificates) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
