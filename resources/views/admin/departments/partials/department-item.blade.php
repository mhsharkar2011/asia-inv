@php
    $level = $level ?? 0; // Default to 0 if not set
    $indent = $level * 6; // Increased indentation for better visual hierarchy
@endphp

<li class="department-item border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors duration-200">
    <div class="px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center flex-1 min-w-0">
                <!-- Indentation and expand/collapse button -->
                <div class="flex-shrink-0" style="margin-left: {{ $indent }}px">
                    @if(!$department->is_leaf)
                        <button id="expand-{{ $department->id }}"
                                onclick="toggleChildren({{ $department->id }})"
                                class="expand-btn w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @else
                        <div class="w-8 h-8 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div>
                        </div>
                    @endif
                </div>

                <!-- Department Information -->
                <div class="ml-3 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-3">
                                <!-- Company Badge (if available) -->
                                @if($department->company)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border border-blue-200">
                                        {{ $department->company->name }}
                                    </span>
                                @endif

                                <!-- Department Name and Code -->
                                <div class="flex items-center">
                                    <h4 class="text-base font-semibold text-gray-900 truncate">
                                        {{ $department->name }}
                                    </h4>
                                    <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                        {{ $department->code }}
                                    </span>
                                </div>
                            </div>

                            <!-- Department Details -->
                            <div class="mt-2 flex flex-wrap items-center gap-4">
                                <!-- Staff Count -->
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-5 h-5 flex items-center justify-center mr-1.5 rounded-full bg-gradient-to-br from-blue-100 to-blue-50">
                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $department->active_staff_count }}</span>
                                    <span class="text-gray-500 ml-1">/{{ $department->staff_count }} staff</span>
                                </div>

                                <!-- Manager -->
                                @if($department->manager)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-5 h-5 flex items-center justify-center mr-1.5 rounded-full bg-gradient-to-br from-green-100 to-green-50">
                                            <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                        </div>
                                        <span class="font-medium truncate max-w-[120px]">{{ $department->manager->name }}</span>
                                    </div>
                                @endif

                                <!-- Budget -->
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-5 h-5 flex items-center justify-center mr-1.5 rounded-full bg-gradient-to-br from-purple-100 to-purple-50">
                                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">${{ number_format($department->budget, 2) }}</span>
                                </div>

                                <!-- Location (if available) -->
                                @if($department->location)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-5 h-5 flex items-center justify-center mr-1.5 rounded-full bg-gradient-to-br from-orange-100 to-orange-50">
                                            <svg class="w-3 h-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <span class="truncate max-w-[100px]">{{ $department->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status and Actions -->
                        <div class="flex items-center space-x-3 ml-4">
                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $department->is_active
                                    ? 'bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 border border-green-200'
                                    : 'bg-gradient-to-r from-red-50 to-pink-50 text-red-800 border border-red-200' }}">
                                @if($department->is_active)
                                    <svg class="mr-1.5 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Active
                                @else
                                    <svg class="mr-1.5 h-2 w-2 text-red-500" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Inactive
                                @endif
                            </span>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-1">
                                <!-- View Button -->
                                <button onclick="viewDepartment({{ $department->id }})"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200"
                                    title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <!-- Edit Button -->
                                <button onclick="editDepartment({{ $department->id }})"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition-colors duration-200"
                                    title="Edit Department">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Delete Button -->
                                @if($department->canBeDeleted())
                                    <button onclick="confirmDelete({{ $department->id }})"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:text-red-800 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors duration-200"
                                        title="Delete Department">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @else
                                    <button disabled
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 cursor-not-allowed"
                                        title="Cannot delete (has users or child departments)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Children Departments -->
    @if(!$department->is_leaf)
        <div id="children-{{ $department->id }}" class="hidden border-t border-gray-100">
            @foreach($department->children as $child)
                @include('admin.departments.partials.department-item', [
                    'department' => $child,
                    'level' => $level + 1
                ])
            @endforeach
        </div>
    @endif
</li>
