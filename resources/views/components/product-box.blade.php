<div
    class="relative m-10 flex w-full max-w-xs flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
    <a class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-xl" href="{{route('product', ['id' => $product->id])}}">
        <img class="object-cover w-full h-full-"
             src="{{asset('img/products/' . $product->image)}}"
             alt="product image"/>
        @if(isset($product->category))
            <span
                class="absolute top-0 left-0 m-2 rounded-full bg-black px-2 text-center text-sm font-medium text-white">{{$product->category->name}}</span>
        @endif
    </a>
    <div class="mt-4 px-5 pb-5">
        <a href="#">
            <h5 class="text-xl tracking-tight text-slate-900">{{$product->name}}</h5>
        </a>

        <div class="flex flex-wrap">
            @foreach($product->colors as $color)
                <div class="py-1 px-4 shadow-md rounded-full mr-2 mt-2" style="background-color: {{$color->code}}"></div>
            @endforeach

        </div>

        <div class="mt-2 mb-5 flex items-center justify-between">
            <p>
                <span class="text-3xl font-bold text-slate-900">${{$product->price / 100}}</span>
            </p>
        </div>
    </div>
</div>
