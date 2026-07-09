<?php
namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Note;
use App\Services\SunatServiceGlobal;
use App\Traits\UtilsTrait;
use Greenter\Report\XmlUtils;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class NoteLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    use UtilsTrait;
    public string $title = 'NOTAS DE CREDITO';
    public string $sub_title = 'Modulo de notas de credito';
    public int $perPage = 10;
    public $infoModal = false;
    public $filtroFechaInicio;
    public $filtroFechaFin;
    public $search;

    public $cdr_code;
    public $cdr_description;
    public $cdr_note;
    public $errorCode;
    public $errorMessage;

    public function mount(): void
    {
        $this->filtroFechaInicio = $this->filterDateStart();
        $this->filtroFechaFin = $this->filterDateEnd();
    }

    public function updatedFiltroFechaInicio(): void
    {
        $this->ensureDateRangeOrder($this->filtroFechaInicio, $this->filtroFechaFin);
    }

    public function updatedFiltroFechaFin(): void
    {
        $this->ensureDateRangeOrder($this->filtroFechaInicio, $this->filtroFechaFin);
    }

    public function render()
    {
        $notes = Note::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('serie', 'like', '%' . $this->search . '%')
                        ->orWhere('correlativo', 'like', '%' . $this->search . '%')
                        ->orWhere('numDocfectado', 'like', '%' . $this->search . '%')
                        ->orWhereHas('client', function ($query) {
                            $query->where('code', 'like', '%' . $this->search . '%')
                                ->orWhere('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filtroFechaInicio && $this->filtroFechaFin, function ($query) {
                return $query->whereBetween('fechaEmision', [
                    $this->parseFilterDateStart($this->filtroFechaInicio),
                    $this->parseFilterDateEnd($this->filtroFechaFin),
                ]);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.facturacion.note-live', compact('notes'));
    }
    public function xmlGenerate(Note $note)
    {
        $company = $note->company;
        $sunat = new SunatServiceGlobal();
        $see = $sunat->getSee($company);
        $invoce = $sunat->getNote($note);
        $xml = $see->getXmlSigned($invoce);
        $hash = (new XmlUtils())->getHashSign($xml);
        $note->xml_hash = $hash;
        $note->xml_path = 'xml/' . $note->company->ruc . '-' . $note->tipoDoc . '-' . $note->serie . '-' . $note->correlativo . '.xml';
        $note->save();
        Storage::disk('public')->put($note->xml_path, $xml);
    }
    public function xmlDownload(Note $note)
    {
        if (Storage::exists($note->xml_path)) {
            return response()->download(storage_path('app/public/' . $note->xml_path));
        }
    }
    public function sendXmlFile(Note $note)
    {
        $company = $note->company;
        $sunat = new SunatServiceGlobal();
        $see = $sunat->getSee($company);
        $xml = Storage::disk('public')->get($note->xml_path);
        $result = $see->sendXmlFile($xml);
        $response = $sunat->sunatResponse($result);
        if ($response['success']) {
            $note->cdr_description = $response['cdrResponse']['description'];
            $note->cdr_code = $response['cdrResponse']['code'];
            $note->cdr_note = $response['cdrResponse']['notes'];
            $note->cdr_path = 'cdr/' . 'R-' . $note->company->ruc . '-' . $note->tipoDoc . '-' . $note->serie . '-' . $note->correlativo . '.zip';
            $note->save();
            Storage::disk('public')->put($note->cdr_path, $response['cdrResponse']['cdrZip']);
            $this->toast('success', 'Comprobante enviado a la sunat');
        } else {
            $note->errorCode = $response['error']['code'];
            $note->errorMessage = $response['error']['message'];
            $note->save();
            $this->toast('error', 'Error al enviar el comprobante a la sunat');
        }
    }
    public function downloadCdrFile(Note $note)
    {
        if (Storage::exists($note->cdr_path)) {
            return response()->download(storage_path('app/public/' . $note->cdr_path));
        }
    }
    public function statusNote($note) {
        $note = Note::find($note);
        $this->cdr_code = $note->cdr_code;
        $this->cdr_description = $note->cdr_description;
        $this->cdr_note = $note->cdr_note;
        $this->errorCode = $note->errorCode;
        $this->errorMessage = $note->errorMessage;
        $this->infoModal = true;
    }
}
