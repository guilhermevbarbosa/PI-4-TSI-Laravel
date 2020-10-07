<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            Produtos
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 mt-5">
        <div class="flex justify-end">
            <a href="{{route('products.create')}}"
                class="bg-teal-500 hover:bg-teal-600 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Novo
                Produto</a>
        </div>

        <table class="table-auto w-full bg-white mt-4">
            <thead>
                <th class="px-4 py-4 text-left text-gray-500 uppercase"></th>
                <th></th>
                <th></th>
                <th></th>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                <tr>
                    <td class="px-4 py-4 w-full">
                        <div class="flex">
                            <div class="">
                                <img src="{{$product->image}}" class="h-10 w-10">
                            </div>
                            <div class="ml-4">
                                <span class="block">{{ $product->name }}</span>
                                <span class="block text-gray-500 text-sm">{{ $product->Category->name }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ route('products.show', $product->id) }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Visualizar</a>
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ route('products.edit', $product->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Editar</a>
                    </td>
                    <td class="px-4 py-4">
                        <form action="{{ route('products.destroy', $product->id) }}" class="d-inline" method="POST"
                            onsubmit="return confirm('Você quer realmente apagar o produto?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Apagar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</x-app-layout>
