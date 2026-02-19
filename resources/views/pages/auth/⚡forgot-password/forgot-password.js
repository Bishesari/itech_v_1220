let interval;
let timer;

function clearTimerInterval() {
    if (interval) {
        clearInterval(interval);
        interval = null;
    }
}

Livewire.on('set_timer', () => {
    // read timer from Livewire
    timer = Number($wire.get('timer')) || 0;

    clearTimerInterval();

    if (timer <= 0) {
        document.getElementById('timer') && (document.getElementById('timer').innerHTML = '0');
        return;
    }

    interval = setInterval(() => {
        timer--;
        const el = document.getElementById('timer');
        if (el) el.innerHTML = timer;
        if (timer <= 0) {
            clearTimerInterval();
            $wire.set('timer', 0);
        }
    }, 1000);
});

Livewire.on('stop_timer', () => {
    clearTimerInterval();
    $wire.set('timer', 0);
});

// If modal closed unexpectedly, ensure cleanup (Flux modal event)
document.addEventListener('flux:modal:close', (e) => {
    // depending on flux implementation event name may differ — this is a safeguard
    clearTimerInterval();
    $wire.set('timer', 0);
});

// کد برای فوکوس
Livewire.on('focus-otp', () => {
    // یک تاخیر کوتاه (مثلا ۳۰۰ میلی‌ثانیه) می‌دهیم تا مدال کامل باز شود
    setTimeout(() => {
        // پیدا کردن کانتینر اصلی
        const wrapper = document.getElementById('otp-input-wrapper');
        if (wrapper) {
            // پیدا کردن اولین اینپوت داخل کانتینر
            const firstInput = wrapper.querySelector('input');
            if (firstInput) {
                firstInput.focus();
            }
        }
    }, 300);
});
