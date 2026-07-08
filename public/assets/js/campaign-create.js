
    const gambarInput = document.getElementById('gambar');
    const previewGallery = document.getElementById('previewGallery');
    const uploadBox = document.getElementById('uploadBox');

    if (gambarInput && previewGallery) {
        gambarInput.addEventListener('change', function () {
            previewGallery.innerHTML = '';

            const files = Array.from(this.files);

            if (files.length === 0) {
                previewGallery.style.display = 'none';
                return;
            }

            previewGallery.style.display = 'grid';
            previewGallery.style.gridTemplateColumns = 'repeat(auto-fill, minmax(90px, 1fr))';
            previewGallery.style.gap = '10px';

            files.forEach(function (file, index) {
                if (!file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    const item = document.createElement('div');
                    item.style.position = 'relative';
                    item.style.borderRadius = '12px';
                    item.style.overflow = 'hidden';
                    item.style.border = '1px solid #e5e7eb';
                    item.style.background = '#f8fafc';

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.alt = 'Preview Gambar Campaign';
                    img.style.width = '100%';
                    img.style.height = '90px';
                    img.style.objectFit = 'cover';
                    img.style.display = 'block';

                    item.appendChild(img);

                    if (index === 0) {
                        const badge = document.createElement('span');
                        badge.innerText = 'Cover';
                        badge.style.position = 'absolute';
                        badge.style.top = '6px';
                        badge.style.left = '6px';
                        badge.style.fontSize = '11px';
                        badge.style.padding = '3px 7px';
                        badge.style.borderRadius = '999px';
                        badge.style.background = '#0d6efd';
                        badge.style.color = '#fff';
                        badge.style.fontWeight = '600';

                        item.appendChild(badge);
                    }

                    previewGallery.appendChild(item);
                };

                reader.readAsDataURL(file);
            });
        });
    }

    if (uploadBox && gambarInput) {
        uploadBox.addEventListener('dragover', function (event) {
            event.preventDefault();
            uploadBox.classList.add('drag-over');
        });

        uploadBox.addEventListener('dragleave', function () {
            uploadBox.classList.remove('drag-over');
        });

        uploadBox.addEventListener('drop', function (event) {
            event.preventDefault();
            uploadBox.classList.remove('drag-over');

            if (event.dataTransfer.files.length > 0) {
                gambarInput.files = event.dataTransfer.files;

                const changeEvent = new Event('change');
                gambarInput.dispatchEvent(changeEvent);
            }
        });
    }

document.addEventListener('DOMContentLoaded', function () {
    const mulai = document.getElementById('tanggal_mulai');
    const selesai = document.getElementById('tanggal_berakhir');
    const form = document.getElementById('campaignForm');

    if (mulai && selesai) {
        mulai.addEventListener('change', function () {
            selesai.min = mulai.value;

            if (selesai.value && selesai.value <= mulai.value) {
                selesai.value = '';
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            if (mulai.value && selesai.value && selesai.value <= mulai.value) {
                e.preventDefault();
                showCampaignPopup('error', 'Tanggal berakhir harus lebih besar dari tanggal mulai.');
            }
        });
    }
});

function showCampaignPopup(type, message) {
    const oldPopup = document.querySelector('.campaign-popup-overlay');
    if (oldPopup) oldPopup.remove();

    const overlay = document.createElement('div');
    overlay.className = 'campaign-popup-overlay';
    overlay.innerHTML = `
        <div class="campaign-popup-box">
            <div class="campaign-popup-icon ${type}">
                ${type === 'success' ? '✓' : '!' }
            </div>
            <h4>${type === 'success' ? 'Berhasil' : 'Gagal'}</h4>
            <p>${message}</p>
            <button type="button" onclick="this.closest('.campaign-popup-overlay').remove()">
                Oke
            </button>
        </div>
    `;
    document.body.appendChild(overlay);
}
