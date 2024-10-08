<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 gap-3 flex flex-col">
        <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Cadastrar Produto
        </button>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-auto shadow-sm sm:rounded-lg">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                        <th class="py-3 px-6 border-b border-gray-300 text-left">Nome</th>
                        <th class="py-3 px-6 border-b border-gray-300 text-left">Valor</th>
                        <th class="py-3 px-6 border-b border-gray-300 text-left">Sufixo</th>
                        <th class="py-3 px-6 border-b border-gray-300 text-left">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="py-4 px-6 border-b border-gray-300">{{$product['name']}}</td>
                            <td class="py-4 px-6 border-b border-gray-300">{{\App\Helpers\AmountHelper::formatAmountToMoneyReal($product['amount'])}}</td>
                            <td class="py-4 px-6 border-b border-gray-300">{{$product['sufix']}}</td>
                            <td class="py-4 px-6 border-b border-gray-300">
                                <a href="{{route('edit-product', ['id' => $product['id']])}}"><button class="text-blue-500 hover:underline">Editar</button></a>
                                <a href="{{route('destroy-product', ['id' => $product['id']])}}"><button class="text-red-500 hover:underline">Excluir</button></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
