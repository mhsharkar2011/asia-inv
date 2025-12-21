<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                <h5 class="text-lg font-semibold text-gray-900">Create New User</h5>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors duration-200" data-bs-dismiss="modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-6 py-6">
                    <div class="space-y-6">
                        <!-- Avatar Upload Section -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Profile Picture</h6>
                            <div class="flex items-start space-x-6">
                                <!-- Avatar Preview -->
                                <div class="flex-shrink-0">
                                    <div class="relative group">
                                        <div id="avatarPreview" class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center border-2 border-dashed border-gray-300 overflow-hidden cursor-pointer hover:border-blue-400 transition-all duration-200">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-xs text-gray-500 mt-2 group-hover:text-blue-600">Click to upload</p>
                                            </div>
                                            <img id="avatarImage" class="absolute inset-0 w-full h-full object-cover hidden" alt="Avatar preview">
                                        </div>
                                        <div id="avatarRemove" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 cursor-pointer hover:bg-red-600 transition-colors duration-200 hidden" title="Remove image">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Controls -->
                                <div class="flex-grow">
                                    <div class="space-y-4">
                                        <div>
                                            <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
                                            <div class="flex items-center space-x-3">
                                                <label for="avatarInput" class="cursor-pointer inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                    </svg>
                                                    Choose File
                                                </label>
                                                <button type="button" id="captureAvatar" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    Take Photo
                                                </button>
                                            </div>
                                        </div>

                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                            <p class="text-sm text-blue-800 flex items-center">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                Recommended: Square image, JPG, PNG or GIF, Max 2MB
                                            </p>
                                        </div>

                                        <!-- Cropping Area (Hidden by default) -->
                                        <div id="cropArea" class="hidden">
                                            <div class="mb-4">
                                                <div id="imageCropper" class="w-full h-64 bg-gray-100 rounded-lg border border-gray-300"></div>
                                            </div>
                                            <div class="flex justify-end space-x-3">
                                                <button type="button" id="cancelCrop" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800">
                                                    Cancel
                                                </button>
                                                <button type="button" id="applyCrop" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                    Apply Crop
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Personal Information</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Account Information</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                                    <select name="role" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                    <select name="department_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">Select Department</option>
                                        @foreach ($departments ?? [] as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 pr-12">
                                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                                            <div id="passwordStrength" class="h-full bg-gray-300 transition-all duration-300"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with uppercase, lowercase & number</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Additional Information</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Position/Title</label>
                                    <input type="text" name="position" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <textarea name="address" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions & Settings -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Permissions & Settings</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                                        <label for="is_active" class="ml-3 text-sm text-gray-700">Active Account</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="send_welcome_email" id="send_welcome_email" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                                        <label for="send_welcome_email" class="ml-3 text-sm text-gray-700">Send Welcome Email</label>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="force_password_change" id="force_password_change" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="force_password_change" class="ml-3 text-sm text-gray-700">Force Password Change</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="two_factor_auth" id="two_factor_auth" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="two_factor_auth" class="ml-3 text-sm text-gray-700">Enable 2FA</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <button type="button" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="ml-3 inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
