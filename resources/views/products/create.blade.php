<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-gray-800 leading-tight">
            Criar produto
        </h2>
    </x-slot>

    <form method="POST" class="max-w-2xl px-4 py-4 bg-white shadow mt-4 rounded-md mx-auto"
        action="{{ route('products.store') }}">
        @csrf

        <div class="w-full mb-4">
            <label class='uppercase text-gray-500 font-bold text-md' for="name">Nome</label>
            <input type="text"
                class="w-full bg-gray-100 text-gray-600 rounded py-2 px-2 focus:bg-gray-50 focus:outline-none"
                name="name" placeholder="Digite o nome do produto">
        </div>

        <div class="w-full mb-4">
            <label class='uppercase text-gray-500 font-bold text-md' for="description">Descrição</label>
            <textarea type="text" name="description"
                class="w-full bg-gray-100 text-gray-600 rounded py-2 px-2 focus:bg-gray-50 focus:outline-none"
                placeholder="Digite a descrição"></textarea>
        </div>

        <div class="w-full mb-4">
            <label class='uppercase text-gray-500 font-bold text-md' for="price">Preço</label>
            <input type="number"
                class="w-full bg-gray-100 text-gray-600 rounded py-2 px-2 focus:bg-gray-50 focus:outline-none"
                name="price" placeholder="Digite o valor em reais" placeholder="Digite o valor em reais">
        </div>

        <div class="flex mt-4">
            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-700 text-white font-bold text-xl py-2 px-4 rounded-md shadow">
                Criar Produto</button> </div>
    </form>
</x-app-layout>
