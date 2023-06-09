<nav aria-label="alternative nav">
    <div
        class="bg-gray-800 shadow-xl h-20 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48 content-center">

        <div
            class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
            <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                <li class="mr-3 flex-1">
                    <a href="{{route('admin.users.index')}}"
                       class="{{ (request()->is('admin/users*')) ? 'border-pink-500' : '' }} block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                        <i class="fas fa-users pr-0 md:pr-3 {{ (request()->is('admin/users*')) ? 'text-pink-500' : '' }}"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Users</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="#"
                       class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                        <i class="fas fa-users pr-0 md:pr-3"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Roles</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{route('admin.order.index')}}"
                       class="{{ (request()->is('admin/order*')) ? 'border-red-500' : '' }} block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                        <i class="fa fa-wallet pr-0 md:pr-3  {{ (request()->is('admin/order*')) ? 'text-red-500' : '' }}"></i>
                        <span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Orders</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{route('admin.products.index')}}"
                       class="{{ (request()->is('admin/products*')) ? 'border-blue-600' : '' }} block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-blue-600">
                        <i class="fas fa-boxes pr-0 md:pr-3 hover:text-blue-600 {{ (request()->is('admin/products*')) ? 'text-blue-600' : '' }}"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Products</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{route('admin.categories.index')}}"
                       class="{{ (request()->is('admin/categories*')) ? 'border-blue-600' : '' }} block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-blue-600">
                        <i class="fas fa-list pr-0 md:pr-3 {{ (request()->is('admin/categories*')) ? 'text-blue-600' : '' }}"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Categories</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{route('admin.colors.index')}}"
                       class="{{ (request()->is('admin/color*')) ? 'border-blue-600' : '' }} block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-blue-600">
                        <i class="fas fa-palette pr-0 md:pr-3 {{ (request()->is('admin/color*')) ? 'text-blue-600' : '' }}"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Colors</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
