<!-- REQUIRED JS SCRIPTS -->



<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->

<!-- Laravel App -->
<script src="{{ url(mix('/js/app.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/bootstrap-timepicker.min.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/bootstrap-datepicker.min.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/mapbox-gl-geocoder.min.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/mapbox-gl.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/jquery.dataTables.min.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/dataTables.bootstrap.min.js') )}}" type="text/javascript"></script>

<script src="{{ asset('/js/parsley.min.js') }} "></script>

<script src="{{ url(mix('/js/jquery-ui.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/jquery.jOrgChart.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/tree.js') )}}" type="text/javascript"></script>

<script src="{{ url(mix('/js/jquery.kinetic.js')) }}" type="text/javascript"></script>

<script src="{{ url(mix('/js/select2.min.js')) }}" type="text/javascript"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

<script type="text/javascript">

    row_count = 0;



    function printDiv()
    {
        $("#spacingDiv").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

            var divContents = $("#printSection").html();

            // var printWindow = window.open('', '', 'height=1366px, width=768px');
            var printWindow = window.open('', '', 'fullscreen=1');


            printWindow.document.write('<html style="width: 100%;"><head><title>"Receipt Print"</title>');

            printWindow.document.write('<link rel="stylesheet" type="text/css" href="{{URL::to('css/bootstrap.css')}}"');

            printWindow.document.write('<link rel="stylesheet" type="text/css" href="css/style-w.css">');

            printWindow.document.write('<style>#printSection{line-height: 0.8%;} .w-center{text-align:center;} .sk-padding{padding-bottom: 0px !important;} .sk-padding .form-group{margin-bottom:10px;} .ma-qr{position: absolute;right: 0px;bottom: 30px;} .form-group{margin-bottom: 0px !important}</style>');

            printWindow.document.write('</head><body style="width: 100%;" >' +

                '<div class="col-sm-12" align="center" style="height: 115px;" >\n' +

                '\n' +

                '</div>');

            printWindow.document.write(divContents);

            //printWindow.document.style.margin = "0px";

            printWindow.document.close();

            setTimeout(function() {

                printWindow.print();

                }, 100);

            printWindow.onfocus = function () { setTimeout(function () {

                printWindow.close();

                }, 100); }
    }

</script>

<script type="text/javascript">

  $(document).ready(function() {

    $('.select2').select2({ width: '100%' })

    .select2({
      placeholder: 'Select an option'
    });

    $('.timepicker').timepicker({

      showInputs: false

    })


    $('#datepicker').datepicker({

      autoclose: true

    })

    $('#datepicker2').datepicker({

      autoclose: true

    })

    @if(Session::has('locale'))
      @if(Session::get('locale') == 'ar')
        $('#mydatatable').DataTable( {
          "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json"
          }
        } );
      @else
        $('#mydatatable').DataTable();
      @endif
    @else
      $('#mydatatable').DataTable();
    @endif
  });

  function LinksModal(user_id) ///used in moderate profiles for opening edit modal
  {

      var data= {'user_id':user_id, '_token':'{{csrf_token()}}' };



      $.post('{{ route('edit_links_modal') }}', data , function(response) {

          $("#model_body").html(response);

          //console.log(response);

          $('#updateModal').modal('show');

      });

  }

</script>

