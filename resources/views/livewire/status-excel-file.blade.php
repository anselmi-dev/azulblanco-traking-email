<x-progress.container>
    <x-progress.item :first="true" title="Pendiente para procesar" :current="$file->is_pending" :check="!$file->is_pending">
        <x-slot name="description">
            Aún no se ha iniciado el proceso de lectura.
        </x-slot>
    </x-progress.item>
    <x-progress.item :first="true" title="Inicio del Proceso" :current="$file->is_starting" :check="$file->is_after_starting">
        <x-slot name="description">
            Comenzando la lectura del documento.
        </x-slot>
    </x-progress.item>
    <x-progress.item title="Revisión de los Registros" :current="$file->is_reading" :check="$file->is_after_reading">
        <x-slot name="description">
            Se procederá a revisar qué registros del documento aún no han sido procesados.
        </x-slot>
    </x-progress.item>
    <x-progress.item title="Envío de Correos" :current="$file->is_sending" :check="$file->is_after_sending">
        <x-slot name="description">
            Enviando los correos electrónicos pendientes.
        </x-slot>
    </x-progress.item>
    <x-progress.item :last="true" title="Finalización" :check="$file->is_processed">
        <x-slot name="description">
            Todos los registros no procesados han sido revisados y los correos electrónicos correspondientes han sido enviados.
        </x-slot>
    </x-progress.item>

</x-progress.container>

@if(!$file->is_done)
    @script
        <script type="text/javascript" >
            let intervaloID = setInterval(function() {
                console.log('refresh');
                @this.refresh();
            }, 2500);

            document.addEventListener('livewire:navigating', () => {
                console.log('livewire:navigating');
                clearInterval(intervaloID);
            })

            document.addEventListener('livewire:initialized', () => {
                console.log('livewire:initialized');
                Livewire.on('status-excel-done', (event) => {
                    console.log('status-excel-done');
                    clearInterval(intervaloID);
                });
            })
        </script>
    @endscript
@endif
