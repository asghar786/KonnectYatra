<!-- External JavaScripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script>
  $( function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yyyy' });
  } );
  </script>
<script src="{{asset('adminassets/js/form.js')}}"></script>
<script src="{{asset('adminassets/vendors/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('adminassets/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
{{-- <script src="{{asset('adminassets/vendors/bootstrap-select/bootstrap-select.min.js')}}"></script> --}}
<script src="{{asset('adminassets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('adminassets/vendors/magnific-popup/magnific-popup.js')}}"></script>
<script src="{{asset('adminassets/vendors/counter/waypoints-min.js')}}"></script>
<script src="{{asset('adminassets/vendors/counter/counterup.min.js')}}"></script>
<script src="{{asset('adminassets/vendors/imagesloaded/imagesloaded.js')}}"></script>
<script src="{{asset('adminassets/vendors/masonry/masonry.js')}}"></script>
<script src="{{asset('adminassets/vendors/masonry/filter.js')}}"></script>
<script src="{{asset('adminassets/vendors/owl-carousel/owl.carousel.js')}}"></script>
<script src='{{asset('adminassets/vendors/scroll/scrollbar.min.js')}}'></script>
<script src="{{asset('adminassets/js/functions.js')}}"></script>
<script src="{{asset('adminassets/vendors/chart/chart.min.js')}}"></script>
<script src="{{asset('adminassets/js/admin.js')}}"></script>
<script src='{{asset('adminassets/vendors/calendar/moment.min.js')}}'></script>
<script src='{{asset('adminassets/vendors/calendar/fullcalendar.js')}}'></script>
<script src='{{asset('adminassets/vendors/switcher/switcher.js')}}'></script>
<!-- Dropify Js ============================================= -->
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<!-- Datatables Js ============================================= -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<!-- Toaster Js ============================================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- SweetAlert Js ============================================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script>
  $( function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
  } );
  </script>
<script>
    @if(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
    @elseif(Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
    @endif
    @if($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{$error}}');
        @endforeach
    @endif
</script>
{{-- <script>
    $(document).ready(function () {
        $('#myTables').DataTable();
    });
</script> --}}
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form =  $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            form.submit();
        }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on("change", ".season", function () {
            $(".season_form").submit();
        });
        $('#myTables').DataTable({
            dom: "Blfrtip",
            buttons: [{
                    extend: 'pdfHtml5',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-pdf-o mr-1 "></i> PDF</button>',

                    title: 'pdf',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }

                },
                {
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-copy mr-1"></i> Copy</button>',
                    extend: 'copyHtml5',
                    title: 'Copy',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }
                },
                {
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-excel-o mr-1"></i> Excel</button>',
                    extend: 'excelHtml5',
                    title: 'Excel',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }
                },
                {
                    extend: 'print',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-print mr-1"></i> Print</button>',

                    pageSize: 'A4',
                    title: 'Print',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }

                },
            ]
        });
        $('.myTables').DataTable({
            dom: "Blfrtip",
            buttons: [{
                    extend: 'pdfHtml5',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-pdf-o mr-1 "></i> PDF</button>',

                    title: 'pdf',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }

                },
                {
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-copy mr-1"></i> Copy</button>',
                    extend: 'copyHtml5',
                    title: 'Copy',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }
                },
                {
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-excel-o mr-1"></i> Excel</button>',
                    extend: 'excelHtml5',
                    title: 'Excel',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }
                },
                {
                    extend: 'print',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-print mr-1"></i> Print</button>',

                    pageSize: 'A4',
                    title: 'Print',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }

                },
            ]
        });
    });
</script>
<style>
    button.dt-button, buttons-pdf, buttons-html5
    {
        background: none;
        border: none;
        margin-bottom: 20px;
    }
    </style>
<script>
    $(document).ready(function() {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultDate: '2019-03-12',
            navLinks: true, // can click day/week names to navigate views

            weekNumbers: true,
            weekNumbersWithinDays: true,
            weekNumberCalculation: 'ISO',

            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [{
                title: 'All Day Event',
                start: '2019-03-01'
            }, {
                title: 'Long Event',
                start: '2019-03-07',
                end: '2019-03-10'
            }, {
                id: 999,
                title: 'Repeating Event',
                start: '2019-03-09T16:00:00'
            }, {
                id: 999,
                title: 'Repeating Event',
                start: '2019-03-16T16:00:00'
            }, {
                title: 'Conference',
                start: '2019-03-11',
                end: '2019-03-13'
            }, {
                title: 'Meeting',
                start: '2019-03-12T10:30:00',
                end: '2019-03-12T12:30:00'
            }, {
                title: 'Lunch',
                start: '2019-03-12T12:00:00'
            }, {
                title: 'Meeting',
                start: '2019-03-12T14:30:00'
            }, {
                title: 'Happy Hour',
                start: '2019-03-12T17:30:00'
            }, {
                title: 'Dinner',
                start: '2019-03-12T20:00:00'
            }, {
                title: 'Birthday Party',
                start: '2019-03-13T07:00:00'
            }, {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2019-03-28'
            }]
        });

    });
</script>
</body>
</html>