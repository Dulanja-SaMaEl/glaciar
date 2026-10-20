@props(['modalId', 'title'])

<div id="{{ $modalId }}" class="hidden fixed inset-0 z-50 overflow-y-auto" x-data="{ open: false }" x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="document.getElementById('{{ $modalId }}').classList.add('hidden')">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4 border-b border-glaciar-gray-100 pb-3">
                    <h3 class="text-lg font-bold text-glaciar-black">{{ $title }}</h3>
                    <button type="button" onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')" class="text-glaciar-gray-400 hover:text-glaciar-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                {{ $slot }}
            </div>
            
            <div class="bg-glaciar-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="submit" form="{{ $modalId }}-form" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-glaciar-black text-base font-medium text-white hover:bg-glaciar-gray-900 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Submit
                </button>
                <button type="button" onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-glaciar-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-glaciar-black hover:bg-glaciar-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>