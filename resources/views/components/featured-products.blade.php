{{-- TODO: Add a number of itesm to display option to this component --}}
<div class="flex flex-col items-center">
    <h1 class="text-3xl">
        {{$title}}
    </h1>
    <div class="flex flex-wrap">
        @foreach($products as $product)
            <div class="w-1/4">
                <x-product-box :product="$product"/>
            </div>
        @endforeach
    </div>
</div>
