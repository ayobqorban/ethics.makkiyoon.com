$(document).ready(function() {
    var table = $('#complaintsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Complaints Data',
                exportOptions: {
                    columns: ':not(:last-child)' // استثناء العمود الأخير
                },
            },
        ],
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // خيارات عدد الصفوف
        pageLength: 10, // العدد الافتراضي للصفوف المعروضة
        language: {
        search: "بحث",
        lengthMenu: "عرض _MENU_ صفوف",
        info: "عرض _START_ إلى _END_ من _TOTAL_ مدخلات",
        infoEmpty: "عرض 0 إلى 0 من 0 مدخلات",
        infoFiltered: "(منتقاة من مجموع _MAX_ مدخلات)",
        paginate: {
            first: "الأول",
            last: "الأخير",
            next: "التالي",
            previous: "السابق"
        },
        zeroRecords: "لا توجد سجلات مطابقة",
        emptyTable: "لا توجد بيانات متاحة في الجدول",
        loadingRecords: "جارٍ التحميل...",
        processing: "جارٍ المعالجة...",
        aria: {
            sortAscending: ": تفعيل لترتيب العمود تصاعدياً",
            sortDescending: ": تفعيل لترتيب العمود تنازلياً"
        }
    }
    });

    // Filter functionality
    $('#filter-status').on('change', function() {
        table.column(3).search(this.value).draw();
    });
    $('#filter-priority').on('change', function() {
        table.column(4).search(this.value).draw();
    });
    $('#filter-project').on('change', function() {
        table.column(5).search(this.value).draw();
    });
    $('#filter-source').on('change', function() {
        table.column(2).search(this.value).draw();
    });
    $('#filter-department').on('change', function() {
        table.column(6).search(this.value).draw();
    });

    // Change page length on select change
    $('#entries').on('change', function() {
        table.page.len($(this).val()).draw();
    });
});
