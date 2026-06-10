{{-- SweetAlert (SweetAlert2) reusable component --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(() => {
    if (!window.Swal) return;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (t) => {
            t.onmouseenter = Swal.stopTimer;
            t.onmouseleave = Swal.resumeTimer;
        }
    });

    // Public helpers
    window.$swal = {
        toast: (opts = {}) => Toast.fire({
            icon: opts.icon || 'info',
            title: opts.title || opts.text || ''
        }),
        fire: (opts = {}) => Swal.fire(opts),
        confirm: (opts = {}) => Swal.fire({
            title: opts.title || 'Anda yakin?',
            text: opts.text || 'Tindakan ini tidak dapat dibatalkan.',
            icon: opts.icon || 'warning',
            showCancelButton: true,
            confirmButtonText: opts.confirmButtonText || 'Ya, lanjutkan',
            cancelButtonText: opts.cancelButtonText || 'Batal',
            reverseButtons: true,
            focusCancel: true,
            confirmButtonColor: '#f0b100', // primary-500
            cancelButtonColor: '#e11d48'   // rose-600
        })
    };

    // Custom events for ad-hoc usage
    window.addEventListener('swal:toast', (e) => {
        const d = e.detail || {};
        Toast.fire({ icon: d.icon || 'info', title: d.title || d.text || '' });
    });
    window.addEventListener('swal:confirm', (e) => {
        const d = e.detail || {};
        window.$swal.confirm(d).then((result) => {
            if (typeof d.onResult === 'function') d.onResult(result);
            if (result.isConfirmed && d.confirmEvent) {
                window.dispatchEvent(new CustomEvent(d.confirmEvent, { detail: result }));
            }
        });
    });
})();
</script>

@php
    $flash = [];
    foreach (['success', 'error', 'warning', 'info', 'status'] as $t) {
        if (session($t)) { $flash[] = ['type' => $t, 'msg' => session($t)]; }
    }
    if ($errors->any()) {
        $flash[] = ['type' => 'error', 'msg' => $errors->first()];
    }
@endphp
@if (!empty($flash))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const items = @json($flash);
        const mapIcon = { success: 'success', error: 'error', warning: 'warning', info: 'info', status: 'success' };
        items.forEach(it => { if (window.$swal) $swal.toast({ icon: mapIcon[it.type] || 'info', title: it.msg }); });
    });
</script>
@endif
