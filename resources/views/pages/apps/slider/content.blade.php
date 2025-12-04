<x-default-layout>

    @section('title') Product Compare @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('compare') }}
    @endsection


    <livewire:content.banner-conter></livewire:content.banner-conter>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                const modal = document.querySelector('.modal');
                modal.addEventListener('show.bs.modal', (e) => {
                    Livewire.emit('open_add_modal');
                });

                Livewire.on('success', function () {
                    $('.modal').modal('hide');
                });
            });
        </script>
    @endpush

</x-default-layout>
