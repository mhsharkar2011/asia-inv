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
                                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters with letters and numbers</p>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
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
                                    <!-- Roles -->
                                    <div>
                                        <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">
                                            Roles <span class="text-red-500">*</span>
                                        </label>
                                        <select id="roles" name="roles[]" multiple
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('roles') border-red-500 @enderror"
                                            required>
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
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Language Preference -->
                                    <div>
                                        <label for="language_preference" class="block text-sm font-medium text-gray-700 mb-1">
                                            Language Preference
                                        </label>
                                        <select id="language_preference" name="language_preference"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="en" {{ old('language_preference', 'en') == 'en' ? 'selected' : '' }}>English</option>
                                            <option value="es" {{ old('language_preference') == 'es' ? 'selected' : '' }}>Spanish</option>
                                            <option value="fr" {{ old('language_preference') == 'fr' ? 'selected' : '' }}>French</option>
                                            <option value="de" {{ old('language_preference') == 'de' ? 'selected' : '' }}>German</option>
                                            <option value="zh" {{ old('language_preference') == 'zh' ? 'selected' : '' }}>Chinese</option>
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
                                                    class="hidden"
                                                    onchange="previewImage(this)">
                                                <label for="avatar"
                                                    class="cursor-pointer inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Choose File
                                                </label>
                                            </div>
                                            <div id="imagePreview" class="hidden">
                                                <img id="preview" class="w-16 h-16 rounded-full object-cover border border-gray-200" src="" alt="Preview">
                                            </div>
                                        </div>
                                        @error('avatar')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Max file size: 2MB. Allowed types: JPEG, PNG, JPG, GIF, WebP</p>
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
                                        <input type="checkbox" id="send_welcome_email" name="send_welcome_email" value="1"
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <div>
                                            <label for="send_welcome_email" class="block text-sm font-medium text-gray-700">
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for roles
            $('#roles').select2({
                placeholder: 'Select roles',
                allowClear: true,
                width: '100%'
            });

            // Initialize Select2 for company (if exists)
            if ($('#company_id').length) {
                $('#company_id').select2({
                    placeholder: 'Select company',
                    allowClear: true,
                    width: '100%'
                });
            }

            // Initialize Select2 for branch (if exists)
            if ($('#branch_id').length) {
                $('#branch_id').select2({
                    placeholder: 'Select branch',
                    allowClear: true,
                    width: '100%'
                });
            }

            // Initialize Select2 for language preference
            $('#language_preference').select2({
                placeholder: 'Select language',
                allowClear: false,
                width: '100%'
            });

            // Optional: Load branches based on company selection
            $('#company_id').change(function() {
                var companyId = $(this).val();
                var branchSelect = $('#branch_id');

                if (companyId) {
                    // Clear current options
                    branchSelect.empty();
                    branchSelect.append('<option value="">Loading branches...</option>');

                    // AJAX call to load branches
                    $.ajax({
                        url: '{{ route("admin.branches.by-company") }}',
                        method: 'GET',
                        data: { company_id: companyId },
                        success: function(response) {
                            branchSelect.empty();
                            branchSelect.append('<option value="">Select Branch</option>');

                            if (response.length > 0) {
                                $.each(response, function(index, branch) {
                                    branchSelect.append('<option value="' + branch.id + '">' + branch.name + '</option>');
                                });
                                branchSelect.prop('disabled', false);
                            } else {
                                branchSelect.append('<option value="">No branches available</option>');
                                branchSelect.prop('disabled', true);
                            }

                            // Restore selected value if exists in old input
                            var oldBranchId = '{{ old("branch_id") }}';
                            if (oldBranchId) {
                                branchSelect.val(oldBranchId).trigger('change');
                            }
                        },
                        error: function() {
                            branchSelect.empty();
                            branchSelect.append('<option value="">Error loading branches</option>');
                            branchSelect.prop('disabled', true);
                        }
                    });
                } else {
                    branchSelect.empty();
                    branchSelect.append('<option value="">Select Branch</option>');
                    branchSelect.val('').trigger('change');

                    // Load all branches if no company selected
                    @if(isset($branches) && count($branches) > 0)
                        @foreach($branches as $branch)
                            branchSelect.append('<option value="{{ $branch->id }}">{{ $branch->name }}</option>');
                        @endforeach
                    @endif

                    branchSelect.prop('disabled', false);
                }
            });

            // Trigger company change on page load if company is selected
            @if(old('company_id'))
                $('#company_id').trigger('change');
            @endif
        });

        // Image preview functionality
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                    $('#imagePreview').removeClass('hidden');
                }

                reader.readAsDataURL(input.files[0]);

                // Update file name display
                var fileName = input.files[0].name;
                $('label[for="avatar"]').html('<svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>' + fileName);
            }
        }

        // Form validation
        $('form').submit(function(e) {
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                $('#password').focus();
            }

            // Password strength validation
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                $('#password').focus();
            }
        });
    </script>
@endpush
