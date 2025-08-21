@if(auth()->user()->id == $examId->user_id OR auth()->user()->is_admin)
<div>
    @livewire('Forms.FormInfo', ['id' => $formId])

    @livewire('Exams.ExamInfo', ['formId' => $formId,'timeout'=>$timeout,'examId'=>$examId])
    @if ($timeout)
    @livewire('Exams.Questions',['formId' => $formId, 'user_id' => $user_id,'examId'=>$examId])
    @endif

</div>
<!-- إضافة سكربت العد التنازلي -->
<script src="https://cdn.jsdelivr.net/npm/countdown@2.6.0/countdown.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // const endTime = new Date("2024-11-22 20:11:00");
    const endTime = new Date("{{$end_time}}");
    const countdownElement = document.getElementById('countdown');
    const counter_sn = document.getElementById('counter_sn');
    const counter_mn = document.getElementById('counter_mn');
    const progressbar_sn = document.getElementById('progressbar_sn');
    const progressbar_mn = document.getElementById('progressbar_mn');

    // حساب الوقت الكلي بالثواني
    const totalTime = (endTime - new Date()) / 1000;

    // بدء المؤقت
    var timerId = setInterval(function() {
        var now = new Date();
        var ts = countdown(endTime);

        if (ts.minutes <= 0 && ts.seconds <= 0) {
            // إعادة تحميل الصفحة
            setTimeout(function() {
                window.location.reload(); // تحديث الصفحة بعد انتهاء الوقت
            }, 1000); // الانتظار لمدة ثانية قبل التحديث


        } else {
            var minutes = Math.max(0, ts.minutes);
            var seconds = Math.max(0, ts.seconds);

            countdownElement.innerHTML = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

            // تحديث شريط التقدم والقيم
            var secondsPercentage = (seconds / 60) * 100;
            var minutesPercentage = (minutes / (totalTime / 60)) * 100;

            counter_sn.innerHTML = Math.round(secondsPercentage) + '%';
            counter_mn.innerHTML = Math.round(minutesPercentage) + '%';
            progressbar_sn.style.width = secondsPercentage.toFixed(2) + '%';
            progressbar_mn.style.width = minutesPercentage.toFixed(2) + '%';
        }
    }, 1000);
});

</script>
@else
<div class="alert alert-danger text-center mt-5">عفواً... ليس لديك صلاحية عرض النتيجة</div>
@endif
