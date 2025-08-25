@extends('layouts.main')

@section('content')
<div class="col-12 mt-3">
    <div class="card">
        <h5 class="card-header">جميع الاختبارات</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px">م</th>
                            <th>العنوان</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allexamps as $index => $allexamp)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><a href="{{route('examps.page',$allexamp->id)}}">{{ $allexamp->name }}</a></td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">لا توجد اختبارات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
