<script>
    $(document).ready(function() {

        let tablaMisNotas = $('#tablaMisNotas').DataTable({
            ajax: {
                url: "{{ route('student.notas') }}",
                dataSrc: "aaData"
            },
            columns: [{
                    data: 'curso',
                    title: 'Curso'
                },
                {
                    data: 'nota',
                    className: 'text-center',
                    render: function(data) {

                        if (data === null || data === undefined) {
                            return '<span class="text-gray-400">Sin nota</span>';
                        }

                        let color = data >= 7 ? 'text-green-600' : 'text-red-500';

                        return `<span class="${color} font-bold">${data}</span>`;
                    }
                }
            ],
            dom: '<"flex justify-between mb-2"f>rt<"flex justify-between mt-2"p>',
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

    });
</script>
