<?php

namespace App\Livewire\Home;

use Livewire\Component;

class TutorialesLive extends Component
{
    public $videoSeleccionado = null;

    protected $videos = [
        [
            'id' => 'envio',
            'title' => 'Iniciando el sistema',
            'description' => 'Guía paso a paso para iniciar el sistema y actualizar tus credenciales.',
            'duration' => '4:30 min',
            'thumbnail' => 'img/tutoriales/inicio.jpg',
            'videoUrl' => 'tutoriales/inicio.mkv'
        ],
        [
            'id' => 'Caja',
            'title' => 'Seguimiento de Paquetes',
            'description' => 'Aprende a rastrear tus envíos en tiempo real.',
            'duration' => '3:15 min',
            'thumbnail' => 'img/tutoriales/inicio.jpg',
            'videoUrl' => 'tutoriales/inicio.mkv'
        ],
        [
            'id' => 'embalaje',
            'title' => 'Embalaje Correcto',
            'description' => 'Tips para embalar correctamente tus paquetes.',
            'duration' => '5:00 min',
            'thumbnail' => 'img/tutoriales/inicio.jpg',
            'videoUrl' => 'tutoriales/inicio.mkv'
        ]
    ];

    public function mount()
    {
        foreach ($this->videos as &$video) {
            $video['thumbnail'] = asset($video['thumbnail']);
            $video['videoUrl'] = asset($video['videoUrl']);
        }
    }

    public function seleccionarVideo($id)
    {
        $this->videoSeleccionado = collect($this->videos)->firstWhere('id', $id);
    }

    public function cerrarVideo()
    {
        $this->videoSeleccionado = null;
    }

    public function render()
    {
        return view('livewire.home.tutoriales-live', [
            'videos' => $this->videos
        ]);
    }
}
