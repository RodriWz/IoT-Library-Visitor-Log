let timeLeft = 60;
const resendBtn = document.getElementById('resendBtn');
const timer = document.getElementById('timer');

if (resendBtn && timer) {
    const countdown = setInterval(() => {
        timeLeft--;
        timer.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            resendBtn.disabled = false;
            resendBtn.textContent = 'Kirim ulang OTP';
        }
    }, 1000);
}
