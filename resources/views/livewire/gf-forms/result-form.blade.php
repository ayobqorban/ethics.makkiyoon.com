<div>
    <h4 class="mb-4">نتائج المشاركات في النموذج</h4>

    <!-- جدول أسئلة الاختيارات (radio) -->
    <h5 class="mt-4 mb-3">نتائج أسئلة الاختيارات</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>السؤال</th>
                <th>الاختيار</th>
                <th>عدد الإجابات</th>
                <th>النسبة المئوية</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                @if ($question->type === 'radio')
                    @foreach ($question->options as $index => $option)
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ $question->options->count() }}">{{ $question->title }}</td>
                            @endif
                            <td>{{ $option->title }}</td>
                            <td>{{ $results[$question->id][$option->id]['count'] ?? 0 }}</td>
                            <td>{{ $results[$question->id][$option->id]['percentage'] ?? 0 }}%</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- جدول الإجابات النصية (textarea) -->
    <h5 class="mt-5 mb-3">نتائج أسئلة النصوص</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>السؤال</th>
                <th>الإجابات النصية</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                @if ($question->type === 'textarea')
                    <tr>
                        <td>{{ $question->title }}</td>
                        <td>
                            @foreach ($textResponses[$question->id] as $response)
                                - {{ $response }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
