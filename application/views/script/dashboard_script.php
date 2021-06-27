 <script type="text/javascript">
     $(document).ready(function() {
         var FDataTable = $('#FDataTable').DataTable({
             'columnDefs': [],
             deferRender: true,
             "order": [
                 [0, "desc"]
             ]
         });
         /* ChartJS
          * -------
          * Here we will create a few charts using ChartJS
          */

         //--------------
         //- AREA CHART -
         //--------------

         // Get context with jQuery - using jQuery's .get() method.
         var areaChartCanvas = $("#areaChart").get(0).getContext("2d");

         // This will get the first returned node in the jQuery collection.
         var areaChart = new Chart(areaChartCanvas);

         var areaChartOptions = {
             //Boolean - If we should show the scale at all
             showScale: true,
             //Boolean - Whether grid lines are shown across the chart
             scaleShowGridLines: false,
             //String - Colour of the grid lines
             scaleGridLineColor: "rgba(0,0,0,.05)",
             //Number - Width of the grid lines
             scaleGridLineWidth: 1,
             //Boolean - Whether to show horizontal lines (except X axis)
             scaleShowHorizontalLines: true,
             //Boolean - Whether to show vertical lines (except Y axis)
             scaleShowVerticalLines: true,
             //Boolean - Whether the line is curved between points
             bezierCurve: true,
             //Number - Tension of the bezier curve between points
             bezierCurveTension: 0.3,
             //Boolean - Whether to show a dot for each point
             pointDot: false,
             //Number - Radius of each point dot in pixels
             pointDotRadius: 4,
             //Number - Pixel width of point dot stroke
             pointDotStrokeWidth: 1,
             //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
             pointHitDetectionRadius: 20,
             //Boolean - Whether to show a stroke for datasets
             datasetStroke: true,
             //Number - Pixel width of dataset stroke
             datasetStrokeWidth: 2,
             //Boolean - Whether to fill the dataset with a color
             datasetFill: true,
             //String - A legend template
             legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
             //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
             maintainAspectRatio: true,
             //Boolean - whether to make the chart responsive to window resizing
             responsive: true
         };

         var areaChartDataSales = {
             labels: ["Jan", "Feb", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "Sep", "Okt", "Nov", "Des"],
             datasets: [{
                     label: "Pendapatan Produk Bulan Ini",
                     fillColor: "rgba(210, 214, 222, 1)",
                     strokeColor: "rgba(210, 214, 222, 1)",
                     pointColor: "rgba(210, 214, 222, 1)",
                     pointStrokeColor: "#c1c7d1",
                     pointHighlightFill: "#fff",
                     pointHighlightStroke: "rgba(220,220,220,1)",
                     data: <?php echo $result_sales_arr; ?>
                 }, {
                     label: "Beban Produk Bulan Ini",
                     fillColor: "rgba(60,141,188,0.9)",
                     strokeColor: "rgba(60,141,188,0.8)",
                     pointColor: "#3b8bba",
                     pointStrokeColor: "rgba(60,141,188,1)",
                     pointHighlightFill: "#fff",
                     pointHighlightStroke: "rgba(60,141,188,1)",
                     data: <?php echo $result_expense_this_year; ?>
                 }

             ]
         };

         var lineChartDataProfit = {
             labels: ["Jan", "Feb", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "Sep", "Okt", "Nov", "Des"],
             datasets: [{
                 label: "Profit Bulan Ini",
                 fillColor: "rgba(210, 214, 222, 1)",
                 strokeColor: "rgba(210, 214, 222, 1)",
                 pointColor: "rgba(210, 214, 222, 1)",
                 pointStrokeColor: "#c1c7d1",
                 pointHighlightFill: "#fff",
                 pointHighlightStroke: "rgba(220,220,220,1)",
                 data: <?php echo $result_profit_this_year; ?>
             }]
         };

         //Create the area chart sales
         areaChart.Line(areaChartDataSales, areaChartOptions);

         //-------------
         //- LINE CHART -
         //--------------
         //  var lineChartCanvas = $("#lineChart").get(0).getContext("2d");

         //  var lineChart = new Chart(lineChartCanvas);

         //  var lineChartOptions = areaChartOptions;

         //  lineChartOptions.datasetFill = false;

         //  lineChart.Line(lineChartDataProfit, lineChartOptions);



         $('#btn_act_bulan').on('click', () => {
             //  $('#body_tab_act').html('');
             return $.ajax({
                 url: "<?php echo site_url('Dashboard/getActivity') ?>",
                 data: {
                     'bulanan': true
                 },
                 type: 'GET',
                 success: function(data) {
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     console.log('ac');
                     data = json['data'];
                     console.log(data);
                     //  if (data != NULL)
                     renderAcitvity(data);
                 },
                 error: function(e) {}
             });

         })


         $('#btn_act_minggu').on('click', () => {
             //  $('#body_tab_act').html('');
             return $.ajax({
                 url: "<?php echo site_url('Dashboard/getActivity') ?>",
                 data: {
                     'mingguan': true
                 },
                 type: 'GET',
                 success: function(data) {
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     console.log('ac');
                     data = json['data'];
                     console.log(data);
                     //  if (data != NULL)
                     renderAcitvity(data);
                 },
                 error: function(e) {}
             });
         })
         getCalendarEvent()

         function getCalendarEvent() {
             return $.ajax({
                 url: "<?php echo site_url('Dashboard/getEvent') ?>",
                 data: {
                     'mingguan': true
                 },
                 type: 'GET',
                 success: function(data) {
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     console.log('ac');
                     data = json['data'];
                     //  if (data != NULL)
                     //  renderAcitvity(data);
                     //  KTCalendarBasic.init();
                     newdata = [];
                     i = 0;
                     Object.values(data).forEach((dat) => {
                         //  newdata[i]['title'] = dat['nama_event'];
                         //  newdata[i]['title'] = dat['nama_event'];
                         newdata[i] = {
                             id: dat['nama_event'],
                             title: dat['nama_event'],
                             start: dat['start_event'],
                             end: dat['end_event'],
                             url: dat['url'],
                             description: dat['keterangan'],
                             className: `fc-event-${dat["label_event"]} fc-event-solid-${dat["label_event"]}`
                         }
                         i++;
                     });
                     console.log(newdata);
                     renderCalendarEvent(newdata)

                 },
                 error: function(e) {}
             });

         }



         function renderCalendarEvent(data) {
             var todayDate = moment().startOf('day');
             var YM = todayDate.format('YYYY-MM');
             var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
             var TODAY = todayDate.format('YYYY-MM-DD');
             var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

             var calendarEl = document.getElementById('kt_calendar');
             var calendar = new FullCalendar.Calendar(calendarEl, {
                 plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                 themeSystem: 'bootstrap',

                 isRTL: KTUtil.isRTL(),

                 header: {
                     left: 'prev,next today',
                     center: 'title',
                     right: 'dayGridMonth,timeGridWeek,timeGridDay'
                 },

                 height: 1000,
                 contentHeight: 800,
                 aspectRatio: 1, // see: https://fullcalendar.io/docs/aspectRatio

                 nowIndicator: true,
                 now: TODAY + 'T09:25:00', // just for demo

                 views: {
                     dayGridMonth: {
                         buttonText: 'month'
                     },
                     timeGridWeek: {
                         buttonText: 'week'
                     },
                     timeGridDay: {
                         buttonText: 'day'
                     }
                 },

                 defaultView: 'dayGridMonth',
                 defaultDate: TODAY,

                 editable: true,
                 eventLimit: false, // allow "more" link when too many events
                 navLinks: true,
                 events: data,
                 eventClick: function(info) {
                     info.jsEvent.preventDefault(); // don't let the browser navigate

                     if (info.event.url) {
                         window.open(info.event.url);
                     }
                 },

                 eventRender: function(info) {
                     var element = $(info.el);

                     if (info.event.extendedProps && info.event.extendedProps.description) {
                         if (element.hasClass('fc-day-grid-event')) {
                             element.data('content', info.event.extendedProps.description);
                             element.data('placement', 'top');
                             KTApp.initPopover(element);
                         } else if (element.hasClass('fc-time-grid-event')) {
                             element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                         } else if (element.find('.fc-list-item-title').lenght !== 0) {
                             element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                         }
                     }
                 }
             });

             calendar.render();
         };


         $('#btn_act_hari').on('click', () => {
             //  $('#body_tab_act').html('');
             return $.ajax({
                 url: "<?php echo site_url('Dashboard/getActivity') ?>",
                 data: {
                     'harian': true
                 },
                 type: 'GET',
                 success: function(data) {
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     data = json['data'];
                     //  if (data != NULL)
                     renderAcitvity(data);
                 },
                 error: function(e) {}
             });

         })

         function renderAcitvity(data) {
             base = '<?= base_url() ?>';
             var renderData = [];

             Object.values(data).forEach((dat) => {
                 if (dat['jenis'] == '1') {
                     label = ' <span class="label label-lg label-light-success label-inline">Enty Jurnal</span>';
                     url = base + 'statements/show/' + dat['sub_id'];
                 } else if (dat['jenis'] == '2') {
                     label = ' <span class="label label-lg label-light-primary label-inline">Edit Jurnal</span>';
                     url = base + 'statements/show/' + dat['sub_id'];
                 } else if (dat['jenis'] == '3') {
                     label = ' <span class="label label-lg label-light-danger label-inline">Delete Jurnal</span>';
                     url = base + 'statements/show/' + dat['sub_id'];
                 } else if (dat['jenis'] == '4') {
                     label = ' <span class="label label-lg label-light-success label-inline">Enty Invoice</span>';
                     url = base + 'invoice/show/' + dat['sub_id'];
                 } else if (dat['jenis'] == '5') {
                     label = ' <span class="label label-lg label-light-primary label-inline">Edit Invoice</span>';
                     url = base + 'invoice/show/' + dat['sub_id'];
                 } else if (dat['jenis'] == '6') {
                     label = ' <span class="label label-lg label-light-danger label-inline">Delete Inovice</span>';
                     url = base + 'invoice/show/' + dat['sub_id'];
                 } else {
                     label = '';
                 }
                 col1 = `<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">${dat['user_name']}</a>`;
                 col2 = ` <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${dat['date_activity']}</span>`;
                 col3 = ` <span class="text-muted font-weight-500">${dat['desk']}</span>`;
                 col5 = `
                     <a href="${url}" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                         <span class="svg-icon svg-icon-md svg-icon-primary">
                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                     <rect x="0" y="0" width="24" height="24"></rect>
                                     <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
                                     <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
                                 </g>
                             </svg>
                         </span>
                     </a>`;

                 renderData.push([col1, col2, col3, label, col5]);

             })
             FDataTable.clear().rows.add(renderData).draw();
         }
     });
 </script>