@props(['headers' => []])

<div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
    <table class="min-w-full divide-y divide-gray-200">
        @if(!empty($headers) || isset($head))
            <thead class="bg-gray-50">
                <tr>
                    @if(isset($head))
                        {{ $head }}
                    @else
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    @endif
                </tr>
            </thead>
        @endif
        <tbody class="bg-white divide-y divide-gray-100">
            {{ $slot }}
        </tbody>
    </table>
    
    @if(isset($pagination))
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $pagination }}
        </div>
    @endif
</div>
