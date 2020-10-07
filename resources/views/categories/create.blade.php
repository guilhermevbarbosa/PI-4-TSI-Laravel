<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-gray-800 leading-tight">
            Criar categoria
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
        action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="w-full mb-6">
            <label class='uppercase text-teal-700 font-bold text-base' for="name">Nome</label>
            <input type="text"
                class="w-full bg-gray-200 text-gray-800 rounded py-2 px-2 focus:bg-gray-100 focus:outline-none"
                name="name" placeholder="Digite o nome do produto" value="{{ old('name') }}">
        </div>

        <div class="flex mt-6">
            <button type="submit"
                class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold text-xl py-2 px-4 rounded-md shadow-lg focus:outline-none">
                Criar Produto
            </button>
        </div>
    </form>
</x-app-layout>
