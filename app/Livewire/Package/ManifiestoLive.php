<?php
namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Models\Package\Manifiesto;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class ManifiestoLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;

    public string $title     = 'MANIFIESTOS';
    public string $sub_title = 'Historial de Manifiestos';
    public string $search    = '';
    public int $perPage      = 10;

    public function render()
    {
        
        $manifiestos = Manifiesto::where('sucursal_destino_id', Auth::user()->sucursal->id)
            ->OrWhere('sucursal_id', Auth::user()->sucursal->id)
            ->latest()->paginate($this->perPage);
        return view('livewire.package.manifiesto-live', compact('manifiestos'));
    }

    public function excelGenerate(Manifiesto $manifiesto)
    {
        $this->toast('success', 'Generando Excel', 'Manifiesto');
        return Excel::download(new ManifiestoExport(json_decode($manifiesto->ids)), 'manifiesto.xlsx');
    }
}
