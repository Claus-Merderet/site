const form = document.getElementById('login_form');

const errorMessage = document.getElementById('error_message');
if (window.location.pathname === '/index.php') {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const response = await fetch('login.php', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            location.href = 'profile.php';
        } else {
            const errorText = await response.text();
            errorMessage.textContent = errorText;
            console.log('Ошибка сервера:', errorText);
        }
    });
}
if (window.location.pathname === '/profile.php') {

    const popup = document.getElementById('popup');
    if(popup){
        popup.classList.add('show');

        // Закрытие попап окна
        const closeBtn = document.getElementById('popup_close');
        closeBtn.addEventListener('click', () => {
            popup.classList.remove('show');
        });

        // Автоматическое скрытие попап окна через 10 секунд
        setTimeout(() => {
            popup.classList.remove('show');
        }, 10000);
    }
}

