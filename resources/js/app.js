const animatedItems = document.querySelectorAll('[data-animate]');

if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.14,
        rootMargin: '0px 0px -40px 0px',
    });

    animatedItems.forEach((item, index) => {
        item.style.transitionDelay = `${Math.min(index * 55, 360)}ms`;
        observer.observe(item);
    });
} else {
    animatedItems.forEach((item) => item.classList.add('is-visible'));
}

const infaqModal = document.querySelector('[data-infaq-modal]');
const openInfaq = document.querySelector('[data-open-infaq]');
const closeInfaqButtons = document.querySelectorAll('[data-close-infaq]');

if (infaqModal && openInfaq) {
    openInfaq.addEventListener('click', () => {
        infaqModal.hidden = false;
        document.body.classList.add('modal-open');
    });

    closeInfaqButtons.forEach((button) => {
        button.addEventListener('click', () => {
            infaqModal.hidden = true;
            document.body.classList.remove('modal-open');
        });
    });
}

document.querySelectorAll('[data-schedule-editor]').forEach((editor) => {
    const grid = editor.querySelector('[data-schedule-grid]');
    const input = editor.querySelector('[data-schedule-input]');
    let data = [];

    try {
        data = JSON.parse(input.value || '[]');
    } catch {
        data = [];
    }

    if (!Array.isArray(data) || data.length === 0) {
        data = [['Hari', 'Waktu', 'Kegiatan']];
    }

    const normalize = () => {
        const width = Math.max(...data.map((row) => row.length), 1);
        data = data.map((row) => {
            const next = [...row];
            while (next.length < width) next.push('');
            return next;
        });
    };

    const sync = () => {
        normalize();
        input.value = JSON.stringify(data);
        grid.style.gridTemplateColumns = `repeat(${data[0].length}, minmax(150px, 1fr))`;
        grid.innerHTML = '';
        data.forEach((row, rowIndex) => {
            row.forEach((cell, cellIndex) => {
                const field = document.createElement('input');
                field.value = cell || '';
                field.placeholder = rowIndex === 0 ? `Judul kolom ${cellIndex + 1}` : `Isi ${rowIndex + 1}.${cellIndex + 1}`;
                field.className = rowIndex === 0 ? 'schedule-head-cell' : '';
                field.addEventListener('input', () => {
                    data[rowIndex][cellIndex] = field.value;
                    input.value = JSON.stringify(data);
                });
                grid.appendChild(field);
            });
        });
    };

    editor.querySelector('[data-add-row]')?.addEventListener('click', () => {
        data.push(Array(data[0].length).fill(''));
        sync();
    });

    editor.querySelector('[data-add-col]')?.addEventListener('click', () => {
        data = data.map((row) => [...row, '']);
        sync();
    });

    editor.querySelector('[data-remove-row]')?.addEventListener('click', () => {
        if (data.length > 1) data.pop();
        sync();
    });

    editor.querySelector('[data-remove-col]')?.addEventListener('click', () => {
        if (data[0].length > 1) data = data.map((row) => row.slice(0, -1));
        sync();
    });

    sync();
});
