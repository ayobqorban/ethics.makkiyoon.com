
<div>

    <div class="col-12 mt-3">
        <div class="card">
            <h5 class="card-header">نماذج الاختبار</h5>
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
                                <th>العنوان</th>
                                <th>عدد المشاركين</th>
                                <th>الذين لم يشاركوا</th>
                                <th>عدد الاجتياز</th>
                                <th>الذين لم يجتازوا</th>
                                <th>إجمالي الأعضاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formsData as $index => $form)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td> <!-- رقم تسلسلي -->
                                    <td>
                                        <a href="{{ route('result.show', $form['id']) }}">
                                            {{ $form['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $form['participants'] }}</td>
                                    <td>{{ $form['not_participated'] }}</td>
                                    <td>{{ $form['passed'] }}</td>
                                    <td>{{ $form['not_passed'] }}</td>
                                    <td>{{ $form['total_users'] }}</td>
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

