/**
 * Gerenciador de Anexos - Versão Profissional com SweetAlert2
 */
function initAttachmentManager(config) {
    const { inputSelector, listSelector, csrfToken } = config;

    // --- LÓGICA DE UPLOAD ---
    $(document).off('change', inputSelector).on('change', inputSelector, function () {
        const file = this.files[0];
        if (!file) return;

        const input = $(this);
        const ownerId = parseInt(input.data('owner-id'));
        const ownerType = input.data('owner-type');
        const url = input.data('url');

        if (!ownerId || ownerId <= 0) {
            Swal.fire('Atenção', 'Salve o registro antes de adicionar anexos.', 'warning');
            input.val('');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('owner_id', ownerId);
        formData.append('owner_type', ownerType);
        formData.append('_token', csrfToken);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: 'Enviando arquivo...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (res) {
                Swal.close();
                renderAttachmentItem(listSelector, res.data);

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Arquivo anexado.',
                    timer: 1500,
                    showConfirmButton: false
                });

                input.val('').next('.custom-file-label').html('Selecionar arquivo...');
            },
            error: function (err) {
                Swal.close();
                console.error(err.responseJSON);
                let msg = err.responseJSON?.message || 'Erro ao subir arquivo.';
                Swal.fire('Erro!', msg, 'error');
                input.val('').next('.custom-file-label').html('Selecionar arquivo...');
            }
        });
    });

    // --- LÓGICA DE DELETE (Delegada) ---
    $(document).off('click', '.btn-delete-file').on('click', '.btn-delete-file', function () {
        const btn = $(this);
        const id = btn.data('id');
        const container = $(`#file-${id}`);

        Swal.fire({
            title: 'Remover anexo?',
            text: "Esta ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/attachments/${id}`, // Verifique se sua rota é exatamente esta
                    type: 'DELETE',
                    data: { _token: csrfToken },
                    success: function () {
                        container.fadeOut(300, function () {
                            $(this).remove();
                            if ($(listSelector).children().length === 0) {
                                $(listSelector).append('<div id="no-attachments-message" class="text-center py-3"><p class="text-muted small mb-0">Nenhum anexo disponível.</p></div>');
                            }
                        });
                        Swal.fire('Deletado!', 'O arquivo foi removido.', 'success');
                    },
                    error: function () {
                        Swal.fire('Erro!', 'Não foi possível excluir o arquivo.', 'error');
                    }
                });
            }
        });
    });
}

function renderAttachmentItem(listSelector, data) {
    $('#no-attachments-message').remove();
    const html = `
        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2" id="file-${data.id}" style="display:none;">
            <div class="d-flex align-items-center">
                <i class="fas fa-file-alt text-primary mr-3 fa-lg"></i>
                <div class="d-flex flex-column">
                    <span class="font-weight-bold text-dark" style="font-size: 0.85rem;">${data.name}</span>
                    <small class="text-muted" style="font-size: 0.7rem;">Agora mesmo</small>
                </div>
            </div>
            <div class="btn-group">
                <a href="/storage/${data.path}" download="${data.name}" class="btn btn-sm btn-light border shadow-sm mr-1">
                    <i class="fas fa-download text-primary"></i>
                </a>
                <button type="button" class="btn btn-sm btn-light border shadow-sm btn-delete-file" data-id="${data.id}">
                    <i class="fas fa-trash text-danger"></i>
                </button>
            </div>
        </div>`;
    $(html).appendTo(listSelector).fadeIn();
}