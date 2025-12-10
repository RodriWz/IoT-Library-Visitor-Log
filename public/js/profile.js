document.addEventListener('DOMContentLoaded', function() {
            // Function to update sidebar profile image
            function updateSidebarProfile(imageUrl) {
                const sidebarImg = document.getElementById('sidebarProfileImg');
                if (sidebarImg) {
                    const timestamp = new Date().getTime();
                    const newSrc = imageUrl + '?t=' + timestamp;
                    
                    sidebarImg.src = newSrc;
                    sidebarImg.classList.add('sidebar-profile-updated');
                    
                    setTimeout(() => {
                        sidebarImg.classList.remove('sidebar-profile-updated');
                    }, 600);
                }
            }

            // Auto upload functionality for profile image
            const fotoInput = document.getElementById('foto-input');
            if (fotoInput) {
                fotoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Validate file
                    if (!file.type.startsWith('image/')) {
                        alert('Harap pilih file gambar yang valid');
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file maksimal 5MB');
                        return;
                    }

                    // Preview image
                    const previewImage = document.getElementById('preview-image');
                    if (previewImage) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.classList.add('uploading');
                        };
                        reader.readAsDataURL(file);
                    }

                    // Auto upload
                    const formData = new FormData();
                    formData.append('foto', file);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    formData.append('auto_upload', 'true');

                    fetch('/pengaturan/update-profile', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update sidebar profile
                            updateSidebarProfile(data.foto_url);
                            
                            // Show success message
                            showAlert('Foto profil berhasil diperbarui!', 'success');
                            
                            // Store in localStorage for cross-tab sync
                            localStorage.setItem('profileImageLastUpdate', Date.now().toString());
                            localStorage.setItem('profileImageUrl', data.foto_url);
                        } else {
                            throw new Error(data.message || 'Gagal mengupload foto');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert(error.message || 'Terjadi kesalahan saat mengupload foto', 'error');
                    })
                    .finally(() => {
                        // Remove loading state
                        if (previewImage) {
                            previewImage.classList.remove('uploading');
                        }
                    });
                });
            }

            // Function to show alert messages
            function showAlert(message, type) {
                // Remove existing alerts
                const existingAlerts = document.querySelectorAll('.alert');
                existingAlerts.forEach(alert => alert.remove());

                // Create new alert
                const alert = document.createElement('div');
                alert.className = `alert alert-${type}`;
                alert.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 18px;">${type === 'success' ? '✓' : '✗'}</span>
                        <span>${message}</span>
                    </div>
                `;

                // Insert alert
                const content = document.querySelector('.form-container') || document.querySelector('.main-content');
                if (content) {
                    content.insertBefore(alert, content.firstChild);
                }

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 5000);
            }

            // Listen for profile updates from other tabs
            window.addEventListener('storage', function(e) {
                if (e.key === 'profileImageLastUpdate') {
                    const newUrl = localStorage.getItem('profileImageUrl');
                    if (newUrl) {
                        updateSidebarProfile(newUrl);
                    }
                }
            });

            // Check for recent profile updates on page load
            const lastUpdate = localStorage.getItem('profileImageLastUpdate');
            const storedUrl = localStorage.getItem('profileImageUrl');
            
            if (lastUpdate && storedUrl) {
                const oneHourAgo = Date.now() - (60 * 60 * 1000);
                if (parseInt(lastUpdate) > oneHourAgo) {
                    updateSidebarProfile(storedUrl);
                }
            }

            // Global event listener for profile updates
            document.addEventListener('profileImageUpdated', function(e) {
                updateSidebarProfile(e.detail.fotoUrl);
            });
        });