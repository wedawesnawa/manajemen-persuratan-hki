<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Role Users') }}
    </x-slot>

    <style>
        body {
            background-color: #F9FAFB;
        }
    </style>
    @include('components.toast')
    <!-- Toast Notification -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('success') }}", 'success');
            });
        </script>
    @elseif(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('error') }}", 'error');
            });
        </script>
    @endif
    <div class="w-full pt-4 px-2 sm:px-4 md:px-10 lg:ps-80 mx-auto">

        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="p-4 bg-gray-50 flex flex-col border border-dashed border-gray-200 rounded-xl overflow-auto">
                
                <!-- Header -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                    <div class="sm:col-span-12 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                Role User
                            </h2>
                            <p class="text-sm text-gray-600">
                                Edit Role User 
                            </p>
                        </div>
                    </div>
                </div>
                    
                <!-- End Header -->

                <div class="py-3 border-t border-gray-200"></div>

                <form action="{{ route('edit.role') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div class="grid sm:grid-cols-12 gap-4">
                            <label for="email-select" class="sm:col-span-3 block text-sm font-medium text-gray-700">Email</label>
                            <select id="email-select" name="email" class="sm:col-span-9 block w-full py-3 px-4 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" selected disabled>Select an Email</option>
                                @foreach($user as $row)
                                    <option value="{{ $row->email }}" data-role="{{ $row->roles }}">{{ $row->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Role Select -->
                        <div class="grid sm:grid-cols-12 gap-4">
                            <label for="role-select" class="sm:col-span-3 block text-sm font-medium text-gray-700">Role</label>
                            <select id="role-select" name="role" class="sm:col-span-9 block w-full py-3 px-4 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" selected disabled>Select a Role</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="mt-5 flex justify-end">
                            <button type="submit"
                                class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Kirim
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailSelect = document.getElementById('email-select');
            const roleSelect = document.getElementById('role-select');

            emailSelect.addEventListener('change', function() {
                const selectedEmail = this.options[this.selectedIndex];
                const roleValue = selectedEmail.getAttribute('data-role');

                for (let i = 0; i < roleSelect.options.length; i++) {
                    if (roleSelect.options[i].value === roleValue) {
                        roleSelect.selectedIndex = i;
                        break;
                    }
                }
            });
        });
    </script>
</x-app-layout>
