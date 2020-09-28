<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-gray-800 leading-tight">
            Criar produto
        </h2>
    </x-slot>

    <form method="POST" class="max-w-2xl px-6 py-6 bg-white shadow-2xl mt-6 rounded-md mx-auto"
        action="{{ route('products.store') }}">
        @csrf

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="name">Nome</label>
            <input type="text"
                class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                name="name" placeholder="Digite o nome do produto">
        </div>

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="description">Descrição</label>
            <textarea type="text" name="description"
                class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                placeholder="Digite a descrição"></textarea>
        </div>

        <div class="flex">
            <div class="w-1/3 pr-3 mb-6">
                <label class='uppercase text-teal-700 font-bold text-base' for="price">Preço</label>
                <input type="number"
                    class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                    name="price" placeholder="Em R$">
            </div>

            <div class="w-1/3 px-3 mb-6">
                <label class='uppercase text-teal-700 font-bold text-base' for="discount">Desconto</label>
                <input type="number"
                    class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                    name="discount" placeholder="Em %">
            </div>

            <div class="w-1/3 pl-3 mb-6">
                <label class='uppercase text-teal-700 font-bold text-base' for="stock">Estoque</label>
                <input type="number"
                    class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                    name="stock" placeholder="Quantidade">
            </div>
        </div>

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="image">Imagem</label>
            <input type="file" class="w-full bg-gray-200 rounded py-2 px-2" name="image" value="null">
        </div>

        <div class="flex mt-6">
            <button type="submit"
                class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold text-xl py-2 px-4 rounded-md shadow-lg focus:outline-none">
                Criar Produto
            </button>
        </div>
    </form>
</x-app-layout>
