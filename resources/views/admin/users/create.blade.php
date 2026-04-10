@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
                        <p class="text-gray-600 mt-1">Add a new user to the system</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="px-6 py-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="p-6 space-y-6">
                            <!-- Personal Information Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Personal Information</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Full Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                            placeholder="Enter full name" required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                            placeholder="Enter email address" required>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Username -->
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                                            Username
                                        </label>
                                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('username') border-red-500 @enderror"
                                            placeholder="Enter username (optional)">
                                        @error('username')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Phone Number
                                        </label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                            placeholder="Enter phone number (optional)">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Security</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="password" name="password"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                            placeholder="Enter password" required>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters with letters and numbers
                                        </p>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Confirm password" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Role & Company Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Role & Company</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Roles Field -->
                                    <div>
                                        <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">
                                            Roles <span class="text-red-500">*</span>
                                        </label>
                                        <select name="roles[]" id="roles"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('roles') border-red-500 @enderror"
                                            multiple required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple roles</p>
                                    </div>

                                    <!-- Permissions Field (Optional) -->
                                    <div>
                                        <label for="permissions" class="block text-sm font-medium text-gray-700 mb-1">
                                            Direct Permissions
                                        </label>
                                        <select name="permissions[]" id="permissions"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('permissions') border-red-500 @enderror"
                                            multiple>
                                            @foreach ($permissions as $group => $groupPermissions)
                                                <optgroup label="{{ ucfirst($group) }}">
                                                    @foreach ($groupPermissions as $permission)
                                                        <option value="{{ $permission->name }}"
                                                            {{ in_array($permission->name, old('permissions', [])) ? 'selected' : '' }}>
                                                            {{ $permission->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        @error('permissions')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Additional permissions beyond role</p>
                                    </div>

                                    <!-- Company -->
                                    <div>
                                        <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Company
                                        </label>
                                        <select id="company_id" name="company_id"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('company_id') border-red-500 @enderror">
                                            <option value="">Select Company</option>
                                            @foreach ($companies ?? [] as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Branch -->
                                    <div>
                                        <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Branch
                                        </label>
                                        <select id="branch_id" name="branch_id"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('branch_id') border-red-500 @enderror">
                                            <option value="">Select Branch</option>
                                            @foreach ($branches ?? [] as $branch)
                                                <option value="{{ $branch->id }}"
                                                    data-company-id="{{ $branch->company_id }}"
                                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Language Preference -->
                                    <div>
                                        <label for="language_preference"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Language Preference
                                        </label>
                                        <select id="language_preference" name="language_preference"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="en"
                                                {{ old('language_preference', 'en') == 'en' ? 'selected' : '' }}>English
                                            </option>
                                            <option value="es"
                                                {{ old('language_preference') == 'es' ? 'selected' : '' }}>Spanish</option>
                                            <option value="fr"
                                                {{ old('language_preference') == 'fr' ? 'selected' : '' }}>French</option>
                                            <option value="de"
                                                {{ old('language_preference') == 'de' ? 'selected' : '' }}>German</option>
                                            <option value="zh"
                                                {{ old('language_preference') == 'zh' ? 'selected' : '' }}>Chinese</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile & Address Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Profile & Address</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Profile Picture -->
                                    <div>
                                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">
                                            Profile Picture
                                        </label>
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <input type="file" id="avatar" name="avatar" accept="image/*"
                                                    class="hidden" onchange="previewImage(this)">
                                                <label for="avatar"
                                                    class="cursor-pointer inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Choose File
                                                </label>
                                            </div>
                                            <div id="imagePreview" class="hidden">
                                                <img id="preview"
                                                    class="w-16 h-16 rounded-full object-cover border border-gray-200"
                                                    src="" alt="Preview">
                                            </div>
                                        </div>
                                        @error('avatar')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Max file size: 2MB. Allowed types: JPEG, PNG,
                                            JPG, GIF, WebP</p>
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                            Address
                                        </label>
                                        <textarea id="address" name="address" rows="3"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror"
                                            placeholder="Enter address (optional)">{{ old('address') }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Settings</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Active Status -->
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', true) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <div>
                                            <label for="is_active" class="block text-sm font-medium text-gray-700">
                                                Active User
                                            </label>
                                            <p class="text-xs text-gray-500">User can login to the system</p>
                                        </div>
                                    </div>

                                    <!-- Send Welcome Email -->
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" id="send_welcome_email" name="send_welcome_email"
                                            value="1"
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <div>
                                            <label for="send_welcome_email"
                                                class="block text-sm font-medium text-gray-700">
                                                Send Welcome Email
                                            </label>
                                            <p class="text-xs text-gray-500">Send login credentials to user's email</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.users.index') }}"
                                    class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Select2 Styles */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.25rem;
            min-height: 42px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b82f6;
            border-color: #2563eb;
            color: white;
            border-radius: 0.375rem;
            padding: 0.125rem 0.5rem;
            margin: 2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 0.25rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store all branches data
    const allBranches = @json($branches ?? []);
    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const rolesSelect = document.getElementById('roles');
    const permissionsSelect = document.getElementById('permissions');
    const languageSelect = document.getElementById('language_preference');

    // Initialize Select2 for roles if element exists
    if (rolesSelect) {
        $(rolesSelect).select2({
            placeholder: 'Select roles',
            allowClear: true,
            width: '100%'
        });
    }

    // Initialize Select2 for permissions if element exists
    if (permissionsSelect) {
        $(permissionsSelect).select2({
            placeholder: 'Select permissions',
            allowClear: true,
            width: '100%'
        });
    }

    // Initialize Select2 for language preference
    if (languageSelect) {
        $(languageSelect).select2({
            placeholder: 'Select language',
            allowClear: false,
            width: '100%'
        });
    }

    // Function to filter branches based on selected company
    function filterBranches() {
        const selectedCompanyId = companySelect ? companySelect.value : '';

        // Clear current branch options
        branchSelect.innerHTML = '<option value="">Select Branch</option>';

        if (selectedCompanyId) {
            // Filter branches that belong to the selected company
            const filteredBranches = allBranches.filter(branch => branch.company_id == selectedCompanyId);

            if (filteredBranches.length > 0) {
                filteredBranches.forEach(branch => {
                    const option = document.createElement('option');
                    option.value = branch.id;
                    option.textContent = branch.name;
                    branchSelect.appendChild(option);
                });
                branchSelect.disabled = false;
            } else {
                branchSelect.innerHTML = '<option value="">No branches available for this company</option>';
                branchSelect.disabled = true;
            }
        } else {
            // Show all branches if no company selected
            allBranches.forEach(branch => {
                const option = document.createElement('option');
                option.value = branch.id;
                option.textContent = branch.name;
                branchSelect.appendChild(option);
            });
            branchSelect.disabled = false;
        }

        // Restore old selected value if exists
        const oldBranchId = '{{ old('branch_id') }}';
        if (oldBranchId) {
            branchSelect.value = oldBranchId;
        }

        // Trigger Select2 update if initialized
        if ($(branchSelect).hasClass('select2-hidden-accessible')) {
            $(branchSelect).trigger('change');
        }
    }

    // Add event listener to company select
    if (companySelect) {
        companySelect.addEventListener('change', filterBranches);

        // Initialize Select2 for company
        $(companySelect).select2({
            placeholder: 'Select company',
            allowClear: true,
            width: '100%'
        });

        // Initialize Select2 for branch
        $(branchSelect).select2({
            placeholder: 'Select branch',
            allowClear: true,
            width: '100%'
        });

        // Trigger filter on page load if company is selected
        if (companySelect.value) {
            filterBranches();
        } else {
            // Initial load - show all branches
            filterBranches();
        }
    }

    // Image preview functionality
    window.previewImage = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                const imagePreview = document.getElementById('imagePreview');
                if (preview && imagePreview) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
            }

            reader.readAsDataURL(input.files[0]);

            // Update file name display
            var fileName = input.files[0].name;
            const avatarLabel = document.querySelector('label[for="avatar"]');
            if (avatarLabel) {
                avatarLabel.innerHTML = '<svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>' + fileName;
            }
        }
    }

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const roles = document.getElementById('roles');

            if (password && confirmPassword) {
                // Check if passwords match
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    password.focus();
                    return false;
                }

                // Check password length
                if (password.value.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long!');
                    password.focus();
                    return false;
                }
            }

            // Check if at least one role is selected
            if (roles && roles.selectedOptions.length === 0) {
                e.preventDefault();
                alert('Please select at least one role for the user!');
                roles.focus();
                return false;
            }
        });
    }
});
</script>
@endpush
