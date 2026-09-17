<x-app-layout>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Complete Registration
                </h1>

                <p class="mb-6">
                    Company:
                    <strong>{{ $invitation->company->name }}</strong>
                </p>

                <form method="POST"
                      action="{{ route('invitations.register', $invitation->token) }}">

                    @csrf

                    <div class="flex gap-2">

                        <div class="mb-4 w-1/2">
                            <label class="block text-sm font-medium mb-2">
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded-md"
                                placeholder="Enter your name"
                                required
                            >

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4 w-1/2">
                            <label class="block text-sm font-medium mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                value="{{ $invitation->email }}"
                                class="w-full border-gray-300 rounded-md bg-gray-100"
                                disabled
                            >
                        </div>

                    </div>

                    <div class="flex gap-2">

                        <div class="mb-4 w-1/2">
                            <label class="block text-sm font-medium mb-2">
                                Role
                            </label>

                            <input
                                type="text"
                                value="{{ $invitation->role }}"
                                class="w-full border-gray-300 rounded-md bg-gray-100"
                                disabled
                            >
                        </div>

                        <div class="mb-4 w-1/2">
                            <label class="block text-sm font-medium mb-2">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="w-full border-gray-300 rounded-md"
                                placeholder="Enter password"
                                required
                            >

                            @error('password')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    <div class="mb-4 w-1/2">
                        <label class="block text-sm font-medium mb-2">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border-gray-300 rounded-md"
                            placeholder="Confirm password"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="mt-4 px-4 py-2 bg-gray-800 text-white rounded-md"
                    >
                        Register
                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>