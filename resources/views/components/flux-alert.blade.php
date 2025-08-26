<div
    x-data="{ show: false, message: '', type: 'success' }"
    x-show="show"
    x-transition
    x-init="
        window.addEventListener('flux-alert', e => {
            message = e.detail.message;
            type = e.detail.type;
            show = true;
            setTimeout(() => show = false, 3000);
        });
    "
    :class="{
        'bg-green-100 text-green-800 border-green-400': type === 'success',
        'bg-red-600 text-white border-red-800': type === 'error',
        'bg-yellow-100 text-yellow-800 border-yellow-400': type === 'warning'
    }"
    class="fixed top-5 right-5 z-50 border px-4 py-2 rounded shadow-lg text-sm"
>
    <span x-text="message"></span>
</div>
