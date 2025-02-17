{{-- resources/views/home_scripts.blade.php --}}
<script>
$(document).ready(function(){
    $('.btn-fav').click(function(){
        let btn = $(this);
        let data = {
            cocktail_id_api: btn.data('cocktail_id_api'),
            name: btn.data('name'),
            thumbnail: btn.data('thumbnail'),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "{{ route('favorite.store') }}",
            method: 'POST',
            data: data,
            success: function(response){
                Swal.fire({
                    icon: 'success',
                    title: response.success,
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error || 'Ocurrió un error.'
                });
            }
        });
    });
});
</script>
