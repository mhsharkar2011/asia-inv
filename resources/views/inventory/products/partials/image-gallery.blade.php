<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <!-- Gallery Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Product Images</h3>
                <p class="text-sm text-gray-600">Upload and manage product images</p>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button"
                        onclick="openImageUpload()"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Images
                </button>

                @if(!empty($existingImages))
                    <button type="button"
                            onclick="bulkDeleteImages()"
                            id="bulk-delete-btn"
                            class="hidden inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Selected
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Image Upload Area -->
    <div id="image-upload-section" class="hidden px-6 py-4 border-b border-gray-200">
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-medium text-gray-900">Upload New Images</h4>
                <button type="button"
                        onclick="closeImageUpload()"
                        class="text-gray-400 hover:text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-center w-full">
                    <label for="images"
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                        </div>
                        <input id="images" name="images[]" type="file" multiple accept="image/*" class="hidden">
                    </label>
                </div>

                <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <!-- Image previews will be added here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Image Gallery -->
    <div class="p-6">
        @if(!empty($existingImages) && count($existingImages) > 0)
            <div id="image-gallery"
                 class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"
                 data-image-order="{{ json_encode(collect($existingImages)->pluck('id')) }}">

                @foreach($existingImages as $index => $image)
                    <div class="relative group" data-image-id="{{ $image['id'] }}">
                        <!-- Selection Checkbox -->
                        <div class="absolute top-2 left-2 z-10 hidden group-hover:block">
                            <input type="checkbox"
                                   name="selected_images[]"
                                   value="{{ $image['id'] }}"
                                   class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 image-checkbox"
                                   onchange="updateBulkDeleteButton()">
                        </div>

                        <!-- Image Container -->
                        <div class="relative overflow-hidden rounded-lg bg-gray-100 aspect-square">
                            <img src="{{ $image['url'] }}"
                                 alt="{{ $image['name'] }}"
                                 class="w-full h-full object-cover cursor-pointer hover:scale-110 transition-transform duration-300"
                                 onclick="viewImage({{ $image['id'] }})"
                                 loading="lazy">

                            <!-- Primary Badge -->
                            @if($image['is_primary'])
                                <div class="absolute top-2 right-2 z-10">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Primary
                                    </span>
                                </div>
                            @endif

                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex space-x-2">
                                    <!-- View Button -->
                                    <button type="button"
                                            onclick="viewImage({{ $image['id'] }})"
                                            class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors"
                                            title="View Image">
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    <!-- Set Primary Button -->
                                    @if(!$image['is_primary'])
                                        <button type="button"
                                                onclick="setPrimaryImage({{ $image['id'] }})"
                                                class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors"
                                                title="Set as Primary">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Delete Button -->
                                    <button type="button"
                                            onclick="deleteImage({{ $image['id'] }})"
                                            class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors"
                                            title="Delete Image">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Image Info -->
                        <div class="mt-2 px-1">
                            <p class="text-xs text-gray-600 truncate" title="{{ $image['name'] }}">
                                {{ Str::limit($image['name'], 20) }}
                            </p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-gray-500">
                                    Order: {{ $image['display_order'] }}
                                </span>
                                <button type="button"
                                        class="text-xs text-gray-400 hover:text-gray-600 cursor-move drag-handle"
                                        title="Drag to reorder">
                                    ≡
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Hidden input for deleted images -->
            <input type="hidden" name="deleted_images" id="deleted_images" value="">
            <input type="hidden" name="image_order" id="image_order" value="">

        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00 to 2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Images Uploaded</h3>
                <p class="text-gray-600 mb-6">Upload images to showcase your product</p>
                <button type="button"
                        onclick="openImageUpload()"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Upload First Image
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Image View Modal -->
<div id="image-view-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeImageView()"></div>

        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Image Display -->
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900" id="image-title">Product Image</h3>
                            <button type="button"
                                    onclick="closeImageView()"
                                    class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="relative">
                            <img id="modal-image" src="" alt="" class="max-h-[70vh] w-full object-contain rounded-lg">

                            <!-- Navigation Arrows -->
                            <button id="prev-image"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button id="next-image"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>

                            <!-- Image Info -->
                            <div id="image-info" class="mt-4 text-sm text-gray-600 hidden">
                                <!-- Info will be loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thumbnail Strip -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <div id="thumbnail-strip" class="flex space-x-2 overflow-x-auto py-2">
                    <!-- Thumbnails will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image management variables
    let deletedImages = [];
    let currentImageOrder = [];
    let currentImageViewIndex = 0;
    let allImages = @json($existingImages ?? []);

    // Initialize Sortable for image reordering
    document.addEventListener('DOMContentLoaded', function() {
        const imageGallery = document.getElementById('image-gallery');
        if (imageGallery) {
            currentImageOrder = JSON.parse(imageGallery.dataset.imageOrder || '[]');

            // Initialize drag and drop for reordering
            new Sortable(imageGallery, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    updateImageOrder();
                }
            });
        }
    });

    // Update image order after drag and drop
    function updateImageOrder() {
        const imageItems = document.querySelectorAll('#image-gallery > [data-image-id]');
        currentImageOrder = Array.from(imageItems).map(item =>
            parseInt(item.dataset.imageId)
        );
        document.getElementById('image_order').value = JSON.stringify(currentImageOrder);
    }

    // Image upload preview
    document.getElementById('images')?.addEventListener('change', function(e) {
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'relative group';
                preview.innerHTML = `
                    <div class="relative overflow-hidden rounded-lg bg-gray-100 aspect-square">
                        <img src="${e.target.result}"
                             alt="${file.name}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <button type="button"
                                    onclick="removePreview(${index})"
                                    class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-600 truncate">${file.name}</p>
                `;
                previewContainer.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    });

    function removePreview(index) {
        const input = document.getElementById('images');
        const dt = new DataTransfer();

        Array.from(input.files).forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });

        input.files = dt.files;
        input.dispatchEvent(new Event('change'));
    }

    // Open/close image upload section
    function openImageUpload() {
        document.getElementById('image-upload-section').classList.remove('hidden');
    }

    function closeImageUpload() {
        document.getElementById('image-upload-section').classList.add('hidden');
    }

    // Delete single image
    function deleteImage(imageId) {
        if (confirm('Are you sure you want to delete this image?')) {
            // Add to deleted images array
            if (!deletedImages.includes(imageId)) {
                deletedImages.push(imageId);
                document.getElementById('deleted_images').value = JSON.stringify(deletedImages);
            }

            // Remove from DOM
            const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
            if (imageElement) {
                imageElement.remove();
            }

            // Remove from current order
            currentImageOrder = currentImageOrder.filter(id => id !== imageId);
            updateImageOrder();

            // Update bulk delete button
            updateBulkDeleteButton();

            // Show success message
            showToast('Image deleted successfully', 'success');
        }
    }

    // Bulk image deletion
    function bulkDeleteImages() {
        const selectedCheckboxes = document.querySelectorAll('.image-checkbox:checked');
        if (selectedCheckboxes.length === 0) return;

        if (confirm(`Are you sure you want to delete ${selectedCheckboxes.length} selected image(s)?`)) {
            selectedCheckboxes.forEach(checkbox => {
                const imageId = parseInt(checkbox.value);
                deleteImage(imageId);
            });

            // Hide bulk delete button
            document.getElementById('bulk-delete-btn').classList.add('hidden');
        }
    }

    // Update bulk delete button visibility
    function updateBulkDeleteButton() {
        const selectedCount = document.querySelectorAll('.image-checkbox:checked').length;
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

        if (selectedCount > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete (${selectedCount})
            `;
        } else {
            bulkDeleteBtn.classList.add('hidden');
        }
    }

    // Set image as primary
    function setPrimaryImage(imageId) {
        fetch(`/inventory/products/{{ $product->id }}/images/${imageId}/primary`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                document.querySelectorAll('.primary-badge').forEach(badge => badge.remove());
                const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                if (imageElement) {
                    const badge = document.createElement('span');
                    badge.className = 'absolute top-2 right-2 z-10 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 primary-badge';
                    badge.innerHTML = `
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Primary
                    `;
                    imageElement.querySelector('.relative').appendChild(badge);
                }
                showToast('Primary image updated successfully', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to update primary image', 'error');
        });
    }

    // Image view modal functions
    function viewImage(imageId) {
        currentImageViewIndex = allImages.findIndex(img => img.id == imageId);
        loadImageModal(currentImageViewIndex);
        document.getElementById('image-view-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeImageView() {
        document.getElementById('image-view-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function loadImageModal(index) {
        if (index < 0 || index >= allImages.length) return;

        const image = allImages[index];
        document.getElementById('modal-image').src = image.url;
        document.getElementById('image-title').textContent = image.name;

        // Load thumbnails
        const thumbnailStrip = document.getElementById('thumbnail-strip');
        thumbnailStrip.innerHTML = '';

        allImages.forEach((img, idx) => {
            const thumb = document.createElement('button');
            thumb.className = `flex-shrink-0 w-16 h-16 rounded overflow-hidden border-2 ${idx === index ? 'border-blue-500' : 'border-transparent'}`;
            thumb.innerHTML = `<img src="${img.url}" alt="${img.name}" class="w-full h-full object-cover">`;
            thumb.onclick = () => loadImageModal(idx);
            thumbnailStrip.appendChild(thumb);
        });

        // Update navigation buttons
        document.getElementById('prev-image').onclick = () => {
            loadImageModal(index > 0 ? index - 1 : allImages.length - 1);
        };
        document.getElementById('next-image').onclick = () => {
            loadImageModal(index < allImages.length - 1 ? index + 1 : 0);
        };
    }

    // Keyboard navigation for image modal
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('image-view-modal').classList.contains('hidden')) return;

        if (e.key === 'Escape') closeImageView();
        if (e.key === 'ArrowLeft') loadImageModal(currentImageViewIndex > 0 ? currentImageViewIndex - 1 : allImages.length - 1);
        if (e.key === 'ArrowRight') loadImageModal(currentImageViewIndex < allImages.length - 1 ? currentImageViewIndex + 1 : 0);
    });

    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200'}`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ?
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z"/>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
        background: #cbd5e1;
    }

    .drag-handle {
        cursor: grab;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    /* Smooth transitions */
    #image-view-modal {
        transition: opacity 0.3s ease;
    }

    #image-view-modal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    #image-view-modal:not(.hidden) {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush
