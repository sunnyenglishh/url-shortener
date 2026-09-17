<x-app-layout>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Invite User
                </h1>

                <p class="mb-6">
                    Company:
                    <strong>{{ $company->name }}</strong>
                </p>

                <form method="POST" action="{{ route('companies.invite', $company) }}">

                    @csrf

                    <div class="flex gap-2">
                        <div class="mb-4 w-1/2">
                            <label class="block text-sm font-medium mb-2">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border-gray-300 rounded-md" placeholder="Enter email address">

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4 w-1/2">
                            <label class="block text-sm font-medium mb-2">
                                Role
                            </label>

                            <select name="role" class="w-full border-gray-300 rounded-md">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Member">Member</option>
                            </select>

                            @error('role')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-gray-800 text-white rounded-md">
                        Send Invite
                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>