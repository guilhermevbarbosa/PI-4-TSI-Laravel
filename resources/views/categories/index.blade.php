<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            Categorias
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 mt-5">
        <div class="flex justify-end">
            <a href="{{route('categories.create')}}"
                class="bg-teal-500 hover:bg-teal-600 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Nova
                Categoria</a>
        </div>

        <table class="table-auto w-full bg-white mt-4">
            <thead>
                <th class="px-4 py-4 text-left text-gray-500 uppercase"></th>
                <th></th>
                <th></th>
                <th></th>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($categories as $category)
                <tr>
                    <td class="px-4 py-4 w-full">
                        <span class="block">{{ $category->name }} ({{$category->products->count()}})</span>
                    </td>

                    <td class="px-4 py-4">
                        <a href="{{ route('categories.show', $category->id) }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Visualizar</a>
                    </td>

                    <td class="px-4 py-4">
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold text-md py-2 px-3 rounded-lg shadow-md">Editar</a>
                    </td>

                    <td class="px-4 py-4">
                        <form action="{{ route('categories.destroy', $category->id) }}" class="d-inline" method="POST"
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
