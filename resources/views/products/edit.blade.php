<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-gray-800 leading-tight">
            Editar o produto
        </h2>
    </x-slot>

    <form method="POST" class="max-w-7xl px-4 py-4 bg-white shadow mt-4 rounded-md mx-auto"
        action="{{route('products.update',$product->id)}}">
        @method('PUT')
        @csrf
        <div class="w-full">
            <label class='uppercase text-gray-700 font-bold text-sm' for="name">Nome:</label>
            <input type="text"
                class="w-full bg-gray-100 text-gray-700 rounded py-2 px-2 focus:bg-gray-50 focus:outline-none"
                name="name" value="{{$product->name}}">
        </div>

        <div class="w-full">
            <label for="description">Descrição:</label>
            <textarea type="text" name="description"
                class="w-full bg-gray-100 text-gray-700 rounded py-2 px-2 focus:bg-gray-50 focus:outline-none">{{$product->description}}</textarea>
        </div>

        <div class="w-full">
            <label for="price">Preço:</label>
            <input type="number"
                class="w-full bg-gray-100 text-gray-700 rounded py-2 px-2 focus:bg-gray-50 focus:outline-none"
                name="price" value="{{$product->price}}" placeholder="Digite o valor em reais">
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold text-xl py-2 px-4 rounded-md shadow">Editar
                Produto</button>
        </div>
    </form>
</x-app-layout>
