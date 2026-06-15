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
    $(document).on('click', '.show_confirm', function(event) {
        var $el = $(this);
        var form = $el.closest("form");
        var href = $el.attr('href');
        event.preventDefault();
        swal({
            title: $el.data('confirm-title') || 'Are you sure you want to delete this record?',
            text: $el.data('confirm-text') || 'If you delete this, it will be gone forever.',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                if (form.length) { form.submit(); }
                else if (href && href !== '#') { window.location.href = href; }
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on("change", ".season", function () {
            $(".season_form").submit();
        });

        /* ---- Professional PDF export (logo + header/footer) ---- */
        window.__kyPdfLogo = null;
        (function preloadKyLogo() {
            var img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = function () {
                try {
                    var c = document.createElement('canvas');
                    c.width = img.naturalWidth; c.height = img.naturalHeight;
                    c.getContext('2d').drawImage(img, 0, 0);
                    window.__kyPdfLogo = { dataUrl: c.toDataURL('image/png'), w: img.naturalWidth, h: img.naturalHeight };
                } catch (e) { /* tainted canvas — skip logo */ }
            };
            img.src = "{{ asset('assets/images2/newlogo11.png') }}";
        })();

        function kyPdfTitle() {
            var t = $('.breadcrumb-title').first().text().trim();
            return t || 'Report';
        }

        function kyPdfCustomize(doc) {
            var logo = window.__kyPdfLogo;
            var logoW = 130, logoH = logo ? Math.round(130 * (logo.h / logo.w)) : 0;

            doc.pageMargins = [30, logo ? 95 : 80, 30, 45];
            doc.defaultStyle.fontSize = 9;

            // Repeating header: logo (left) + company block (right)
            doc.header = function () {
                return {
                    margin: [30, 18, 30, 0],
                    columns: [
                        logo
                            ? { image: logo.dataUrl, width: logoW }
                            : { text: 'KONNECT.US INC.', bold: true, fontSize: 16, color: '#2c3e50' },
                        {
                            stack: [
                                { text: 'KONNECT.US INC.', bold: true, fontSize: 12, color: '#2c3e50' },
                                { text: '18502 Hillside Avenue, Jamaica, NY 11432', fontSize: 8, color: '#666' },
                                { text: 'www.konnectyatra.org  ·  rm@konnectyatra.org', fontSize: 8, color: '#666' }
                            ],
                            alignment: 'right'
                        }
                    ]
                };
            };

            // Repeating footer: generated date + page numbers
            doc.footer = function (currentPage, pageCount) {
                return {
                    margin: [30, 8, 30, 0],
                    columns: [
                        { text: 'Generated: ' + new Date().toLocaleString(), fontSize: 7, color: '#999' },
                        { text: 'Page ' + currentPage + ' of ' + pageCount, alignment: 'right', fontSize: 7, color: '#999' }
                    ]
                };
            };

            // Report title styling (content[0] is the title text node)
            if (doc.content[0]) {
                doc.content[0].alignment = 'center';
                doc.content[0].fontSize = 15;
                doc.content[0].bold = true;
                doc.content[0].color = '#2c3e50';
                doc.content[0].margin = [0, 0, 0, 2];
            }
            // Table styling: dark header, zebra rows, light borders
            var tableNode = doc.content.filter(function (c) { return c.table; })[0];

            // Sub-line under the title (record count)
            var recordCount = tableNode ? (tableNode.table.body.length - 1) : 0;
            doc.content.splice(1, 0, {
                text: 'Total records: ' + recordCount,
                alignment: 'center', fontSize: 8, color: '#888', margin: [0, 0, 0, 10]
            });

            if (tableNode) {
                tableNode.layout = {
                    fillColor: function (rowIndex) {
                        if (rowIndex === 0) return '#2c3e50';
                        return (rowIndex % 2 === 0) ? '#f4f6f8' : null;
                    },
                    hLineWidth: function () { return 0.5; },
                    vLineWidth: function () { return 0.5; },
                    hLineColor: function () { return '#dfe3e8'; },
                    vLineColor: function () { return '#dfe3e8'; },
                    paddingTop: function () { return 5; },
                    paddingBottom: function () { return 5; },
                    paddingLeft: function () { return 7; },
                    paddingRight: function () { return 7; }
                };
                // Force the table to span the full page width
                var colCount = (tableNode.table.body[0] || []).length;
                if (colCount > 0) {
                    tableNode.table.widths = [];
                    for (var i = 0; i < colCount; i++) { tableNode.table.widths.push('*'); }
                }
            }
            doc.styles.tableHeader = { color: '#ffffff', bold: true, fontSize: 9, alignment: 'left', margin: [0, 2, 0, 2] };
        }

        $('#myTables').DataTable({
            dom: "Blfrtip",
            buttons: [{
                    extend: 'pdfHtml5',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-pdf-o mr-1 "></i> PDF</button>',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    title: kyPdfTitle,
                    customize: kyPdfCustomize,
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
                    orientation: 'portrait',
                    pageSize: 'A4',
                    title: kyPdfTitle,
                    customize: kyPdfCustomize,
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