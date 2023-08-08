{{-- TODO: Add a number of itesm to display option to this component --}}

<div class="mx-auto container px-4 md:px-6 2xl:px-0 py-12 flex justify-center items-center">
    <div class="flex flex-col jusitfy-start items-start">
        <div class="mt-3">
            <h1 class="text-3xl lg:text-4xl tracking-tight font-semibold leading-8 lg:leading-9 text-gray-800 dark:text-white dark:text-white">
                {{$title}}
            </h1>
        </div>
        <div class="mt-10 lg:mt-12 grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-10 lg:gap-y-0">
            @foreach($products as $product)
                <x-product-box :product="$product"/>
            @endforeach

        </div>

    </div>
</div>

