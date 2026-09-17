<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Companies
                </h1>

                <a href="{{ route('companies.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md">
                    + Add Company
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="ml-6">
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Company Name</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($companies as $company)
                            <tr class="border-t">
                                <td class="px-6 py-4 text-center">
                                    {{ $company->id }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $company->name }}
                                </td>

                                <td class="px-6 py-4 flex gap-2 text-center justify-center">

                                    <a href="{{ route('companies.edit', $company) }}" class="px-3 py-1 bg-gray-200 rounded">
                                        Edit
                                    </a>
                                    <form method="get" action="{{ route('companies.invite', $company) }}">
                                        @csrf

                                        <button type="submit" class="px-3 py-1 bg-gray-800 text-white rounded">

                                            Invite
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('companies.destroy', $company) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="px-3 py-1 bg-gray-800 text-white rounded">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    No companies found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app-layout>