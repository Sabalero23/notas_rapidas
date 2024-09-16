document.addEventListener('DOMContentLoaded', () => {
    const codeDigits = document.querySelectorAll('.code-digit');
    const keypad = document.getElementById('keypad');
    const message = document.getElementById('message');
    let code = '';
    const MAX_CODE_LENGTH = 6;

    // Configuración de partículas
    particlesJS('particles', {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: '#ffffff' },
            shape: { type: 'circle' },
            opacity: { value: 0.5, random: false },
            size: { value: 3, random: true },
            line_linked: { enable: true, distance: 150, color: '#ffffff', opacity: 0.4, width: 1 },
            move: { enable: true, speed: 6, direction: 'none', random: false, straight: false, out_mode: 'out', bounce: false }
        },
        interactivity: {
            detect_on: 'canvas',
            events: { onhover: { enable: true, mode: 'repulse' }, onclick: { enable: true, mode: 'push' }, resize: true },
            modes: { repulse: { distance: 100, duration: 0.4 }, push: { particles_nb: 4 } }
        },
        retina_detect: true
    });

    keypad.addEventListener('click', handleKeypadClick);
    document.addEventListener('keydown', handleKeyboardInput);

    function handleKeypadClick(e) {
        const key = e.target.closest('.keypad-btn');
        if (!key) return;

        const keyValue = key.dataset.key;
        handleInput(keyValue);
    }

    function handleKeyboardInput(e) {
        const key = e.key;
        if (/^[0-9]$/.test(key)) {
            handleInput(key);
        } else if (key === 'Backspace') {
            handleInput('clear');
        } else if (key === 'Enter') {
            handleInput('enter');
        }
    }

    function handleInput(key) {
        switch(key) {
            case 'clear':
                code = code.slice(0, -1);
                break;
            case 'enter':
                if (code.length === MAX_CODE_LENGTH) {
                    submitCode();
                } else {
                    showMessage('El código debe tener 6 dígitos');
                }
                return;
            default:
                if (code.length < MAX_CODE_LENGTH) {
                    code += key;
                }
        }
        updateDisplay();
    }

    function updateDisplay() {
        codeDigits.forEach((digit, index) => {
            if (index < code.length) {
                digit.classList.add('active');
            } else {
                digit.classList.remove('active');
            }
        });
        message.textContent = '';
    }

    function showMessage(msg) {
        message.textContent = msg;
    }

    function submitCode() {
        showMessage('Verificando...');
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `code=${code}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showMessage('Acceso concedido');
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1000);
            } else {
                showMessage(data.message || 'Código incorrecto');
                code = '';
                updateDisplay();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error de conexión. Por favor, intente de nuevo.');
            code = '';
            updateDisplay();
        });
    }

    // Inicializar la pantalla
    updateDisplay();
});