<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['appointments']??'Calender'}}</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                
                <div class="card-header p-3">
                </div>
                <div class="card-body p-0">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script> 
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '00:00:00',
            slotMaxTime: '23:59:59',
            events: @json($events),
        });
        calendar.render();
    });
</script>