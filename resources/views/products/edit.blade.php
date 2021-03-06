<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-gray-800 leading-tight">
            Editar o produto
        </h2>
    </x-slot>

    @if($errors->any())
    <div class="max-w-2xl mx-auto mt-4" role="alert">
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Erro!
        </div>

        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
    @endif

    <form method="POST" class="max-w-2xl px-6 py-6 bg-white shadow-2xl mt-6 rounded-md mx-auto"
        action="{{route('products.update',$product->id)}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="name">Nome</label>
            <input type="text"
                class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                name="name" placeholder="Digite o nome do produto" value="{{$product->name}}">
        </div>

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="description">Descrição</label>
            <textarea type="text" name="description"
                class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none">{{$product->description}}</textarea>
        </div>

        <div class="flex">
            <div class="w-1/3 pr-3 mb-6">
                <label class='uppercase text-teal-700 font-bold text-base' for="price">Preço</label>
                <input type="number"
                    class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                    name="price" placeholder="Em R$" value="{{ $product->price }}">
            </div>

            <div class="w-1/3 px-3 mb-6">
                <label class='uppercase text-teal-700 font-bold text-base' for="discount">Desconto</label>
                <input type="number"
                    class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                    name="discount" placeholder="Em %" value="{{ $product->discount }}">
            </div>

            <div class="w-1/3 pl-3 mb-6">
                <label class='uppercase text-teal-700 font-bold text-base' for="stock">Estoque</label>
                <input type="number"
                    class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                    name="stock" placeholder="Quantidade" value="{{ $product->stock }}">
            </div>
        </div>

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="category_id">Categoria</label>
            <select class="w-full bg-gray-200 rounded py-2 px-2" name="category_id">
                @foreach ($categories as $category)
                <option value="{{$category->id}}" @if ($category->id == $product->Category->id) {{ 'selected' }}@endif>
                    {{$category->name}}
                </option>
                @endforeach
            </select>
        </div>

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="image">Imagem atual</label>

            <img src="{{ asset('storage/' .$product->image) }}">
        </div>

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="image">Atualizar imagem</label>

            <input class="w-full bg-gray-200 rounded py-2 px-2" type="file" name="image" id="image"
                accept="image/png, image/jpeg, image/jpg">
        </div>

        <div class="flex mt-6">
            <button type="submit"
                class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold text-xl py-2 px-4 rounded-md shadow-lg focus:outline-none">
                Editar Produto
            </button>
        </div>
    </form>
</x-app-layout>
