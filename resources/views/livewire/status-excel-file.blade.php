<x-progress.container>
    <x-progress.item :first="true" title="Inicio del Proceso" :current="$file->is_pending" :check="!$file->is_pending">
        <x-slot name="description">
            Comenzando la lectura del documento
        </x-slot>
    </x-progress.item>
    <x-progress.item title="Revisión de los Registros" :current="$file->is_reading" :check="$file->is_sent">
        <x-slot name="description">
            Se procederá a revisar qué registros del documento aún no han sido procesados.
        </x-slot>
    </x-progress.item>
    <x-progress.item title="Envío de Correos" :current="$file->is_sending" :check="$file->is_processed">
        <x-slot name="description">
            Enviando los correos electrónicos pendientes.
        </x-slot>
    </x-progress.item>
    <x-progress.item :last="true" title="Finalización" :check="$file->is_processed">
        <x-slot name="description">
            Todos los registros no procesados han sido revisados y los correos electrónicos correspondientes han sido
            enviados.
        </x-slot>
    </x-progress.item>
</x-progress.container>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('livewire:init', () => {
            const intervaloID = setInterval(function() {
                console.log('refresh');
                @this.refresh()
            }, 2500);

            Livewire.on('status-excel-done', (event) => {
                console.log('status-excel-done');
                clearInterval(intervaloID);
            });
        });
    </script>
@endpush
