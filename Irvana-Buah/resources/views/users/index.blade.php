<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    Manajemen Pengguna
                </h2>
            </div>
            <a href="{{ route('users.create') }}"
               class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="font-medium">Tambah Pengguna</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, userToDelete: null, userName: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Success Modal --}}
            @if (session('success'))
                <x-modal name="success-notification" :show="true" max-width="md">
                    <div class="p-6 text-center">
                        {{-- Success Icon with Animation --}}
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4 animate-bounce-once">
                            <svg class="w-8 h-8 text-green-600 animate-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path 
                                    stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    d="M5 13l4 4L19 7"
                                    class="checkmark-path"
                                    stroke-dasharray="24"
                                    stroke-dashoffset="24"
                                ></path>
                            </svg>
                        </div>
                        
                        {{-- Success Title --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-2 animate-fade-in-up">Berhasil!</h3>
                        
                        {{-- Success Message --}}
                        <p class="text-gray-600 mb-6 animate-fade-in-up-delay">{{ session('success') }}</p>
                        
                        {{-- Close Button --}}
                        <button 
                            x-on:click="show = false" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl animate-fade-in-up-delay-2 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            OK, Mengerti
                        </button>
                    </div>
                </x-modal>
            @endif

            {{-- Delete Confirmation Modal --}}
            <div x-show="showDeleteModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                 style="display: none;">
                <div x-show="showDeleteModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                    <div class="p-6 text-center">
                        {{-- Warning Icon --}}
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        
                        {{-- Warning Title --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Penghapusan</h3>
                        
                        {{-- Warning Message --}}
                        <p class="text-gray-600 mb-6">
                            Apakah Anda yakin ingin menghapus pengguna <strong x-text="userName"></strong>? 
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                        
                        {{-- Action Buttons --}}
                        <div class="flex space-x-3 justify-center">
                            <button 
                                x-on:click="showDeleteModal = false" 
                                class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                                Batal
                            </button>
                            <button 
                                x-on:click="if(userToDelete) userToDelete.submit()" 
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Administrator</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pengguna Biasa</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'user')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Bergabung Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Users Table --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                @if($users->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 34l-4-4m0 0l-4-4m4 4l-4 4m4-4h-8m-2-4a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pengguna</h3>
                        <p class="mt-2 text-gray-500">Mulai dengan menambahkan pengguna baru.</p>
                        <div class="mt-6">
                            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                                Tambah Pengguna Pertama
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Pengguna
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Kontak
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Bergabung
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                                        <span class="text-white font-semibold text-lg">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->role === 'admin')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Administrator
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Pengguna
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                @if($user->phone_number)
                                                    <div class="flex items-center text-gray-600 mb-1">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                                        </svg>
                                                        {{ $user->phone_number }}
                                                    </div>
                                                @endif
                                                @if($user->address)
                                                    <div class="flex items-start text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-xs leading-relaxed">{{ Str::limit($user->address, 30) }}</span>
                                                    </div>
                                                @endif
                                                @if(!$user->phone_number && !$user->address)
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                                                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('users.show', $user) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 transition-colors duration-150"
                                                   title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('users.edit', $user) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 transition-colors duration-150"
                                                   title="Edit">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                            title="Hapus"
                                                            x-on:click="showDeleteModal = true; userToDelete = $el.closest('form'); userName = '{{ $user->name }}'">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($users->count() > 0)
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $users->count() }}</span> pengguna
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Custom CSS Animations --}}
    <style>
        /* Bounce animation for icon container */
        @keyframes bounce-once {
            0% { 
                transform: scale(0.3) rotate(-10deg);
                opacity: 0;
            }
            50% { 
                transform: scale(1.05) rotate(5deg);
                opacity: 1;
            }
            70% { 
                transform: scale(0.95) rotate(-2deg);
            }
            100% { 
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* Checkmark drawing animation */
        @keyframes draw-checkmark {
            0% {
                stroke-dashoffset: 24;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Fade in up animations */
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Apply animations */
        .animate-bounce-once {
            animation: bounce-once 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .animate-checkmark .checkmark-path {
            animation: draw-checkmark 0.6s ease-out 0.3s forwards;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out 0.4s both;
        }

        .animate-fade-in-up-delay {
            animation: fade-in-up 0.6s ease-out 0.6s both;
        }

        .animate-fade-in-up-delay-2 {
            animation: fade-in-up 0.6s ease-out 0.8s both;
        }

        /* Pulse effect for background */
        .animate-bounce-once::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background: rgba(34, 197, 94, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: pulse-ring 1s ease-out 0.1s;
        }

        @keyframes pulse-ring {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(2);
                opacity: 0;
            }
        }

        /* Make the icon container relative for positioning */
        .animate-bounce-once {
            position: relative;
        }
    </style>
</x-app-layout>