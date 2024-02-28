function showCustomToast(type, content) {
    const toastElement = document.createElement('div');
    let typeDefinied = ['success', 'danger', 'warning', 'info'].includes(type) ? type : 'success';

    toastElement.innerHTML = `
        <div class="alert alert-custom alert-indicator-left indicator-${typeDefinied} position-relative" role="alert">
            <div class="position-absolute me-3" style="right:0px">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert-content">
                <span class="alert-title">${content?.title}</span>
                <span class="alert-text">${content?.message}</span>
            </div>
        </div>
    `;

    const toast = Toastify({
        node: toastElement,
        duration: content.time || 3000,
        gravity: content.gravity || 'top',
        position: content.position || 'right',
        className: 'custom-toast'
    });

    const hideToast = () => toast.hideToast();

    toastElement.addEventListener('click', hideToast);
    toastElement.querySelector('.btn-close').addEventListener('click', hideToast);

    toast.showToast();
}
