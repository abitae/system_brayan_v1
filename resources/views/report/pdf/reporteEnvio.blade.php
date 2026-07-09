@php
  use Carbon\Carbon;
  function dateFormat($date) {
    return Carbon::parse($date)->format('Y-m-d');
  }
@endphp
@extends("layouts.adminLayout.admin_design")
@section("title", "Reporte envio")

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
  <h5 class="user-select-none"><i class="far fa-file-alt"></i> Reporte de Envíos</h5>
  <div class="container">
    <div class="mb-4 shadow-sm card">
      <div class="py-3 card-header">
        <form action="{{route("reporteEnvio")}}" method="get" class="row justify-content-between">
          <div class="col-12">
            <div class="row align-items-end">
              <div class="form-group col-12 col-md-6 col-lg-3">
                <label for="branch-office" class="font-weight-bold">Sucursal</label>
                <select name="id_sucursal" id="branch-office" class="form-control">
                  @foreach($sucursales as $sucursal)
                    <option value="{{$sucursal->id_sucursal}}" {{ request('id_sucursal') == $sucursal->id_sucursal ? 'selected' : '' }}>{{ $sucursal->nombre }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-12 col-md-6 col-lg-3">
                <label for="date-start" class="font-weight-bold">Fecha Inicio</label>
                <input type="date" class="form-control" id="date-start" name="dateStart" value="{{ dateFormat($dateStart) }}">
              </div>
              <div class="form-group col-12 col-md-6 col-lg-3">
                <label for="date-end" class="font-weight-bold">Fecha Fin</label>
                <input type="date" class="form-control" id="date-end" name="dateEnd" value="{{ dateFormat($dateEnd) }}">
              </div>
              <div class="form-group col-12 col-md-6 col-lg-3">
                <button type="submit" class="btn btn-block btn-dark"><i class="fas fa-search"></i> Filtrar</button>
              </div>
            </div>
          </div>
        </form>

        @if (in_array(true,$hasContent))
        <div class="row">
          <div class="col-12 col-md-6 col-lg-3">
            <button type="button" onclick="generateReportExcel()" class="btn btn-block color-excel"><i class="far fa-file-excel"></i> Generar Excel</button>
          </div>
        </div>
        @endif
      </div>
      <div class="card-body">
        @if (in_array(true,$hasContent))
          <canvas id="oilChart"></canvas>
        @else
          <div class="row">
            <div class="py-3 text-center col-sm-12 text-success user-select-none">
              <h3><i class="far fa-smile-beam"></i> Sin resultados <i class="far fa-smile-beam"></i></h3>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
@section("scripts")
  <script>
    const $dateStart = document.querySelector("#date-start")
    const $dateEnd = document.querySelector("#date-end")
    function generateReportExcel() {
      const params = new URLSearchParams({
        dateStart: $dateStart.value,
        dateEnd: $dateEnd.value
      }).toString();
      window.location.href = `excelEnviosPersonlizado?${params}`
    }

    const COLORS = ["#FF6384", "#63FF84", "#84FF63", "#6384FF", "#693707", "#2D2D2D"];

    var oilCanvas = document.getElementById("oilChart");
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 13;
    Chart.defaults.global.legend = false;
    var pieChart = new Chart(oilCanvas, {
      type: 'bar',
      data: {
        labels: [
          @for($i = 0; $i < count($total_envios); $i++)
          `{{$total_envios[$i]['nombre']}} ({{ $total_envios[$i]['total'] }})`,
          @endfor
        ],
        datasets: [{
          data: [
            @for($i = 0; $i < count($total_envios); $i++)
              "{{$total_envios[$i]["total"]}}" ,
            @endfor
          ],
          backgroundColor: COLORS,
        }],
        options: {
          scale: {
            y: {
              beginAtZero: true,
            }
          }
        }
      },
    });
  </script>
  {{-- <script>
    const COLORS = [
      "#FF6384",
      "#63FF84",
      "#84FF63",
      "#6384FF",
      "#693707",
      "#2D2D2D"
    ];

    var oilCanvas = document.getElementById("oilChart");
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 13;

    var pieChart = new Chart(oilCanvas, {
      type: 'bar',
      data: {
        labels: [
          @for($i = 0; $i < count($total_envios); $i++)
          `{{$total_envios[$i]['nombre']}} ({{ $total_envios[$i]['total'] }})`,
          @endfor
        ],
        datasets: [{
          data: [
            @for($i = 0; $i < count($total_envios); $i++)
              "{{$total_envios[$i]["total"]}}" ,
            @endfor
          ],
          backgroundColor: COLORS,
        }],
        options: {
          scale: {
            y: {
              beginAtZero: true,
            }
          }
        }
      },
    });
  </script> --}}
@endsection
