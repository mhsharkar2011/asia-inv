// avatar-upload.js
function initializeAvatarUpload() {
    // Avatar Upload Elements
    const avatarInput = document.getElementById("avatarInput");
    const avatarPreview = document.getElementById("avatarPreview");
    const avatarImage = document.getElementById("avatarImage");
    const avatarRemove = document.getElementById("avatarRemove");
    const captureAvatarBtn = document.getElementById("captureAvatar");
    const cropArea = document.getElementById("cropArea");
    const cancelCropBtn = document.getElementById("cancelCrop");
    const applyCropBtn = document.getElementById("applyCrop");

    // Webcam Elements
    const webcamModal = document.getElementById("webcamModal");
    const webcamVideo = document.getElementById("webcamVideo");
    const webcamCanvas = document.getElementById("webcamCanvas");
    const capturePhotoBtn = document.getElementById("capturePhoto");
    const retakePhotoBtn = document.getElementById("retakePhoto");
    const usePhotoBtn = document.getElementById("usePhoto");

    let cropper = null;
    let webcamStream = null;
    let capturedImage = null;

    // Click on preview to trigger file input
    if (avatarPreview) {
        avatarPreview.addEventListener("click", () => {
            avatarInput.click();
        });
    }

    // Handle file selection
    if (avatarInput) {
        avatarInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    // 2MB limit
                    alert("File size must be less than 2MB");
                    return;
                }

                if (!file.type.match("image.*")) {
                    alert("Please select an image file");
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    showCropper(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Remove avatar
    if (avatarRemove) {
        avatarRemove.addEventListener("click", (e) => {
            e.stopPropagation();
            resetAvatar();
        });
    }

    // Show image cropper
    function showCropper(imageSrc) {
        // Hide preview and show cropper
        avatarImage.classList.add("hidden");
        avatarPreview.querySelector("div").classList.remove("hidden");
        cropArea.classList.remove("hidden");

        // Destroy existing cropper
        if (cropper) {
            cropper.destroy();
        }

        // Create new cropper
        const cropperElement = document.getElementById("imageCropper");
        cropperElement.innerHTML = `<img src="${imageSrc}" class="max-w-full max-h-full">`;
        const image = cropperElement.querySelector("img");

        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            guides: true,
            background: false,
        });
    }

    // Cancel cropping
    if (cancelCropBtn) {
        cancelCropBtn.addEventListener("click", () => {
            cropArea.classList.add("hidden");
            avatarInput.value = "";
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
    }

    // Apply cropping
    if (applyCropBtn) {
        applyCropBtn.addEventListener("click", () => {
            if (cropper) {
                const croppedCanvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });

                // Convert canvas to blob
                croppedCanvas.toBlob(
                    (blob) => {
                        // Create a new File from the blob
                        const croppedFile = new File([blob], "avatar.jpg", {
                            type: "image/jpeg",
                            lastModified: Date.now(),
                        });

                        // Create a DataTransfer object to set the file
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(croppedFile);
                        avatarInput.files = dataTransfer.files;

                        // Update preview
                        avatarImage.src = croppedCanvas.toDataURL("image/jpeg");
                        avatarImage.classList.remove("hidden");
                        avatarPreview
                            .querySelector("div")
                            .classList.add("hidden");
                        avatarRemove.classList.remove("hidden");

                        // Hide cropper
                        cropArea.classList.add("hidden");
                        cropper.destroy();
                        cropper = null;
                    },
                    "image/jpeg",
                    0.95
                );
            }
        });
    }

    // Reset avatar to default
    function resetAvatar() {
        avatarImage.classList.add("hidden");
        avatarPreview.querySelector("div").classList.remove("hidden");
        avatarRemove.classList.add("hidden");
        avatarInput.value = "";
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        cropArea.classList.add("hidden");
    }

    // Webcam capture functionality
    if (captureAvatarBtn) {
        captureAvatarBtn.addEventListener("click", () => {
            const webcamModalInstance = new bootstrap.Modal(webcamModal);
            webcamModalInstance.show();
            startWebcam();
        });
    }

    // Start webcam
    async function startWebcam() {
        try {
            webcamStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user" },
                audio: false,
            });
            webcamVideo.srcObject = webcamStream;

            // Reset buttons
            capturePhotoBtn.classList.remove("hidden");
            retakePhotoBtn.classList.add("hidden");
            usePhotoBtn.classList.add("hidden");
        } catch (err) {
            console.error("Error accessing webcam:", err);
            alert("Unable to access webcam. Please check permissions.");
        }
    }

    // Capture photo
    if (capturePhotoBtn) {
        capturePhotoBtn.addEventListener("click", () => {
            const context = webcamCanvas.getContext("2d");
            webcamCanvas.width = webcamVideo.videoWidth;
            webcamCanvas.height = webcamVideo.videoHeight;
            context.drawImage(
                webcamVideo,
                0,
                0,
                webcamCanvas.width,
                webcamCanvas.height
            );

            // Stop webcam stream
            if (webcamStream) {
                webcamStream.getTracks().forEach((track) => track.stop());
            }

            // Show captured image
            capturedImage = webcamCanvas.toDataURL("image/jpeg");
            webcamVideo.classList.add("hidden");
            webcamCanvas.classList.remove("hidden");

            // Toggle buttons
            capturePhotoBtn.classList.add("hidden");
            retakePhotoBtn.classList.remove("hidden");
            usePhotoBtn.classList.remove("hidden");
        });
    }

    // Retake photo
    if (retakePhotoBtn) {
        retakePhotoBtn.addEventListener("click", () => {
            webcamVideo.classList.remove("hidden");
            webcamCanvas.classList.add("hidden");
            startWebcam();
        });
    }

    // Use captured photo
    if (usePhotoBtn) {
        usePhotoBtn.addEventListener("click", () => {
            if (capturedImage) {
                // Close webcam modal
                const webcamModalInstance =
                    bootstrap.Modal.getInstance(webcamModal);
                webcamModalInstance.hide();

                // Show cropper with captured image
                setTimeout(() => {
                    showCropper(capturedImage);
                }, 300);
            }
        });
    }

    // Clean up webcam when modal closes
    if (webcamModal) {
        webcamModal.addEventListener("hidden.bs.modal", () => {
            if (webcamStream) {
                webcamStream.getTracks().forEach((track) => track.stop());
                webcamStream = null;
            }
            webcamVideo.srcObject = null;
            webcamVideo.classList.remove("hidden");
            webcamCanvas.classList.add("hidden");
        });
    }

    // Form validation for avatar size
    const createForm = document.getElementById("createUserForm");
    if (createForm) {
        createForm.addEventListener("submit", function (e) {
            const fileInput = document.getElementById("avatarInput");
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    alert("Avatar image must be less than 2MB");
                    return;
                }
            }

            // Existing password validation
            const password = document.getElementById("password");
            const confirmPassword = document.querySelector(
                'input[name="password_confirmation"]'
            );

            if (
                password &&
                confirmPassword &&
                password.value !== confirmPassword.value
            ) {
                e.preventDefault();
                alert("Passwords do not match!");
                return;
            }

            if (password && password.value.length < 8) {
                e.preventDefault();
                alert("Password must be at least 8 characters long!");
                return;
            }
        });
    }

    // Add image processing on form reset
    const modal = document.getElementById("createUserModal");
    if (modal) {
        modal.addEventListener("hidden.bs.modal", () => {
            setTimeout(() => {
                resetAvatar();
            }, 300);
        });
    }
}

// Export for use in main file
if (typeof window !== "undefined") {
    window.initializeAvatarUpload = initializeAvatarUpload;
}
