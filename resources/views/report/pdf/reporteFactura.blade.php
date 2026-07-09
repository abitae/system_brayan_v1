@extends("layouts.adminLayout.admin_design")
@section("title", "Empleados")

@section('styles')
  <style>
    .col-md-7 {
      float: right;
    }
    .select2-container .select2-selection--single {
      height: 35px !important;
      border: 1px solid #d1d3e2 !important;
      padding: 2px 0;
      color: #6e707e !important;
    }
  </style>
@endsection

@section("content")
  <div class="row">
    <div class="col-sm-12 user-select-none">
      <h3><i class="far fa-file-alt"></i> Comprobantes emitidos</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <div class="row">
            <div class="col-sm-12 col-md-7 col-lg-8">
              <h5 class="mb-2 text-gray-800">Facturas emitidas</h5>
            </div>
            <div class="col-sm-12 col-md-5 col-lg-4">
              <a class="btn btn-sm btn-block color-excel" href="{{route("excelFactura")}}"><i class="far fa-file-excel"></i> Generar Excel</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="text-center mb-4">Diagrama de facturas emititidas</h6>
          <canvas id="oilChart" width="600" height="200"></canvas>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <div class="row">
            <div class="col-sm-12 col-md-7 col-lg-8">
              <h5 class="mb-2 text-gray-800">Boletas emitidas</h5>
            </div>
            <div class="col-sm-12 col-md-5 col-lg-4">
              <a class="btn btn-sm btn-block color-excel" href="{{route("excelBoleta")}}"><i class="far fa-file-excel"></i> Generar Excel</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="text-center mb-4">Diagrama de boletas emititidas</h6>
          <canvas id="oilChart2" width="600" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
@endsection


@section("scripts")
  <script>
    var COLORS_BRANCH_OFFICE = ["#FF6384","#2D2D2D","#84FF63","#6384FF","#693707","#63FF84"];
    const total_colores = "{{count($total_envios_factura)}}"

    var oilCanvas = document.getElementById("oilChart").getContext("2d");
    var oilCanvas2 = document.getElementById("oilChart2").getContext("2d");

    Chart.defaults.global.legend.display = false;
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 13;

    var pieChart = new Chart(oilCanvas, {
      type: 'bar',
      data: {
        labels: [
          @for($i = 0; $i < count($total_envios_factura); $i++)
            "{{$total_envios_factura[$i]["nombre"]}} ({{$total_envios_factura[$i]["total"]}})",
          @endfor
        ],
        datasets: [
          {
            data: [
              @for($i = 0; $i < count($total_envios_factura); $i++)
                "{{$total_envios_factura[$i]["total"]}}",
              @endfor
            ],
            backgroundColor: COLORS_BRANCH_OFFICE,
          }
        ]
      }
    });

    const total_colores2 = "{{count($total_envios_boleta)}}"


    var pieChart = new Chart(oilCanvas2, {
      type: 'bar',
      data: {
        labels: [
          @for($i = 0; $i < count($total_envios_boleta); $i++)
            "{{$total_envios_boleta[$i]["nombre"]}} ({{$total_envios_boleta[$i]["total"]}})",
          @endfor
        ],
        datasets: [
          {
            data: [
              @for($i = 0; $i < count($total_envios_factura); $i++)
                "{{$total_envios_boleta[$i]["total"]}}",
              @endfor
            ],
            backgroundColor: [
              "#FF6384",
              "#2D2D2D",
              "#84FF63",
              "#6384FF",
              "#693707",
              "#63FF84"
            ]
          }
        ],
        options: {
          legend: {
            display: true,
            text: 'Hola Soy Goky'
          }
        }
      }
    });
  </script>
@endsection
