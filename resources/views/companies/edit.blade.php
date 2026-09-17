<x-app-layout>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Edit Company
                </h1>

                <form method="POST"
                      action="{{ route('companies.update', $company) }}">

                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Company Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $company->name) }}"
                            class="w-1/2 border-gray-300 rounded-md"
                        >

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md">
                            Update Company
                        </button>
                        

                        <a href="{{ route('companies.index') }}"
                           class="ml-2 px-4 py-3 bg-gray-200 rounded-md">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>