<table
    class='mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
    <thead class="bg-gray-900">
    <tr class="text-white text-left">
        @foreach ($headers as $heading)
            <th class="font-semibold text-sm uppercase px-6 py-4">{{$heading}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    {{ $tableBody }}
    </tbody>
</table>
