@extends('layouts.main')
@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
    <div class="card">
        <h5 class="card-header">حسابات {{$member ? 'الإدارة': 'الموظفين'}}</h5>
        <div class="card-datatable text-nowrap">
            <a href="{{route('users.create')}}" class="btn btn-primary btn-sm mx-3">إضافة موظف جديد</a>
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap5">
                <div class="table-responsive">
                    <table class="dt-column-search table table-bordered dataTable datatables-basic m-3"
                        aria-describedby="DataTables_Table_1_info" style="width: 1390px;">
                        <thead>
                            <tr>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1" style="width: 50px;"
                                    aria-label="#ID: activate to sort column ascending" aria-sort="descending">#ID</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                                    colspan="1" style="width: 226px;"
                                    aria-label="Post: activate to sort column ascending">الاسم</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                                    colspan="1" style="width: 141px;"
                                    aria-label="Date: activate to sort column ascending">البريد الالكتروني</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                                    colspan="1" style="width: 141px;"
                                    aria-label="Date: activate to sort column ascending">الجوال</th>

                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                                    colspan="1" style="width: 140px;"
                                    aria-label="Salary: activate to sort column ascending">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @if (auth()->user()->role != 'admin' && $user->role == 'admin')
                            @continue  <!-- يتجاوز هذا المستخدم ولا يعرضه -->
                            @endif
                            <tr class="odd">
                                <td class="sorting_1"><a href="app-invoice-preview.html"><span
                                            class="fw-medium">#{{$user->id}}</span></a></td>
                                <td><a href="/users/{{$user->id}}">{{$user->name}}</a></td>
                                <td>{{$user->mail}}</td>
                                <td>{{$user->mobile}}</td>

                                <td class="d-flex">
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-outline-primary btn-sm mx-1">تعديل</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">حذف</button>
                                    </form>
                                </td>
                            </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟');
        }
    </script>
@endsection
