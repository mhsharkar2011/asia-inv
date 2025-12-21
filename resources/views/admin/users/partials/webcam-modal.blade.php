<!-- Webcam Capture Modal -->
<div class="modal fade" id="webcamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                <h5 class="text-lg font-semibold text-gray-900">Take a Photo</h5>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors duration-200" data-bs-dismiss="modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body px-6 py-6">
                <div class="text-center">
                    <div id="webcamContainer" class="w-full h-64 bg-gray-900 rounded-lg mb-4 overflow-hidden">
                        <video id="webcamVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                    </div>
                    <canvas id="webcamCanvas" class="hidden"></canvas>

                    <div class="flex justify-center space-x-4">
                        <button type="button" id="capturePhoto" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                        <button type="button" id="retakePhoto" class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200 hidden">
                            Retake
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer px-6 py-4 bg-gray-50 border-t border-gray-200">
                <button type="button" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="usePhoto" class="ml-3 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 hidden">
                    Use Photo
                </button>
            </div>
        </div>
    </div>
</div>
