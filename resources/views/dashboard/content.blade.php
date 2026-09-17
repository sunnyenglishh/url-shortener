<div class="space-y-6">

    @if(auth()->user()->role !== \App\Models\User::ROLE_SUPER_ADMIN)
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-xl font-semibold mb-6">
                Generate Short URL
            </h2>

            <form method="POST" action="{{ route('short-urls.store') }}">

                @csrf

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Long URL
                    </label>

                    <input type="url" name="original_url" value="{{ old('original_url') }}"
                        class="w-full border-gray-300 rounded-md" placeholder="e.g. https://example.com/very-long-url"
                        required>

                    @error('original_url')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="mt-4 px-5 py-2 bg-gray-800 text-white rounded-md">
                    Generate
                </button>

            </form>

        </div>
    @endif


    <div class="bg-white shadow rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-semibold">
                Generated Short URLs
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Short URL</th>
                        <th class="text-left py-3">Long URL</th>
                        @if (auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
                            <th class="text-left py-3">Company</th>
                        @endif
                        <th class="text-left py-3">Created By</th>
                        <th class="text-left py-3">Created On</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($shortUrls as $shortUrl)

                        <tr class="border-b">

                            <td class="py-3 text-center">
                                <a href="{{ url($shortUrl->short_code) }}" target="_blank" class="text-blue-600">
                                    {{ url($shortUrl->short_code) }}
                                </a>
                            </td>

                            <td class="py-3 text-center">
                                {{ Str::limit($shortUrl->original_url, 40) }}
                            </td>

                            @if (auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
                                <td class="py-3 text-center">
                                    {{ $shortUrl->company->name ?? 'N/A' }}
                                </td>
                            @endif

                            <td class="py-3 text-center">
                                {{ $shortUrl->user->name }}
                            </td>

                            <td class="py-3 text-center">
                                {{ $shortUrl->created_at->format('d M Y') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>