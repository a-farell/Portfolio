(() => {
    const dialog = document.querySelector('[data-delete-dialog]');

    if (!(dialog instanceof HTMLDialogElement) || typeof dialog.showModal !== 'function') {
        return;
    }

    const label = dialog.querySelector('[data-delete-label]');
    const confirmButton = dialog.querySelector('[data-confirm-delete-action]');
    const cancelButton = dialog.querySelector('[data-cancel-delete]');
    let pendingForm = null;

    document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
        form.removeAttribute('onsubmit');
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            pendingForm = form;
            label.textContent = form.dataset.deleteLabel || 'data ini';
            dialog.showModal();
        });
    });

    confirmButton.addEventListener('click', () => {
        const form = pendingForm;
        pendingForm = null;
        dialog.close();
        if (form) {
            form.submit();
        }
    });

    cancelButton.addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', () => {
        pendingForm = null;
    });
})();
