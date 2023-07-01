{{-- TODO: Add a number of itesm to display option to this component --}}
<div class="flex flex-col items-center">
    <h1 class="text-3xl">
        {{$title}}
    </h1>
    <div class="flex flex-wrap gap-4">
        @foreach($products as $product)
            <x-product-box :product="$product"/>
        @endforeach
    </div>
</div>
